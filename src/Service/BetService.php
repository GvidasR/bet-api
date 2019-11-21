<?php

namespace App\Service;

use App\Entity\Bet;
use App\Entity\BetSelection;
use App\Entity\Player;
use App\Errors\BetslipStructureMismatch;
use App\Errors\DuplicateSelectionFound;
use App\Errors\InsufficientBalance;
use App\Errors\MaximumNumberOfSelections;
use App\Errors\MaximumOdds;
use App\Errors\MaximumStakeAmount;
use App\Errors\MaximumWinAmount;
use App\Errors\MinimumNumberOfSelections;
use App\Errors\MinimumOdds;
use App\Errors\MinimumStakeAmount;
use App\Errors\PreviousActionIsNotFinished;
use App\Validator\Constraints as AppAssert;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints as Assert;

class BetService
{
    /** @var BetValidator $validator */
    private $validator;

    /** @var EntityManager $em */
    private $em;

    /** @var PlayerService $playerService */
    private $playerService;

    /** @var TransactionService $transactionService */
    private $transactionService;

    public function __construct(BetValidator $validator, EntityManagerInterface $em, PlayerService $playerService, TransactionService $transactionService)
    {
        $this->validator = $validator;
        $this->em = $em;
        $this->playerService = $playerService;
        $this->transactionService = $transactionService;
    }

    public function placeBet(&$params)
    {
        if(!$this->validator->validate($params)) {
            return false;
        }
        $player = $this->playerService->getPlayer($params);
        if(!$this->playerService->lockPlayer($player)) {
            if(!array_key_exists('errors',$params)) {
                $params['errors'] = [];
            }
            $params['errors'][] = new PreviousActionIsNotFinished();
            return false;
        }
        $status = false;
        sleep(rand(1,30));
        try {
            $status = $this->placeBetForPlayer($player, $params);
        } finally {
            $this->playerService->unlockPlayer($player);
        }
        return $status;
    }

    private function placeBetForPlayer(Player $player, &$params)
    {
        if(!$this->transactionService->newTransaction($player,$params['stake_amount'])) {
            if(!array_key_exists('errors',$params)) {
                $params['errors'] = [];
            }
            $params['errors'][] = new InsufficientBalance();
            return false;
        }
        $bet = new Bet();
        $bet->setPlayer($player);
        $bet->setStakeAmount($params['stake_amount']);
        $this->em->persist($bet);
        foreach($params['selections'] as $selection)
        {
            $betSelection = new BetSelection();
            $betSelection->setBet($bet);
            $betSelection->setOdds($selection['odds']);
            $betSelection->setSelection($selection['id']);
            $this->em->persist($betSelection);
        }
        $this->em->flush();
        return true;
    }
}

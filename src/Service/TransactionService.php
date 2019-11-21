<?php

namespace App\Service;

use App\Entity\BalanceTransaction;
use App\Entity\Bet;
use App\Entity\BetSelection;
use App\Entity\Player;
use App\Errors\BetslipStructureMismatch;
use App\Errors\DuplicateSelectionFound;
use App\Errors\MaximumNumberOfSelections;
use App\Errors\MaximumOdds;
use App\Errors\MaximumStakeAmount;
use App\Errors\MaximumWinAmount;
use App\Errors\MinimumNumberOfSelections;
use App\Errors\MinimumOdds;
use App\Errors\MinimumStakeAmount;
use App\Validator\Constraints as AppAssert;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;
use Symfony\Component\Serializer\SerializerInterface;
use Symfony\Component\Validator\Constraints as Assert;

class TransactionService
{

    /** @var EntityManager $em */
    private $em;


    public function __construct(EntityManagerInterface $em)
    {
        $this->em = $em;
    }

    public function newTransaction(Player $player, $amount)
    {
        if($player->getBalance() - $amount >= 0) {
            $balanceTransaction = new BalanceTransaction();
            $balanceTransaction->setPlayer($player);
            $balanceTransaction->setAmountBefore($player->getBalance());
            $player->setBalance($player->getBalance() - $amount);
            $balanceTransaction->setAmount($player->getBalance());
            try {
                $this->em->persist($balanceTransaction);
                $this->em->persist($player);
                $this->em->flush();
            } catch (ORMException $e) {
                return false;
            }
            return true;
        }
        return false;
    }
}

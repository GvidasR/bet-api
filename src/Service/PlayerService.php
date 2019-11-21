<?php

namespace App\Service;

use App\Entity\Player;
use Cassandra\Date;
use Doctrine\ORM\EntityManager;
use Doctrine\ORM\EntityManagerInterface;
use Doctrine\ORM\ORMException;
use Symfony\Component\DependencyInjection\ParameterBag\ParameterBagInterface;

class PlayerService
{
    /** @var EntityManager $em */
    private $em;

    private $playerParameters;

    private $lockDuration;

    public function __construct(EntityManagerInterface $em, ParameterBagInterface $parameterBag)
    {
        $this->em = $em;
        $this->playerParameters = $parameterBag->get('player');
        $this->lockDuration = $parameterBag->get('lock_duration');
    }


    public function getPlayer($params)
    {
        $player = $this->em->getRepository(Player::class)->find($params['player_id']);
        if (empty($player)) {
            $player = new Player();
            $player->setId($params['player_id']);
            $player->setBalance($this->playerParameters['initial_balance']);
            try {
                $this->em->persist($player);
                $this->em->flush();
            } catch (ORMException $e) {
                return false;
            }
        }
        return $player;
    }

    public function lockPlayer(Player $player)
    {
        if (!empty($player->getLockTill()) && ($player->getLockTill() > new \DateTime())) {
            return false;
        } else {
            $player->setLockTill((new \DateTime())->add((new \DateInterval('PT' . $this->lockDuration . 'S'))));
            try {
                $this->em->persist($player);
                $this->em->flush();
            } catch (ORMException $e) {
                return false;
            }
            return true;
        }
    }

    public function unlockPlayer(Player $player)
    {
        $player->setLockTill(null);
        try {
            $this->em->persist($player);
            $this->em->flush();
        } catch (ORMException $e) {
            return false;
        }
        return true;
    }
}

<?php

namespace App\Entity;

use App\Entity\Traits\TimestampableTrait;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="bet")
 * @ORM\Entity
 */
class Bet
{
    use TimestampableTrait;

    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="stake_amount", type="float", nullable=false)
     */
    private $stakeAmount;

    /**
     * @ORM\ManyToOne(targetEntity="Player")
     * @ORM\JoinColumn(name="player_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $player;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getStakeAmount(): ?float
    {
        return $this->stakeAmount;
    }

    public function setStakeAmount(float $stakeAmount): self
    {
        $this->stakeAmount = $stakeAmount;

        return $this;
    }

    public function getPlayer(): ?Player
    {
        return $this->player;
    }

    public function setPlayer(?Player $player): self
    {
        $this->player = $player;

        return $this;
    }
}

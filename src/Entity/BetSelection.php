<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="bet_selection")
 * @ORM\Entity
 */
class BetSelection
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="IDENTITY")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity="Bet")
     * @ORM\JoinColumn(name="bet_id", referencedColumnName="id", onDelete="CASCADE")
     */
    private $bet;

    /**
     * @var int
     *
     * @ORM\Column(name="selection_id", type="integer", nullable=false)
     */
    private $selection;

    /**
     * @var float
     *
     * @ORM\Column(name="odds", type="float", nullable=false)
     */
    private $odds;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSelection(): ?int
    {
        return $this->selection;
    }

    public function setSelection(int $selection): self
    {
        $this->selection = $selection;

        return $this;
    }

    public function getOdds(): ?float
    {
        return $this->odds;
    }

    public function setOdds(float $odds): self
    {
        $this->odds = $odds;

        return $this;
    }

    public function getBet(): ?Bet
    {
        return $this->bet;
    }

    public function setBet(?Bet $bet): self
    {
        $this->bet = $bet;

        return $this;
    }
}

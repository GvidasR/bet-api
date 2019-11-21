<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Table(name="player")
 * @ORM\Entity
 * @ORM\HasLifecycleCallbacks()
 */
class Player
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer", nullable=false)
     * @ORM\Id
     */
    private $id;

    /**
     * @var float
     *
     * @ORM\Column(name="balance", type="float", nullable=false)
     */
    private $balance;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lock_till", type="datetime", nullable=true)
     */
    private $lockTill;

    public function setId(int $id): void
    {
        $this->id = $id;
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBalance(): ?float
    {
        return $this->balance;
    }

    public function setBalance(float $balance): self
    {
        $this->balance = $balance;

        return $this;
    }

    public function getLockTill(): ?\DateTime
    {
        return $this->lockTill;
    }

    public function setLockTill(?\DateTime $lockTill): self
    {
        $this->lockTill = $lockTill;

        return $this;
    }



}

<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;

trait TimestampableTrait
{
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created_at", type="datetime")
     */
    private $createdAt;


    public function init()
    {
        $this->createdAt = new \DateTime();
    }

    public function __construct()
    {
        $this->init();
    }

    public function getCreatedAt()
    {
        return $this->createdAt;
    }

}

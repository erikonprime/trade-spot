<?php

namespace App\Traits;

use DateTime;
use DateTimeInterface;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\DBAL\Types\Types;

trait Timestamp
{
    /**
     * @var DateTimeInterface
     */
    #[ORM\Column(type: Types::DATETIME_MUTABLE, nullable: false)]
    private DateTimeInterface $createdAt;

    /**
     * @var DateTimeInterface
     */
    #[ORM\Column(type:Types::DATETIME_MUTABLE, nullable: false)]
    private DateTimeInterface $updatedAt;

    #[ORM\PrePersist]
    public function setCreatedAt(): self
    {
        $this->createdAt = new DateTime();
        $this->updatedAt = new DateTime();

        return $this;
    }

    public function getCreatedAt(): DateTimeInterface
    {
        return $this->createdAt;
    }

    #[ORM\PreUpdate]
    public function setUpdatedAt(): self
    {
        $this->updatedAt = new DateTime();

        return $this;
    }

    public function getUpdatedAt(): DateTimeInterface
    {
        return $this->updatedAt;
    }
}

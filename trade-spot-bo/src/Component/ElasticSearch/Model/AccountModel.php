<?php

namespace App\Component\ElasticSearch\Model;

use DateTimeInterface;

class AccountModel extends AbstractModel
{
    public function __construct(
        protected readonly int               $id,
        protected readonly string            $firstName,
        protected readonly string            $lastname,
        protected readonly AddressModel      $address,
        protected readonly DateTimeInterface $createdAt,
        protected readonly DateTimeInterface $updatedAt,
    )
    {
    }

    public function getId(): int
    {
        return $this->id;
    }
}

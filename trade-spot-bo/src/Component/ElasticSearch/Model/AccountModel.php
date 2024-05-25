<?php

namespace App\Component\ElasticSearch\Model;

use DateTime;

class AccountModel extends AbstractModel
{
    public function __construct(
        protected readonly int          $id,
        protected readonly string       $firstName,
        protected readonly string       $lastname,
        protected readonly AddressModel $addressModel,
        protected readonly DateTime     $createdAt,
        protected readonly DateTime     $updatedAt,
    )
    {
    }

}

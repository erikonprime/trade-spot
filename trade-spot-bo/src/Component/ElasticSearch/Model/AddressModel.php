<?php

namespace App\Component\ElasticSearch\Model;

class AddressModel extends AbstractModel
{
    public function __construct(
        protected readonly int    $id,
        protected readonly string $zipCode,
        protected readonly string $city,
        protected readonly string $country,
        protected readonly string $street,
        protected readonly string $phone,
    )
    {
    }

}

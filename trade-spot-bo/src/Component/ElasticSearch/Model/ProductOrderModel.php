<?php

namespace App\Component\ElasticSearch\Model;

use DateTime;

class ProductOrderModel extends AbstractModel
{
    public function __construct(
        protected readonly int          $id,
        protected readonly AccountModel $customerModel,
        protected readonly AccountModel $sellerModel,
        protected readonly ProductModel $productModel,
        protected readonly string       $status,
        protected readonly DateTime     $createdAt,
        protected readonly DateTime     $updatedAt,
    )
    {
    }
}

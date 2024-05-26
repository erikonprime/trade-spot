<?php

namespace App\Component\ElasticSearch\Model;

use App\Component\Doctrine\Types\EnumProductOrderStatus;
use DateTimeInterface;

class ProductOrdersModel extends AbstractModel
{
    public function __construct(
        protected readonly int                    $id,
        protected readonly AccountModel           $customer,
        protected readonly ProductModel           $product,
        protected readonly EnumProductOrderStatus $status,
        protected readonly DateTimeInterface      $createdAt,
        protected readonly DateTimeInterface      $updatedAt,
    )
    {
    }
}

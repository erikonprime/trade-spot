<?php

namespace App\Component\ElasticSearch\Model;

use App\Component\Doctrine\Types\EnumProductStatus;
use DateTimeInterface;

class ProductModel extends AbstractModel
{
    public function __construct(
        protected readonly int $id,
        protected readonly string $name,
        protected readonly float $price,
        protected readonly string $description,
        protected readonly EnumProductStatus $status,
        protected readonly CategoryModel $category,
        protected readonly DateTimeInterface     $createdAt,
        protected readonly DateTimeInterface     $updatedAt,
    ) {
    }

    public function getId(): int
    {
        return $this->id;
    }
}

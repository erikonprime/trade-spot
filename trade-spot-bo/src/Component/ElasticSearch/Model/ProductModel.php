<?php

namespace App\Component\ElasticSearch\Model;

use DateTime;

class ProductModel extends AbstractModel
{
    public function __construct(
        protected readonly int $id,
        protected readonly string $name,
        protected readonly float $price,
        protected readonly string $description,
        protected readonly string $status,
        protected readonly CategoryModel $categoryModel,
        protected readonly DateTime     $createdAt,
        protected readonly DateTime     $updatedAt,
    ) {
    }
}

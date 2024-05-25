<?php

namespace App\Component\ElasticSearch\Model;

class CategoryModel extends AbstractModel
{
    public function __construct(
        protected readonly int $id,
        protected readonly string $name
    ) {
    }
}

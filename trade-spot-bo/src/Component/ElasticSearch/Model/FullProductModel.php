<?php

namespace App\Component\ElasticSearch\Model;

class FullProductModel extends AbstractModel
{
    public function __construct(
        protected readonly ProductModel $product,
        protected readonly AccountModel $account,
    ) {
    }
}

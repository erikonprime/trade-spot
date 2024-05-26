<?php

namespace App\Component\ElasticSearch\Model;

class FullAccountModel extends AbstractModel
{
    public function __construct(
        protected readonly AccountModel $account,
        protected readonly array $products,
        protected readonly array $productOrders,
    ) {
    }

    public function getId(): int
    {
        return $this->account->getId();
    }

    public function getProducts(): array
    {
        return $this->products;
    }

    public function getAccount(): AccountModel
    {
        return $this->account;
    }
}

<?php

namespace App\Component\ElasticSearch;

use App\Component\ElasticSearch\Model\AccountModel;
use App\Component\ElasticSearch\Model\AddressModel;
use App\Component\ElasticSearch\Model\CategoryModel;
use App\Component\ElasticSearch\Model\FullAccountModel;
use App\Component\ElasticSearch\Model\ProductModel;
use App\Component\ElasticSearch\Model\ProductOrdersModel;
use App\Entity\Account;
use App\Entity\Product;
use App\Entity\ProductOrder;

class Converter
{
    public function entityToModel(Account $account): FullAccountModel
    {
        $products = $this->prepareProducts($account);
        $productOrders = $this->prepareProductOrdersModel($account);

        return new FullAccountModel(
            new AccountModel(
                $account->getId(),
                $account->getFirstName(),
                $account->getLastName(),
                new AddressModel(
                    $account->getAddress()->getId(),
                    $account->getAddress()->getZipCode(),
                    $account->getAddress()->getCity(),
                    $account->getAddress()->getCountry(),
                    $account->getAddress()->getStreet(),
                    $account->getAddress()->getPhone(),
                ),
                $account->getCreatedAt(),
                $account->getUpdatedAt(),
            ),
            $products,
            $productOrders
        );
    }

    private function prepareProducts(Account $account): array
    {
        $array = [];

        /** @var Product $product */
        foreach ($account->getProduct() as $product) {
            $array[] = new ProductModel(
                $product->getId(),
                $product->getName(),
                $product->getPrice(),
                $product->getDescription(),
                $product->getStatus(),
                new CategoryModel(
                    $product->getCategory()->getId(),
                    $product->getCategory()->getName(),
                ),
                $product->getCreatedAt(),
                $product->getUpdatedAt()
            );
        }

        return $array;
    }

    private function prepareProductOrdersModel(Account $account): array
    {
        $array = [];

        /** @var ProductOrder $productOrders */
        foreach ($account->getProductOrders() as $productOrders) {
            $array[] = new ProductOrdersModel(
                $productOrders->getId(),
                new AccountModel(
                    $productOrders->getCustomer()->getId(),
                    $productOrders->getCustomer()->getFirstName(),
                    $productOrders->getCustomer()->getLastName(),
                    new AddressModel(
                        $productOrders->getCustomer()->getAddress()->getId(),
                        $productOrders->getCustomer()->getAddress()->getZipCode(),
                        $productOrders->getCustomer()->getAddress()->getCity(),
                        $productOrders->getCustomer()->getAddress()->getCountry(),
                        $productOrders->getCustomer()->getAddress()->getStreet(),
                        $productOrders->getCustomer()->getAddress()->getPhone(),
                    ),
                    $productOrders->getCustomer()->getCreatedAt(),
                    $productOrders->getCustomer()->getUpdatedAt(),
                ),
                new ProductModel(
                    $productOrders->getProduct()->getId(),
                    $productOrders->getProduct()->getName(),
                    $productOrders->getProduct()->getPrice(),
                    $productOrders->getProduct()->getDescription(),
                    $productOrders->getProduct()->getStatus(),
                    new CategoryModel(
                        $productOrders->getProduct()->getCategory()->getId(),
                        $productOrders->getProduct()->getCategory()->getName(),
                    ),
                    $productOrders->getProduct()->getCreatedAt(),
                    $productOrders->getProduct()->getUpdatedAt()
                ),
                $productOrders->getStatus(),
                $productOrders->getCreatedAt(),
                $productOrders->getUpdatedAt(),
            );
        }

        return $array;
    }
}

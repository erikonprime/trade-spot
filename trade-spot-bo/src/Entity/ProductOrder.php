<?php

namespace App\Entity;

use App\Repository\ProductOrderRepository;
use App\Traits\Timestamp;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ProductOrderRepository::class)]
#[ORM\HasLifecycleCallbacks]
class ProductOrder
{
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\ManyToOne(inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private Account $customer;

    #[ORM\ManyToOne(inversedBy: 'sellerOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private Account $seller;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private Product $product;

    public function getId(): int
    {
        return $this->id;
    }

    public function getCustomer(): Account
    {
        return $this->customer;
    }

    public function setCustomer(Account $customer): static
    {
        $this->customer = $customer;

        return $this;
    }

    public function getSeller(): Account
    {
        return $this->seller;
    }

    public function setSeller(Account $seller): static
    {
        $this->seller = $seller;

        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    public function setProduct(Product $product): static
    {
        $this->product = $product;

        return $this;
    }
}

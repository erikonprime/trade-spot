<?php

namespace App\Entity;

use App\Component\Doctrine\Types\EnumProductOrderStatus;
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

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private Product $product;

    #[ORM\Column(type: "string", enumType: EnumProductOrderStatus::class)]
    private EnumProductOrderStatus $status = EnumProductOrderStatus::ORDER_STATUS_NEW;

    #[ORM\ManyToOne(inversedBy: 'productOrders')]
    #[ORM\JoinColumn(nullable: false)]
    private Account $customer;

    public function getId(): int
    {
        return $this->id;
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

    public function getStatus(): EnumProductOrderStatus
    {
        return $this->status;
    }

    public function setStatus(EnumProductOrderStatus $status): static
    {
        $this->status = $status;

        return $this;
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
}

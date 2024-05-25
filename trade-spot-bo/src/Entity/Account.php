<?php

namespace App\Entity;

use App\Repository\AccountRepository;
use App\Traits\Timestamp;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: AccountRepository::class)]
#[ORM\HasLifecycleCallbacks]
class Account
{
    use Timestamp;

    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private int $id;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private User $user;

    #[ORM\OneToMany(targetEntity: Product::class, mappedBy: 'account', orphanRemoval: true)]
    private Collection $product;

    #[ORM\OneToMany(targetEntity: ProductOrder::class, mappedBy: 'customer', orphanRemoval: true)]
    private Collection $customerOrders;

    #[ORM\OneToMany(targetEntity: ProductOrder::class, mappedBy: 'seller', orphanRemoval: true)]
    private Collection $sellerOrders;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    #[ORM\JoinColumn(nullable: false)]
    private ?Address $address = null;

    public function __construct()
    {
        $this->product = new ArrayCollection();
        $this->customerOrders = new ArrayCollection();
        $this->sellerOrders = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getUser(): User
    {
        return $this->user;
    }

    public function setUser(User $user): static
    {
        $this->user = $user;

        return $this;
    }

    /**
     * @return Collection<int, Product>
     */
    public function getProduct(): Collection
    {
        return $this->product;
    }

    public function addProduct(Product $product): static
    {
        if (!$this->product->contains($product)) {
            $this->product->add($product);
            $product->setAccount($this);
        }

        return $this;
    }

    public function removeProduct(Product $product): static
    {
        if ($this->product->removeElement($product)) {
            // set the owning side to null (unless already changed)
            if ($product->getAccount() === $this) {
                $product->setAccount(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductOrder>
     */
    public function getCustomerOrders(): Collection
    {
        return $this->customerOrders;
    }

    public function addOrder(ProductOrder $order): static
    {
        if (!$this->customerOrders->contains($order)) {
            $this->customerOrders->add($order);
            $order->setCustomer($this);
        }

        return $this;
    }

    public function removeOrder(ProductOrder $order): static
    {
        if ($this->customerOrders->removeElement($order)) {
            // set the owning side to null (unless already changed)
            if ($order->getCustomer() === $this) {
                $order->setCustomer(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, ProductOrder>
     */
    public function getSellerOrders(): Collection
    {
        return $this->sellerOrders;
    }

    public function addSellerOrder(ProductOrder $sellerOrder): static
    {
        if (!$this->sellerOrders->contains($sellerOrder)) {
            $this->sellerOrders->add($sellerOrder);
            $sellerOrder->setSeller($this);
        }

        return $this;
    }

    public function removeSellerOrder(ProductOrder $sellerOrder): static
    {
        if ($this->sellerOrders->removeElement($sellerOrder)) {
            // set the owning side to null (unless already changed)
            if ($sellerOrder->getSeller() === $this) {
                $sellerOrder->setSeller(null);
            }
        }

        return $this;
    }

    public function getAddress(): ?Address
    {
        return $this->address;
    }

    public function setAddress(Address $address): static
    {
        $this->address = $address;

        return $this;
    }
}

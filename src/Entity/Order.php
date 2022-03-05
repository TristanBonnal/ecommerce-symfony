<?php

namespace App\Entity;

use App\Repository\OrderRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: OrderRepository::class)]
#[ORM\Table(name: '`order`')]
class Order
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column(type: 'integer')]
    private $id;

    #[ORM\ManyToOne(targetEntity: User::class, inversedBy: 'orders')]
    #[ORM\JoinColumn(nullable: false)]
    private $user;

    #[ORM\Column(type: 'datetime')]
    private $createdAt;

    #[ORM\Column(type: 'string', length: 255)]
    private $carrierName;

    #[ORM\Column(type: 'string', length: 255)]
    private $carrierPrice;

    #[ORM\Column(type: 'text')]
    private $delivery;

    #[ORM\OneToMany(mappedBy: 'bindedOrder', targetEntity: OrderDetails::class)]
    private $orderDetails;

    #[ORM\Column(type: 'boolean')]
    private $isPaid;

    public function __construct()
    {
        $this->orderDetails = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUser(): ?User
    {
        return $this->user;
    }

    public function setUser(?User $user): self
    {
        $this->user = $user;

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->createdAt;
    }

    public function setCreatedAt(\DateTimeInterface $createdAt): self
    {
        $this->createdAt = $createdAt;

        return $this;
    }

    public function getCarrierName(): ?string
    {
        return $this->carrierName;
    }

    public function setCarrierName(string $carrierName): self
    {
        $this->carrierName = $carrierName;

        return $this;
    }

    public function getCarrierPrice(): ?string
    {
        return $this->carrierPrice;
    }

    public function setCarrierPrice(string $carrierPrice): self
    {
        $this->carrierPrice = $carrierPrice;

        return $this;
    }

    public function getDelivery(): ?string
    {
        return $this->delivery;
    }

    public function setDelivery(string $delivery): self
    {
        $this->delivery = $delivery;

        return $this;
    }

    /**
     * @return Collection|OrderDetails[]
     */
    public function getOrderDetails(): Collection
    {
        return $this->orderDetails;
    }

    public function addOderDetail(OrderDetails $oderDetail): self
    {
        if (!$this->orderDetails->contains($oderDetail)) {
            $this->orderDetails[] = $oderDetail;
            $oderDetail->setBindedOrder($this);
        }

        return $this;
    }

    public function removeOderDetail(OrderDetails $oderDetail): self
    {
        if ($this->orderDetails->removeElement($oderDetail)) {
            // set the owning side to null (unless already changed)
            if ($oderDetail->getBindedOrder() === $this) {
                $oderDetail->setBindedOrder(null);
            }
        }

        return $this;
    }

    public function getIsPaid(): ?bool
    {
        return $this->isPaid;
    }

    public function setIsPaid(bool $isPaid): self
    {
        $this->isPaid = $isPaid;

        return $this;
    }

    public function getTotal():float
    {
        $total = 0;
        foreach ($this->getOrderDetails() as $product) {
            $total += $product->getTotal();
        }
        return $total;
  
    }
}

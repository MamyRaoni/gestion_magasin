<?php

namespace App\Entity;

use App\Repository\StockRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: StockRepository::class)]
class Stock
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $initial = null;

    #[ORM\Column]
    private ?int $final = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTime $date = null;

    #[ORM\OneToOne(cascade: ['persist', 'remove'])]
    private ?Products $product = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getInitial(): ?int
    {
        return $this->initial;
    }

    public function setInitial(int $initial): static
    {
        $this->initial = $initial;

        return $this;
    }

    public function getFinal(): ?int
    {
        return $this->final;
    }

    public function setFinal(int $final): static
    {
        $this->final = $final;

        return $this;
    }

    public function getDate(): ?\DateTime
    {
        return $this->date;
    }

    public function setDate(\DateTime $date): static
    {
        $this->date = $date;

        return $this;
    }

    public function getProduct(): ?Products
    {
        return $this->product;
    }

    public function setProduct(?Products $product): static
    {
        $this->product = $product;

        return $this;
    }
}

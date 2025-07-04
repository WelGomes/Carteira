<?php

namespace Welbert\Carteira\model;

final class Coin 
{

    private int $id;
    private string $symbol;
    private string $name;
    private string $image;
    private float $price;
    private float $quantity;
    private int $caseId;

    public function __construct(
        string $symbol,
        string $name,
        string $image,
        float $price,
        float $quantity,
        int $caseId,
    )
    {
         $this->symbol = $symbol;
         $this->name = $name;
         $this->image = $image;
         $this->price = $price;
         $this->quantity = $quantity;
         $this->caseId = $caseId;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
    public function getId(): int
    {
        return $this->id;
    }

    public function setSymbol(string $symbol): void
    {
        $this->symbol = $symbol;
    }
    public function getSymbol(): string
    {
        return $this->symbol;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }
    public function getName(): string
    {
        return $this->name;
    }

    public function setImage(string $image): void
    {
        $this->image = $image;
    }
    public function getImage(): string
    {
        return $this->image;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }
    public function getPrice(): float
    {
        return $this->price;
    }

    public function setQuantity(float $quantity): void
    {
        $this->quantity = $quantity;
    }
    public function getQuantity(): float
    {
        return $this->quantity;
    }

    public function setCaseId(int $caseId): void
    {
        $this->caseId = $caseId;
    }
    public function getCaseId(): int
    {
        return $this->caseId;
    }

}
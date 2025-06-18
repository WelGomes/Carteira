<?php

namespace projeto\src\model;

final class Coin
{

    private string $name;
    private string $symbol;
    private string $image;
    private float $price;

    public function __construct(
        string $name,
        string $symbol,
        string $image,
        float $price
    ) {
        $this->name = $name;
        $this->symbol = $symbol;
        $this->image = $image;
        $this->price = $price;
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getSymbol(): string
    {
        return $this->symbol;
    }
    public function getImage(): string
    {
        return $this->image;
    }

    public function getPrice(): float
    {
        return $this->price;
    }
}

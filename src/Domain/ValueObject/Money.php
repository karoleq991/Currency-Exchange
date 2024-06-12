<?php

namespace Domain\ValueObject;

class Money
{
    private Currency $currency;
    private float $amount;

    public function __construct(Currency $currency, float $amount)
    {
        $this->currency = $currency;
        $this->amount = $amount;
    }

    public function getCurrency(): Currency
    {
        return $this->currency;
    }

    public function getAmount(): float
    {
        return $this->amount;
    }

    public function add(Money $money): Money
    {
        if ($this->currency->getCode() !== $money->getCurrency()->getCode()) {
            throw new \InvalidArgumentException('Various currencies');
        }
        return new Money($this->currency, $this->amount + $money->getAmount());
    }

    public function subtract(Money $money): Money
    {
        if ($this->currency->getCode() !== $money->getCurrency()->getCode()) {
            throw new \InvalidArgumentException('Various currencies');
        }
        return new Money($this->currency, $this->amount - $money->getAmount());
    }
}

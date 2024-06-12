<?php

namespace Domain\Entity;

use Domain\ValueObject\Currency;

class ExchangeRate
{
    private Currency $from;
    private Currency $to;
    private float $rate;

    public function __construct(Currency $from, Currency $to, float $rate)
    {
        $this->from = $from;
        $this->to = $to;
        $this->rate = $rate;
    }

    public function getFrom(): Currency
    {
        return $this->from;
    }

    public function getTo(): Currency
    {
        return $this->to;
    }

    public function getRate(): float
    {
        return $this->rate;
    }

    public function convert(float $amount): float
    {
        return $amount * $this->rate;
    }
}

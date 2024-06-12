<?php

namespace Domain\Service;

use Domain\Entity\ExchangeRate;
use Domain\ValueObject\Money;
use Domain\ValueObject\Currency;

class ExchangeService
{
    private array $exchangeRates;

    public function __construct(array $exchangeRates)
    {
        $this->exchangeRates = $exchangeRates;
    }

    public function exchange(Money $money, Currency $targetCurrency, bool $isSelling): Money
    {
        foreach ($this->exchangeRates as $rate) {
            if ($rate->getFrom()->getCode() === $money->getCurrency()->getCode() &&
                $rate->getTo()->getCode() === $targetCurrency->getCode()) {

                if ($isSelling) {
                    $amountAfterExchange = $rate->convert($money->getAmount());
                    $fee = $amountAfterExchange * 0.01;
                    $finalAmount = $amountAfterExchange - $fee;
                } else {
                    $fee = $money->getAmount() * 0.01;
                    $amountAfterExchange = $rate->convert($money->getAmount() + $fee);
                    $finalAmount = $amountAfterExchange;
                }

                return new Money($targetCurrency, $finalAmount);
            }
        }

        throw new \InvalidArgumentException('No exchange rate found');
    }
}

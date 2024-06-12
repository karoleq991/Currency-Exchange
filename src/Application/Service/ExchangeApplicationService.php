<?php

namespace Application\Service;

use Domain\Service\ExchangeService;
use Domain\ValueObject\Currency;
use Domain\ValueObject\Money;

class ExchangeApplicationService
{
    private ExchangeService $exchangeService;

    public function __construct(ExchangeService $exchangeService)
    {
        $this->exchangeService = $exchangeService;
    }

    public function executeExchange(string $fromCurrency, string $toCurrency, float $amount): Money
    {
        $money = new Money(new Currency($fromCurrency), $amount);
        $targetCurrency = new Currency($toCurrency);

        return $this->exchangeService->exchange($money, $targetCurrency);
    }
}

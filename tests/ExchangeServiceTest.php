<?php

use PHPUnit\Framework\TestCase;
use Domain\ValueObject\Currency;
use Domain\ValueObject\Money;
use Domain\Entity\ExchangeRate;
use Domain\Service\ExchangeService;

class ExchangeServiceTest extends TestCase
{
    public function testExchangeEurToGbp()
    {
        $exchangeRate = new ExchangeRate(new Currency('EUR'), new Currency('GBP'), 1.5678);
        $service = new ExchangeService([$exchangeRate]);

        $money = new Money(new Currency('EUR'), 100);
        $result = $service->exchange($money, new Currency('GBP'), true);

        $this->assertEquals(155.21, round($result->getAmount(), 2));
    }

    public function testExchangeGbpToEur()
    {
        $exchangeRate = new ExchangeRate(new Currency('GBP'), new Currency('EUR'), 1.5432);
        $service = new ExchangeService([$exchangeRate]);

        $money = new Money(new Currency('GBP'), 100);
        $result = $service->exchange($money, new Currency('EUR'), true);

        $this->assertEquals(152.78, round($result->getAmount(), 2));
    }

    public function testBuyGbpWithEur()
    {
        $exchangeRate = new ExchangeRate(new Currency('EUR'), new Currency('GBP'), 1.5678);
        $service = new ExchangeService([$exchangeRate]);

        $money = new Money(new Currency('EUR'), 100);
        $result = $service->exchange($money, new Currency('GBP'), false);

        $this->assertEquals(158.35, round($result->getAmount(), 2));
    }

    public function testBuyEurWithGbp()
    {
        $exchangeRate = new ExchangeRate(new Currency('GBP'), new Currency('EUR'), 1.5432);
        $service = new ExchangeService([$exchangeRate]);

        $money = new Money(new Currency('GBP'), 100);
        $result = $service->exchange($money, new Currency('EUR'), false);

        $this->assertEquals(155.86, round($result->getAmount(), 2));
    }
}

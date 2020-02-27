<?php

/*
    Тариф базовый:
    Цена за 1 км = 0 руб.
    Цена за 60 мин = 200 руб.
    Округление до 60 минут в большую сторону
*/

class TariffHourly extends AbstractMainTariff
{
    use AdditionalDriverTrait;

    public function __construct($distanceKm, $durationHours, $driverAge, $useGps = false, $useAdditionalDriver = false)
    {
        $this->pricePerKilometer = TARIFF_HOURLY_PRICE_PER_KM;
        $this->pricePerMinute = TARIFF_HOURLY_PRICE_PER_HOUR / MINUTES_IN_HOUR;   // 200 Рублей за час
        $this->additionalDriverExists = $useAdditionalDriver;
        parent::__construct($distanceKm, $durationHours * MINUTES_IN_HOUR, $driverAge, $useGps, $useAdditionalDriver);
    }

    public function calcPrice()
    {
        $this->priceDuration = ceil($this->currentDurationMinutes / MINUTES_IN_HOUR) * MINUTES_IN_HOUR * $this->pricePerMinute;
        return (($this->priceDistance + $this->priceDuration) * $this->ageMultiplier) + $this->getGpsCost() + $this->getAdditionalDriverCost();
    }
}

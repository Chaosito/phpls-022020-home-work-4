<?php

/*
    Тариф базовый:
    Цена за 1 км = 0 руб.
    Цена за 60 мин = 200 руб.
    Округление до 60 минут в большую сторону
*/

class TariffHourly extends AbstractMainTariff
{
    use GpsTrait, AdditionalDriverTrait;

    public function __construct($distanceKm, $durationHours, $driverAge, $useGps = false, $useAdditionalDriver = false)
    {
        $this->pricePerKilometer = TARIFF_HOURLY_PRICE_PER_KM;
        $this->pricePerMinute = TARIFF_HOURLY_PRICE_PER_HOUR / 60;   // 200 Рублей за час
        $this->gpsActivated = $useGps;
        $this->additionalDriverExists = $useAdditionalDriver;
        parent::__construct($distanceKm, $durationHours * 60, $driverAge, $useGps, $useAdditionalDriver);
    }

    public function calcPrice()
    {
        $this->priceDuration = ceil($this->currentDurationMinutes / 60) * 60 * $this->pricePerMinute;
        return (($this->priceDistance + $this->priceDuration) * $this->ageMultiplier) + $this->getGpsCost() + $this->getAdditionalDriverCost();
    }
}

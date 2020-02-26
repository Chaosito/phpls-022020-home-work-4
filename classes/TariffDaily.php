<?php

/*
    Тариф суточный:
    Цена за 1 км = 1 руб.
    Цена за 24 часа = 1000 руб.
    Округление до 24 часов в большую сторону, но не мене 30 минут
    (ex. 23:59 - 1 сутки, 24:29 - 1 сутки, 24:31 - 2 суток)
*/

class TariffDaily extends AbstractMainTariff
{
    use GpsTrait, AdditionalDriverTrait;

    public function __construct($distanceKm, $durationDays, $driverAge, $useGps = false, $useAdditionalDriver = false)
    {
        $this->pricePerKilometer = TARIFF_DAILY_PRICE_PER_KM;
        $this->pricePerMinute = TARIFF_DAILY_PRICE_PER_DAY / 24 / 60;   // 200 Рублей за час
        $this->gpsActivated = $useGps;
        $this->additionalDriverExists = $useAdditionalDriver;
        parent::__construct($distanceKm, $durationDays * 24 * 60, $driverAge, $useGps, $useAdditionalDriver);
    }

    public function calcPrice()
    {
        $daysFull = round($this->currentDurationMinutes / 60 / 24); // Количество целых дней
        // Получаем доп. день от остатка, или не получаем :) и складываем с кол-вом целых дней
        $daysFull = $daysFull + ($this->currentDurationMinutes - ($daysFull * 60 * 24) > 30 ? 1 : 0);
        // Проверям кол-во дней, на тот случай если человек взял машину по суточному тарифу, а прокатался < 30 минут.
        $daysFull = ($daysFull < 1) ? 1 : 0;
        $this->priceDuration = ($daysFull * 24 * 60 * $this->pricePerMinute);
        return (($this->priceDistance + $this->priceDuration) * $this->ageMultiplier) + $this->getGpsCost() + $this->getAdditionalDriverCost();
    }
}

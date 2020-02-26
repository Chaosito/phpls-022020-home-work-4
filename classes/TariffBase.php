<?php

/*
    Тариф базовый:
    Цена за 1 км = 10 руб.
    Цена за 1 мин = 3 руб.
    Доп. водитель недоступен
*/

class TariffBase extends AbstractMainTariff
{
    use GpsTrait;

    public function __construct($distanceKm, $durationMinutes, $driverAge, $useGps = false, $useAdditionalDriver = false)
    {
        $this->pricePerKilometer = TARIFF_BASE_PRICE_PER_KM;
        $this->pricePerMinute = TARIFF_BASE_PRICE_PER_MINUTE;
        $this->gpsActivated = $useGps;
        parent::__construct($distanceKm, $durationMinutes, $driverAge, $useGps, $useAdditionalDriver);
        if ($useAdditionalDriver) throw new Exception("Ошибка. Дополнительный водитель не предлагается для данного тарифа!", 40401);
    }

    public function calcPrice()
    {
        return (($this->priceDistance + $this->priceDuration) * $this->ageMultiplier) + $this->getGpsCost();
    }
}

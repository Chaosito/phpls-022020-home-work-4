<?php

/*
    Тариф студенческий:
    Цена за 1 км = 4 руб.
    Цена за 1 мин = 1 руб.
    Возраст не более 25 лет
    Доп. водитель недоступен
*/

class TariffStudents extends AbstractMainTariff
{
    public function __construct($distanceKm, $durationMinutes, $driverAge, $useGps = false, $useAdditionalDriver = false)
    {
        $this->maximalAge = TARIFF_STUDENT_DRIVER_AGE_MAX;
        $this->pricePerKilometer = TARIFF_STUDENTS_PRICE_PER_KM;
        $this->pricePerMinute = TARIFF_STUDENTS_PRICE_PER_MINUTE;
        parent::__construct($distanceKm, $durationMinutes, $driverAge, $useGps, $useAdditionalDriver);
        if ($useAdditionalDriver) throw new Exception("Ошибка. Дополнительный водитель не предлагается для данного тарифа!", 40401);
    }

    public function calcPrice()
    {
        return (($this->priceDistance + $this->priceDuration) * $this->ageMultiplier) + $this->getGpsCost();
    }
}

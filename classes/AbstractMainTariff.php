<?php

abstract class AbstractMainTariff implements TariffInterface
{
    protected $pricePerKilometer, $pricePerMinute, $driverAge;
    protected $minimalAge = DRIVER_AGE_MINIMAL, $maximalAge = DRIVER_AGE_MAXIMAL;
    protected $minimalAgeForNovice = DRIVER_IS_NOVICE_FROM_AGE, $maximalAgeForNovice = DRIVER_IS_NOVICE_TO_AGE;
    protected $currentDistanceKm, $currentDurationMinutes, $ageMultiplier;
    public $priceDistance, $priceDuration;  // Чтоб можно было получить отдельно стоимость за пройденное расстояние и время

    protected function __construct($distanceKm, $durationMinutes, $driverAge, $useGps, $useAdditionalDriver)
    {
        // Проверка некоторых данных
        $distanceKm = ($distanceKm < 0) ? 0 : $distanceKm;
        $durationMinutes = ($durationMinutes < 0) ? 0 : $durationMinutes;

        // Просто вывод данных:
        print 'Class `'.get_called_class().'` - ';
        $additionalService = [];
        if ($useGps) $additionalService[] = 'GPS';
        if ($useAdditionalDriver) $additionalService[] = 'Доп. водитель';
        if (!count($additionalService)) $additionalService[] = 'Без доп. услуг';
        print "[Дистанция - {$distanceKm} Км., Время поездки - {$durationMinutes} минут., Возраст водителя - {$driverAge}, ".implode(", ", $additionalService).'] - ';

        if ($driverAge < $this->minimalAge || $driverAge > $this->maximalAge) {
            throw new Exception("Водитель не может быть младше {$this->minimalAge} или старше {$this->maximalAge} лет!", 40402);
        }

        // Базовое определение свойств подходящих под все тарифы, если будет нужно переопределим
        $this->driverAge = $driverAge;
        $this->currentDistanceKm = $distanceKm;
        $this->currentDurationMinutes = $durationMinutes;
        $this->ageMultiplier = ($driverAge >= $this->minimalAgeForNovice && $driverAge <= $this->maximalAgeForNovice) ? (INCREASE_PRICE_FOR_NOVICE_IN_PERCENT / 100) + 1 : 1;
        $this->priceDistance = $this->currentDistanceKm * $this->pricePerKilometer;
        $this->priceDuration = $this->currentDurationMinutes * $this->pricePerMinute;
    }

    abstract public function calcPrice();
}

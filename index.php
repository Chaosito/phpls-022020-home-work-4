<?php

/* Базовые настройки */
const DRIVER_AGE_MINIMAL = 18;                      // Минимальный возраст водителя
const DRIVER_AGE_MAXIMAL = 65;                      // Максимальный возраст водителя
const DRIVER_IS_NOVICE_FROM_AGE = 18;               // Минимальный возраст водителя-новичка (повышение тарифов)
const DRIVER_IS_NOVICE_TO_AGE = 21;                 // Максимальный возраст водителя-новичка (повышение тарифов)
const INCREASE_PRICE_FOR_NOVICE_IN_PERCENT = 10;    // Увеличение цены для водителей новичков, на указанный процент

/* Настройки тарифа "Базовый" */
const TARIFF_BASE_PRICE_PER_KM = 10;                // Стоимость 1 км пути, тариф "Базовый"
const TARIFF_BASE_PRICE_PER_MINUTE = 3;             // Стоимость 1 минуты пути, тариф "Базовый"

/* Настройки тарифа "Почасовой" */

/* Настройки тарифа "Суточный" */

/* Настройки тарифа "Студенческий" */
const TARIFF_STUDENT_DRIVER_AGE_MAX = 25;           // Максимальный возраст для тарифа "Студенческий"

/* Настройки доп. услуг */
const ADDITIONAL_GPS_PRICE_RUB = 15;                // Стоимость GPS, Рублей.
const ADDITIONAL_GPS_PRICE_4_DURATION = 60;         // Цена GPS за каждые N минут
const ADDITIONAL_DRIVER_PRICE = 100;                // Цена GPS за каждые N минут

trait GpsTrait
{
    protected $gpsActivated = false;
    protected $gpsPrice = ADDITIONAL_GPS_PRICE_RUB;
    protected $gpsPriceForDurationInMinutes = ADDITIONAL_GPS_PRICE_4_DURATION;
}

trait AdditionalDriverTrait
{
    protected $additionalDriverExists = false;
    protected $additionalDriverPrice = ADDITIONAL_DRIVER_PRICE;
}

interface TariffInterface
{
    public function calcPrice($return = false);
    // и другие необходимые функции
}

abstract class AbstractMainTariff implements TariffInterface
{
    protected $pricePerKilometer, $pricePerMinute, $driverAge;
    protected $minimalAge = DRIVER_AGE_MINIMAL, $maximalAge = DRIVER_AGE_MAXIMAL;
    protected $minimalAgeForNovice = DRIVER_IS_NOVICE_FROM_AGE, $maximalAgeForNovice = DRIVER_IS_NOVICE_TO_AGE;
    protected $currentDistanceKm, $currentDurationMinutes, $ageMultiplier;

    protected function __construct($distanceKm, $durationHours, $driverAge, $useGps, $useAdditionalDriver)
    {
        if ($driverAge < $this->minimalAge || $driverAge > $this->maximalAge) {
            throw new Exception("Водитель не может быть младше {$this->minimalAge} или старше {$this->maximalAge} лет!", 40402);
        }

        $this->driverAge = $driverAge;
        $this->currentDistanceKm = $distanceKm;
        $this->currentDurationMinutes = $durationHours * 60;
        $this->ageMultiplier = ($driverAge >= $this->minimalAgeForNovice && $driverAge <= $this->maximalAgeForNovice) ? (INCREASE_PRICE_FOR_NOVICE_IN_PERCENT / 100) + 1 : 1;

        $additionalService = [];
        if ($useGps) $additionalService[] = 'GPS';
        if ($useAdditionalDriver) $additionalService[] = 'Доп. водитель';
        if (!count($additionalService)) $additionalService[] = 'Без доп. услуг';

        print "Дистанция - {$distanceKm} Км., Время поездки - {$durationHours} ч., Возраст водителя - {$driverAge} лет, ".implode(", ", $additionalService).'<br>';
    }

    abstract public function calcPrice($return = false);
    // описывает основные методы и занимается определением возраста, и имплементирует интерфейс iTariff
}

// To-Do: Этот класс практически готов
class TariffBase extends AbstractMainTariff
{
    use GpsTrait;

    public function __construct($distanceKm, $durationHours, $driverAge, $useGps = false, $useAdditionalDriver = false)
    {
        parent::__construct($distanceKm, $durationHours, $driverAge, $useGps, $useAdditionalDriver);
        if ($useAdditionalDriver) throw new Exception("Дополнительный водитель не предлагается для данного тарифа", 40401);

        $this->pricePerKilometer = TARIFF_BASE_PRICE_PER_KM;
        $this->pricePerMinute = TARIFF_BASE_PRICE_PER_MINUTE;
        $this->gpsActivated = $useGps;
    }

    public function calcPrice($return = false)
    {
        print 'Class `'.__CLASS__.'`<br>';
        $priceDistance = $this->currentDistanceKm * $this->pricePerKilometer;
        $priceDuration = $this->currentDurationMinutes * $this->pricePerMinute;
        // To-Do: Должна ли стоимость GPS и доп. водителя облагаться налогом водителя-новичка?
        // Пока сделаем что нет.
        $priceGps = ($this->gpsActivated) ? ceil($this->currentDurationMinutes / $this->gpsPriceForDurationInMinutes) * $this->gpsPrice : 0;

        return (($priceDistance + $priceDuration) * $this->ageMultiplier) + $priceGps;
    }
}

class TariffHourly extends AbstractMainTariff
{
    use GpsTrait, AdditionalDriverTrait;

    public function __construct($distanceKm, $durationHours, $driverAge, $useGps = false, $useAdditionalDriver = false)
    {
        parent::__construct($distanceKm, $durationHours, $driverAge, $useGps, $useAdditionalDriver);
        $this->pricePerKilometer = 0;
        $this->pricePerMinute = 200 / 60;   // 200 Рублей за час
        $this->gpsActivated = $useGps;
        $this->additionalDriverExists = $useAdditionalDriver;
    }

    public function calcPrice($return = false)
    {
        print 'Class `'.__CLASS__.'`<br>';
    }
}

class TariffDaily extends AbstractMainTariff
{
    use GpsTrait, AdditionalDriverTrait;

    public function __construct($distanceKm, $durationHours, $driverAge, $useGps = false, $useAdditionalDriver = false)
    {
        parent::__construct($distanceKm, $durationHours, $driverAge, $useGps, $useAdditionalDriver);
        $this->gpsActivated = $useGps;
        $this->additionalDriverExists = $useAdditionalDriver;
    }

    public function calcPrice($return = false)
    {
        print 'Class `'.__CLASS__.'`<br>';
    }
}

class TariffStudents extends AbstractMainTariff
{
    use GpsTrait;

    public function __construct($distanceKm, $durationHours, $driverAge, $useGps = false, $useAdditionalDriver = false)
    {
        $this->maximalAge = TARIFF_STUDENT_DRIVER_AGE_MAX;
        parent::__construct($distanceKm, $durationHours, $driverAge, $useGps, $useAdditionalDriver);
        if ($useAdditionalDriver) throw new Exception("Дополнительный водитель не предлагается для данного тарифа - ".__CLASS__, 40401);
        $this->gpsActivated = $useGps;
    }

    public function calcPrice($return = false)
    {
        print 'Class `'.__CLASS__.'`<br>';
    }
}

try {
    $tariff1 = new TariffBase(5, 1, 20, 0, 0);
    print "Стоимость каршеринга: ".$tariff1->calcPrice().' Руб.<br>';
} catch (Exception $e) {
    print $e->getMessage();
}
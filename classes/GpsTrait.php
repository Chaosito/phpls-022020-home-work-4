<?php

trait GpsTrait
{
    protected $gpsActivated = false;
    protected $gpsPriceForDurationInMinutes = ADDITIONAL_GPS_PRICE_4_DURATION;

    protected function getGpsCost()
    {
        // WARN; To-Do: Должна ли стоимость GPS и доп. водителя облагаться налогом водителя-новичка? Пока сделаем что нет.
        return ($this->gpsActivated) ? ceil($this->currentDurationMinutes / $this->gpsPriceForDurationInMinutes) * ADDITIONAL_GPS_PRICE_RUB : 0;
    }
}

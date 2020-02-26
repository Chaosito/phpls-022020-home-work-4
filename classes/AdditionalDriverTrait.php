<?php

trait AdditionalDriverTrait
{
    protected $additionalDriverExists = false;
    protected $additionalDriverPrice = ADDITIONAL_DRIVER_PRICE;

    protected function getAdditionalDriverCost()
    {
        return ($this->additionalDriverExists) ? $this->additionalDriverPrice : 0;
    }
}

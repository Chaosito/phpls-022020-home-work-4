<?php

/* Базовые настройки */
const DRIVER_AGE_MINIMAL = 18;                      // Минимальный возраст водителя
const DRIVER_AGE_MAXIMAL = 65;                      // Максимальный возраст водителя
const DRIVER_IS_NOVICE_FROM_AGE = 18;               // Минимальный возраст водителя-новичка (повышение тарифов)
const DRIVER_IS_NOVICE_TO_AGE = 21;                 // Максимальный возраст водителя-новичка (повышение тарифов)
const INCREASE_PRICE_FOR_NOVICE_IN_PERCENT = 10;    // Увеличение цены для водителей новичков, на указанный процент

const MINUTES_IN_HOUR = 60;                         // Количество минут в 1 часу
const MINUTES_IN_DAY = 1440;                        // Количество минут в 1 дне (24 часа * 60 минут)

/* Настройки тарифа "Базовый" */
const TARIFF_BASE_PRICE_PER_KM = 10;                // Стоимость 1 км пути
const TARIFF_BASE_PRICE_PER_MINUTE = 3;             // Стоимость 1 минуты пути

/* Настройки тарифа "Почасовой" */
const TARIFF_HOURLY_PRICE_PER_KM = 0;                // Стоимость 1 км пути
const TARIFF_HOURLY_PRICE_PER_HOUR = 200;            // Стоимость 1 часа пути

/* Настройки тарифа "Суточный" */
const TARIFF_DAILY_PRICE_PER_KM = 1;                // Стоимость 1 км пути
const TARIFF_DAILY_PRICE_PER_DAY = 1000;            // Стоимость 1 суток пути
const TARIFF_DAILY_MAX_OVERTIME_MINUTES = 30;       // Максимальное кол-во минут на которое может "опоздать" клиент.

/* Настройки тарифа "Студенческий" */
const TARIFF_STUDENTS_PRICE_PER_KM = 4;             // Стоимость 1 км пути
const TARIFF_STUDENTS_PRICE_PER_MINUTE = 1;         // Стоимость 1 суток пути
const TARIFF_STUDENT_DRIVER_AGE_MAX = 25;           // Максимальный возраст для тарифа

/* Настройки доп. услуг */
const ADDITIONAL_GPS_PRICE_RUB = 15;                // Стоимость GPS, Рублей.
const ADDITIONAL_GPS_PRICE_4_DURATION = 60;         // Цена GPS за каждые N минут
const ADDITIONAL_DRIVER_PRICE = 100;                // Цена GPS за каждые N минут

spl_autoload_register(function($className) {
    $className = str_replace('\\', DIRECTORY_SEPARATOR, $className);
    include_once $_SERVER['DOCUMENT_ROOT'].DIRECTORY_SEPARATOR.'classes'.DIRECTORY_SEPARATOR.$className.'.php';
});
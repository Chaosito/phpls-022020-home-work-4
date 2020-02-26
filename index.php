<?php
include_once('config.php');

try {
    $attr4Tariff = [
        ['distanceKm' => 5, 'duration' => 120, 'driverAge' => 20, 'useGps' => 0, 'useAdditionalDriver' => 0],
        ['distanceKm' => 10, 'duration' => 119, 'driverAge' => 22, 'useGps' => 1, 'useAdditionalDriver' => 0],
        ['distanceKm' => 15, 'duration' => 70, 'driverAge' => 18, 'useGps' => 1, 'useAdditionalDriver' => 0],
        ['distanceKm' => 20, 'duration' => 666, 'driverAge' => 18, 'useGps' => 1, 'useAdditionalDriver' => 1],
    ];

    foreach($attr4Tariff AS $v) {
        $objTariff = new TariffBase($v['distanceKm'], $v['duration'], $v['driverAge'], $v['useGps'], $v['useAdditionalDriver']);
        print "Стоимость каршеринга: ".$objTariff->calcPrice().' Руб.<br>';
    }
} catch (Exception $e) {
    print '<span style="color:red;">'.$e->getMessage().'</span><br>';
}
print '<hr>';

try {
    $attr4Tariff = [
        ['distanceKm' => 5, 'duration' => 23, 'driverAge' => 20, 'useGps' => 0, 'useAdditionalDriver' => 0],
        ['distanceKm' => 10, 'duration' => 34/60, 'driverAge' => 22, 'useGps' => 1, 'useAdditionalDriver' => 0],
        ['distanceKm' => 15, 'duration' => 25, 'driverAge' => 18, 'useGps' => 1, 'useAdditionalDriver' => 0],
        ['distanceKm' => 20, 'duration' => 666, 'driverAge' => 17, 'useGps' => 1, 'useAdditionalDriver' => 1],
    ];

    foreach($attr4Tariff AS $v) {
        $objTariff = new TariffHourly($v['distanceKm'], $v['duration'], $v['driverAge'], $v['useGps'], $v['useAdditionalDriver']);
        print "Стоимость каршеринга: ".$objTariff->calcPrice().' Руб.<br>';
    }
} catch (Exception $e) {
    print '<span style="color:red;">'.$e->getMessage().'</span><br>';
}
print '<hr>';

try {
    $attr4Tariff = [
        ['distanceKm' => 5, 'duration' => 23, 'driverAge' => 20, 'useGps' => 0, 'useAdditionalDriver' => 0],
        ['distanceKm' => 10, 'duration' => 25/60/24, 'driverAge' => 22, 'useGps' => 1, 'useAdditionalDriver' => 0],
        ['distanceKm' => 15, 'duration' => 25, 'driverAge' => 18, 'useGps' => 1, 'useAdditionalDriver' => 1],
        ['distanceKm' => 20, 'duration' => -666, 'driverAge' => 66, 'useGps' => 1, 'useAdditionalDriver' => 1],
    ];

    foreach($attr4Tariff AS $v) {
        $objTariff = new TariffDaily($v['distanceKm'], $v['duration'], $v['driverAge'], $v['useGps'], $v['useAdditionalDriver']);
        print "Стоимость каршеринга: ".$objTariff->calcPrice().' Руб.<br>';
    }
} catch (Exception $e) {
    print '<span style="color:red;">'.$e->getMessage().'</span><br>';
}
print '<hr>';

try {
    $attr4Tariff = [
        ['distanceKm' => 5, 'duration' => 23, 'driverAge' => 20, 'useGps' => 0, 'useAdditionalDriver' => 0],
        ['distanceKm' => 10, 'duration' => 25, 'driverAge' => 22, 'useGps' => 1, 'useAdditionalDriver' => 0],
        ['distanceKm' => 15, 'duration' => 25, 'driverAge' => 18, 'useGps' => 1, 'useAdditionalDriver' => 0],
        ['distanceKm' => 20, 'duration' => -666, 'driverAge' => 30, 'useGps' => 1, 'useAdditionalDriver' => 0],
    ];

    foreach($attr4Tariff AS $v) {
        $objTariff = new TariffStudents($v['distanceKm'], $v['duration'], $v['driverAge'], $v['useGps'], $v['useAdditionalDriver']);
        print "Стоимость каршеринга: ".$objTariff->calcPrice().' Руб.<br>';
    }
} catch (Exception $e) {
    print '<span style="color:red;">'.$e->getMessage().'</span><br>';
}

<?php


function jourDeLaSemaine() : string {
    $jourSem = ["Mon" => "Lundi", "Tue" => "Mardi", "Wed" => "Mercredi", "Thu" => "Jeudi",
    "Fri" => "Vendredi" , "Sat" => "Samedi", "Sun" => "Dimanche"];
    $jourEn = date('D');
    foreach ($jourSem as $jour_en => $jour_fr) {
        if ($jour_en == $jourEn) {
        $jourFr = $jour_fr;
        break;
        }
    }
    return  $jourFr;
}
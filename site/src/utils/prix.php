<?php

function formatPrix(string $prix):string {
    return str_replace(".",",",$prix)." €";
}


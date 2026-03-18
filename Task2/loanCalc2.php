<?php

// pobieranie parametrow, puste jako default
$loan = $_REQUEST["loan"] ?? "";
$interest = $_REQUEST["interest"] ?? "";
$years = $_REQUEST["years"] ?? "";
$currency = $_REQUEST["currency"] ?? "USD";

$errors = []; // teraz nie string, a tablica na wszystkie bledy
$payment = null;

// validacja jezeli formularz przeslany
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_REQUEST['loan'])) {
    // sprawdzanie pustych pol
    if ($loan === "") {
        $errors[] = "Kwota pożyczki jest wymagana.";
    }
    if ($interest === "") {
        $errors[] = "Oprocentowanie jest wymagane.";
    }
    if ($years === "") {
        $errors[] = "Liczba lat jest wymagana.";
    }

    // jesli pole nie jest puste, konwertuje na liczbę i sprawdzamy dodatniość
    if ($loan !== "") {
        $loan = floatval($loan);
        if ($loan <= 0) {
            $errors[] = "Kwota pożyczki musi być LICZBĄ większą od zera.";
        }
    }
    if ($interest !== "") {
        $interest = floatval($interest);
        if ($interest <= 0) {
            $errors[] = "Oprocentowanie musi być LICZBĄ większą od zera.";
        }
    }
    if ($years !== "") {
        $years = floatval($years);
        if ($years <= 0) {
            $errors[] = "Liczba lat musi być LICZBĄ większą od zera.";
        }
    }

    // jesli brak bledow, obliczamy rate (no wrescie)
    if (empty($errors)) {
        $payment = $loan * $interest / (12 * $years);
    }
}

include "loanCalc2_view.php";
?>
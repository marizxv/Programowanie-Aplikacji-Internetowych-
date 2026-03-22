<?php

//TODO: dodać nadpisy do pól do wpisywania danych – nie widać co się wpisuje


// srtona funktioniert nicht, ale też nie chciało mu się wyświetlać błędy. To ja nie zostawiłam wyboru.
error_reporting(E_ALL);
ini_set('display_errors', 1);

// dołączenie Smarty (co ja robię??)
require_once('smarty/libs/Smarty.class.php');

// inicjalizacja Smarty
$smarty = new Smarty\Smarty();
$smarty->setTemplateDir('./');
$smarty->setCompileDir('./templates_c/');

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

// Przekazanie zmiennych do szablonu
$smarty->assign('loan', $loan);
$smarty->assign('interest', $interest);
$smarty->assign('years', $years);
$smarty->assign('currency', $currency);
$smarty->assign('currencies', ['USD'=>'$', 'EUR'=>'€', 'GBP'=>'£', 'JPY'=>'¥', 'PLN'=>'zł']);
$smarty->assign('errors', $errors);
$smarty->assign('payment', $payment);

// Wyświetlenie szablonu
$smarty->display('loanCalc3_view.tpl');
?>


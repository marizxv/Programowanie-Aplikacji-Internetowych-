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

// pobieranie parametrow do tablicy, null jako default
function getParams(&$form) {
    $form['loan']      = $_REQUEST['loan'] ?? null;
    $form['interest']  = $_REQUEST['interest'] ?? null;
    $form['years']     = $_REQUEST['years'] ?? null;
    $form['currency']  = $_REQUEST['currency'] ?? 'USD';
}

// validacja
function validate(&$form, &$infos, &$messages, &$hide_intro) {
    // jesli brak ktoregos z trzech pol, formularz nie wyslany
    if (!isset($form['loan']) || !isset($form['interest']) || !isset($form['years'])) {
        return false;
    }

    $hide_intro = true; // flaga, ze formularz byl juz pokazywany
    $infos[] = 'Przekazano parametry.';

    // validacja kwoty
    if ($form['loan'] == "") {
        $messages[] = 'Nie podano kwoty pożyczki.';
    } elseif (!is_numeric($form['loan'])) {
        $messages[] = 'Kwota pożyczki nie jest liczbą.';
    } elseif ($form['loan'] <= 0) {
        $messages[] = 'Kwota pożyczki musi być większa od 0.';
    }

    // validacja oprocentowania
    if ($form['interest'] == "") {
        $messages[] = 'Nie podano oprocentowania.';
    } elseif (!is_numeric($form['interest'])) {
        $messages[] = 'Oprocentowanie nie jest liczbą.';
    } elseif ($form['interest'] <= 0) {
        $messages[] = 'Oprocentowanie musi być większe od 0.';
    }

    // validacja lat
    if ($form['years'] == "") {
        $messages[] = 'Nie podano okresu spłaty.';
    } elseif (!is_numeric($form['years'])) {
        $messages[] = 'Okres spłaty nie jest liczbą.';
    } elseif ($form['years'] <= 0) {
        $messages[] = 'Okres spłaty musi być większy od 0.';
    }

    // jeli sa bledy zwraca false
    return empty($messages);
}

// obliczenia
function process(&$form, &$infos, &$messages, &$result) {
    $infos[] = 'Parametry poprawne. Wykonuję obliczenia.';

    // konwersja na liczby
    $form['loan']     = (float) $form['loan'];
    $form['interest'] = (float) $form['interest'];
    $form['years']    = (float) $form['years'];

    // jesli brak bledow, obliczamy rate (no wrescie)
    $payment = $form['loan'] * $form['interest'] / (12 * $form['years']);

    // dodatkowe informacje?
    $result['rata']       = $payment;
    $result['kwota']      = $form['loan'];
    $result['odsetki']    = $form['loan'] * $form['interest'] * $form['years']; // nie wiem, aby bylo
    $result['kwotaCalkowita'] = $form['loan'] + $result['odsetki'];
}

// glowna częsc skryptu
$form     = null;
$infos    = [];
$messages = [];
$result   = [];
$hide_intro = false;

getParams($form);
if (validate($form, $infos, $messages, $hide_intro)) {
    process($form, $infos, $messages, $result);
}

// Przekazanie zmiennych do szablonu
$smarty->assign('loan', $form['loan'] ?? '');
$smarty->assign('interest', $form['interest'] ?? '');
$smarty->assign('years', $form['years'] ?? '');
$smarty->assign('currency', $form['currency'] ?? 'USD');
$smarty->assign('currencies', ['USD'=>'$', 'EUR'=>'€', 'GBP'=>'£', 'JPY'=>'¥', 'PLN'=>'zł']);
$smarty->assign('payment',   $result['rata'] ?? null);
$smarty->assign('errors', $messages);
$smarty->assign('infos', $infos);

// Wyświetlenie szablonu
$smarty->display('loanCalc3_view.tpl');
?>


<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoanController extends Controller
{
    // przepisane symbole walut $smarty->assign('currencies', [...])
    private array $currencies = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'JPY' => '¥',
        'PLN' => 'zł',
    ];

    public function index(Request $request)
    {
        // zamiast getParams(), bo laravel czyta z $request, a nie z $_REQUEST
        $loan     = $request->input('loan');
        $interest = $request->input('interest');
        $years    = $request->input('years');
        $currency = $request->input('currency', 'USD');

        $errors  = [];
        $infos   = [];
        $payment = null;

        // validacja tylko jeśli forma przesłana
        if ($request->hasAny(['loan', 'interest', 'years'])) {
            $infos[] = 'Przekazano parametry.';

            // validacja loan amount
            if ($loan === '')            $errors[] = 'Nie podano kwoty pożyczki.';
            elseif (!is_numeric($loan))  $errors[] = 'Kwota pożyczki nie jest liczbą.';
            elseif ($loan <= 0)          $errors[] = 'Kwota pożyczki musi być większa od 0.';

            // validacja interest rate
            if ($interest === '')             $errors[] = 'Nie podano oprocentowania.';
            elseif (!is_numeric($interest))   $errors[] = 'Oprocentowanie nie jest liczbą.';
            elseif ($interest <= 0)           $errors[] = 'Oprocentowanie musi być większe od 0.';

            // validacja years
            if ($years === '')           $errors[] = 'Nie podano okresu spłaty.';
            elseif (!is_numeric($years)) $errors[] = 'Okres spłaty nie jest liczbą.';
            elseif ($years <= 0)         $errors[] = 'Okres spłaty musi być większy od 0.';

            // liczy tylko jezeli niema blędów
            if (empty($errors)) {
                $infos[] = 'Parametry poprawne. Wykonuję obliczenia.';
                $payment = (float)$loan * (float)$interest / (12 * (float)$years);
            }
        }

        // zamiast $smarty->assign() robi call — i parsuje zmienne do view
        return view('loan', [
            'loan'       => $loan ?? '',
            'interest'   => $interest ?? '',
            'years'      => $years ?? '',
            'currency'   => $currency,
            'currencies' => $this->currencies,
            'payment'    => $payment,
            'errors'     => $errors,
            'infos'      => $infos,
        ]);
    }
}

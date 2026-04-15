<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Forms\LoanForm;
use App\Transfer\LoanResult;
use App\Transfer\User;

class LoanController extends Controller
{

    // symbole walut , admin widzi wszystkie, user tylko USD
    private array $allCurrencies = [
        'USD' => '$',
        'EUR' => '€',
        'GBP' => '£',
        'JPY' => '¥',
        'PLN' => 'zł',
    ];

    private function getUser(): ?User
    {
        return session('user') ? unserialize(session('user')) : null;
    }

    // pokazuje pusty formularz kalkulatora
    public function index()
    {
        $user   = $this->getUser();
        $form   = new LoanForm();
        $result = new LoanResult();

        return view('loan', [
            'form'       => $form,
            'result'     => $result,
            'user'       => $user,
            'currencies' => $this->getCurrencies($user),
            'errors'     => [],
            'infos'      => [],
        ]);
    }

    // form submission
    public function process(Request $request)
    {
        $user   = $this->getUser();
        $form   = new LoanForm();
        $result = new LoanResult();
        $errors = [];
        $infos  = [];

        $form->loan     = $request->input('loan');
        $form->interest = $request->input('interest');
        $form->years    = $request->input('years');
        $form->currency = $user?->isAdmin()
            ? $request->input('currency', 'USD')
            : 'USD';

        $infos[] = 'Przekazano parametry.';

        // validacja loan amount
        if ($form->loan === '')            $errors[] = 'Nie podano kwoty pożyczki.';
        elseif (!is_numeric($form->loan))  $errors[] = 'Kwota pożyczki nie jest liczbą.';
        elseif ($form->loan <= 0)          $errors[] = 'Kwota pożyczki musi być większa od 0.';
        elseif (!$user->isAdmin() && $form->loan > 1000)
            $errors[] = 'Kwota pożyczki nie może przekraczać 1000.';

        // validacja interest rate
        if ($form->interest === '')              $errors[] = 'Nie podano oprocentowania.';
        elseif (!is_numeric($form->interest))    $errors[] = 'Oprocentowanie nie jest liczbą.';
        elseif ($form->interest <= 0)            $errors[] = 'Oprocentowanie musi być większe od 0.';
        elseif (!$user->isAdmin() && $form->interest > 5)
            $errors[] = 'Oprocentowanie nie może przekraczać 5%.';

        // validacja years
        if ($form->years === '')           $errors[] = 'Nie podano okresu spłaty.';
        elseif (!is_numeric($form->years)) $errors[] = 'Okres spłaty nie jest liczbą.';
        elseif ($form->years <= 0)         $errors[] = 'Okres spłaty musi być większy od 0.';

        // liczy tylko jezeli niema blędów
        if (empty($errors)) {
            $infos[] = 'Parametry poprawne. Wykonuję obliczenia.';

            $result->loan     = (float) $form->loan;
            $result->interest = (float) $form->interest;
            $result->years    = (float) $form->years;
            $result->currency = $form->currency;
            $result->payment  = $result->loan * $result->interest
                / (12 * $result->years);
        }

        // zamiast $smarty->assign() robi call — i parsuje zmienne do Blade
        return view('loan', [
            'form'       => $form,
            'result'     => $result,
            'user'       => $user,
            'currencies' => $this->getCurrencies($user),
            'errors'     => $errors,
            'infos'      => $infos,
        ]);
    }

    // ktore waluty ten user widzi
    private function getCurrencies(?User $user): array {
        if ($user && $user->isAdmin()) {
            return $this->allCurrencies;
        }
        return ['USD' => '$'];
    }
}

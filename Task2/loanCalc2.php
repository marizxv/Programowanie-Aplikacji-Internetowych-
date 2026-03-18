<?php

// getting parameters, empty values by default
$loan = $_REQUEST["loan"] ?? "";
$interest = $_REQUEST["interest"] ?? "";
$years = $_REQUEST["years"] ?? "";
$currency = $_REQUEST["currency"] ?? "USD";

$error = "";
$payment = null;

// validation if the form was submitted
if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_REQUEST['loan'])) {

    // checking if any field is empty
    if ($loan === "" || $interest === "" || $years === "") {
        $error = "All fields are required.";
    } else {

        // conversion to numbers with decimals
        $loan = floatval($loan);
        $interest = floatval($interest);
        $years = floatval($years);

        // validating positivity
        if ($loan <= 0) {
            $error = "Loan amount must be positive.";
        } elseif ($interest <= 0) {
            $error = "Interest rate must be positive.";
        } elseif ($years <= 0) {
            $error = "Years must be positive.";
        } else {

            // monthly payment calculation
            $payment = $loan * $interest / (12 * $years);
        }
    }
}

//TODO: change the error output, unify languages(oprional);

include "loanCalc2_view.php";
?>
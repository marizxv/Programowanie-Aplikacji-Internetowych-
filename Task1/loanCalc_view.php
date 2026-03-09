<html>
<head>
    <title>Loan Calculator</title>
</head>
<body>
<h2>Loan Calculator</h2>

<form action="loanCalc.php" method="GET">
    <label>Loan amount:</label>
    <input type="text" name="loan" value="<?php echo $_REQUEST['loan'] ?? '' ?>">
    <select name="currency">
        <option value="USD" <?php echo (isset($_REQUEST['currency']) && $_REQUEST['currency']=='USD')?'selected':'' ?>>USD ($)</option>
        <option value="EUR" <?php echo (isset($_REQUEST['currency']) && $_REQUEST['currency']=='EUR')?'selected':'' ?>>EUR (€)</option>
        <option value="GBP" <?php echo (isset($_REQUEST['currency']) && $_REQUEST['currency']=='GBP')?'selected':'' ?>>GBP (£)</option>
        <option value="JPY" <?php echo (isset($_REQUEST['currency']) && $_REQUEST['currency']=='JPY')?'selected':'' ?>>JPY (¥)</option>
    </select>
    <br>

    <label>Interest rate (%):</label>
    <input type="text" name="interest" value="<?php echo $_REQUEST['interest'] ?? '' ?>">
    <br>

    <label>Years:</label>
    <input type="text" name="years" value="<?php echo $_REQUEST['years'] ?? '' ?>">
    <br>

    <input type="submit" value="Calculate">
</form>

<?php if ($error): ?>
    <p style="color:red;"><?php echo $error; ?></p>
<?php endif; ?>

<?php if ($payment !== null): ?>
    <h3>Monthly payment:
        <?php
        $symbols = ['USD'=>'$', 'EUR'=>'€', 'GBP'=>'£', 'JPY'=>'¥'];
        $sym = $symbols[$currency] ?? $currency;
        echo $sym . ' ' . number_format($payment, 2);
        ?>
    </h3>
<?php endif; ?>

</body>
</html>
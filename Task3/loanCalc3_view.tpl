<!DOCTYPE HTML>
<!-- Twenty by HTML5 UP -->
<html>
<head>
    <title>Kalkulator kredytowy</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="assets/css/main.css" />
    <noscript><link rel="stylesheet" href="assets/css/noscript.css" /></noscript>
</head>
<body class="index is-preload">
<div id="page-wrapper">

    <!-- header -->
    <header id="header" class="alt">
        <h1 id="logo"><a href="loanCalc3.php">Kalkulator <span>kredytowy</span></a></h1>
        <nav id="nav">
            <ul>
                <li class="current"><a href="loanCalc3.php">Start</a></li>

            </ul>
        </nav>
    </header>


    <!-- formularz i wynik -->
    <article id="main">
        <header class="special container">
            <!-- wynik (jeśli istnieje) -->
            {if $payment !== null}
                <div style="text-align: center; margin-bottom: 2em; padding: 1.5em; background: #f3f6fa; border-radius: 8px;">
                    <h3 style="color: #83d3c9; font-size: 1.8em; margin-bottom: 0;">Miesięczna rata:</h3>
                    <p style="font-size: 2.5em; font-weight: 900; letter-spacing: 2px; margin: 0.5em 0 0 0;">
                        {$currencies[$currency]} {number_format($payment, 2)}
                    </p>
                </div>
            {/if}

            <!-- wyświetlanie wszystkich błędów jako listy -->
            {if $errors|count > 0}
                <div style="text-align: center; margin-bottom: 2em; padding: 1em; background: #ffdddd; border-left: 4px solid #f44336; color: #333;">
                    <ul style="list-style: disc; padding-left: 1.5em; text-align: left; display: inline-block;">
                        {foreach $errors as $err}
                            <li>{$err}</li>
                        {/foreach}
                    </ul>
                </div>
            {/if}

            <span class="icon solid fa-calculator"></span>
            <h2>Kalkulator kredytowy</h2>
            <p>Wpisz dane, a my obliczymy miesięczną ratę.</p>
        </header>

        <section class="wrapper style4 special container medium">
            <div class="content">
                <form action="loanCalc3.php" method="GET">
                    <div class="row gtr-50">
                        <div class="col-6 col-12-mobile">
                            <input type="text" name="loan" placeholder="Kwota pożyczki" value="{$loan}" />
                        </div>
                        <div class="col-6 col-12-mobile">
                            <select name="currency" style="padding: 0.75em; width: 100%; background: none; border: solid 1px rgba(124, 128, 129, 0.2);">
                                <option value="USD" {if $currency=='USD'}selected{/if}>USD ($)</option>
                                <option value="EUR" {if $currency=='EUR'}selected{/if}>EUR (€)</option>
                                <option value="GBP" {if $currency=='GBP'}selected{/if}>GBP (£)</option>
                                <option value="JPY" {if $currency=='JPY'}selected{/if}>JPY (¥)</option>
                                <option value="PLN" {if $currency=='PLN'}selected{/if}>PLN (zł)</option>
                            </select>
                        </div>
                        <div class="col-6 col-12-mobile">
                            <input type="text" name="interest" placeholder="Oprocentowanie (%)" value="{$interest}" />
                        </div>
                        <div class="col-6 col-12-mobile">
                            <input type="text" name="years" placeholder="Czas (lata)" value="{$years}" />
                        </div>
                        <div class="col-12">
                            <ul class="buttons">
                                <li><input type="submit" class="special" value="Oblicz miesięczną ratę" /></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </article>

    <!-- stopka. bo była. i będzie nadal no bo piękna -->
    <footer id="footer">
        <ul class="icons">
            <li><a href="#" class="icon brands circle fa-twitter"><span class="label">Twitter</span></a></li>
            <li><a href="#" class="icon brands circle fa-facebook-f"><span class="label">Facebook</span></a></li>
            <li><a href="#" class="icon brands circle fa-google-plus-g"><span class="label">Google+</span></a></li>
            <li><a href="#" class="icon brands circle fa-github"><span class="label">Github</span></a></li>
            <li><a href="#" class="icon brands circle fa-dribbble"><span class="label">Dribbble</span></a></li>
        </ul>
        <ul class="copyright">
            <li>&copy; Twój projekt</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
        </ul>
    </footer>

</div>

<!-- skrypty (jak dobrze, że na razie tam nie muszę nic nawet otwierać) -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/jquery.dropotron.min.js"></script>
<script src="assets/js/jquery.scrolly.min.js"></script>
<script src="assets/js/jquery.scrollex.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>

</body>
</html>
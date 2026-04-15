<!DOCTYPE HTML>
<html>
<head>
    <title>Logowanie</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
</head>
<body class="index is-preload">
<div id="page-wrapper">

    <header id="header" class="alt">
        <h1 id="logo"><a href="/">Kalkulator <span>kredytowy</span></a></h1>
    </header>

    <article id="main">
        <header class="special container">
            <span class="icon solid fa-lock"></span>
            <h2>Logowanie</h2>

            @if(!empty($errors))
                <div style="background:#ffdddd;border-left:4px solid #f44336;padding:1em;margin-bottom:1em;text-align:left;display:inline-block;">
                    <ul style="margin:0;padding-left:1.2em;">
                        @foreach($errors as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if(!empty($infos))
                <div style="background:#d4edda;border-left:4px solid #28a745;padding:1em;margin-bottom:1em;">
                    @foreach($infos as $info)
                        <p style="margin:0;">{{ $info }}</p>
                    @endforeach
                </div>
            @endif
        </header>

        <section class="wrapper style4 special container medium">
            <div class="content">
                <form action="{{ route('login.post') }}" method="POST">
                    @csrf
                    <div class="row gtr-50">
                        <div class="col-12">
                            <input type="text" name="login"
                                   placeholder="Login"
                                   value="{{ $form->login ?? '' }}" />
                        </div>
                        <div class="col-12">
                            <input type="password" name="pass"
                                   placeholder="Hasło" />
                        </div>
                        <div class="col-12">
                            <ul class="buttons">
                                <li><input type="submit" class="special" value="Zaloguj się" /></li>
                            </ul>
                        </div>
                    </div>
                </form>
            </div>
        </section>
    </article>

    <footer id="footer">
        <ul class="copyright">
            <li>&copy; Twój projekt</li>
            <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
        </ul>
    </footer>
</div>
</body>
</html>

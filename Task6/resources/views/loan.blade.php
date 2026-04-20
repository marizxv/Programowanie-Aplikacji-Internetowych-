<!DOCTYPE HTML>
<!-- Twenty by HTML5 UP -->
<html>
<head>
    <title>Kalkulator kredytowy</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />

</head>
<body class="index is-preload">
<div id="page-wrapper">

    <header id="header" class="alt">
        <h1 id="logo"><a href="/">Kalkulator <span>kredytowy</span></a></h1>
        <nav id="nav">
            <ul>
                <li class="current"><a href="{{ route('home') }}">Kalkulator</a></li>
                <li>
                    {{-- Show role badge --}}
                    <a href="#">
                        {{ $user->login }}
                        ({{ $user->role === 'admin' ? 'Administrator' : 'Użytkownik' }})
                    </a>
                </li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit"
                                style="background:none;border:none;color:inherit;cursor:pointer;font-size:inherit;">
                            Wyloguj
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <article id="main">
        <header class="special container">
            <span class="icon solid fa-calculator"></span>
            <h2>Kalkulator kredytowy</h2>

            {{-- Info messages --}}
            @if(!empty($infos))
                <div style="background:#d4edda;border-left:4px solid #28a745;color:#155724;padding:1em;margin-bottom:1em;">
                    @foreach($infos as $info)
                        <p style="margin:0;">{{ $info }}</p>
                    @endforeach
                </div>
            @endif

            @if(!empty($errors))
                <div style="background:#ffdddd;border-left:4px solid #f44336;padding:1em;margin-bottom:1em;text-align:left;display:inline-block;">
                    <ul style="margin:0;padding-left:1.2em;">
                        @foreach($errors as $err)
                            <li>{{ $err }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif

            @if($result->payment !== null)
                <div style="background:#f3f6fa;border-radius:8px;padding:1.5em;margin-bottom:1em;">
                    <h3 style="color:#83d3c9;font-size:1.5em;margin-bottom:0;">Miesięczna rata:</h3>
                    <p style="font-size:2.5em;font-weight:900;margin:0.3em 0 0 0;">
                        {{ $currencies[$result->currency] ?? '$' }}
                        {{ number_format($result->payment, 2) }}
                    </p>
                </div>
            @endif

            {{-- Role restrictions note for non-admins --}}
            @if(!$user->isAdmin())
                <p style="color:#aaa;font-size:0.85em;">
                    * Maksymalna kwota: 1000 USD &nbsp;|&nbsp; Maksymalne oprocentowanie: 5%
                </p>
            @endif
        </header>

        <section class="wrapper style4 special container medium">
            <div class="content">
                {{-- action="" sends the form back to the same URL, which is "/" --}}
                <form action="{{ route('compute') }}" method="POST">
                    @csrf
                    <div class="row gtr-50">
                        <div class="col-6 col-12-mobile">
                            <input type="text" name="loan"
                                   placeholder="Kwota pożyczki"
                                   value="{{ $form->loan ?? '' }}" />
                        </div>
                        <div class="col-6 col-12-mobile">
                            @if($user->isAdmin())
                                <select name="currency"
                                        style="padding:0.75em;width:100%;background:none;border:solid 1px rgba(124,128,129,0.2);">
                                    @foreach($currencies as $code => $symbol)
                                        <option value="{{ $code }}"
                                            {{ ($form->currency ?? 'USD') === $code ? 'selected' : '' }}>
                                            {{ $code }} ({{ $symbol }})
                                        </option>
                                    @endforeach
                                </select>
                            @else
                                <input type="text" value="USD ($)" disabled
                                       style="opacity:0.5;cursor:not-allowed;" />
                                <input type="hidden" name="currency" value="USD" />
                            @endif
                        </div>
                        <div class="col-6 col-12-mobile">
                            <input type="text" name="interest"
                                   placeholder="Oprocentowanie (%)"
                                   value="{{ $form->interest ?? '' }}" />
                        </div>
                        <div class="col-6 col-12-mobile">
                            <input type="text" name="years"
                                   placeholder="Czas (lata)"
                                   value="{{ $form->years ?? '' }}" />
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

    <footer id="footer">
        <ul class="copyright">
            <li>&copy; Twój projekt</li><li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
        </ul>
    </footer>

</div>
</body>
</html>

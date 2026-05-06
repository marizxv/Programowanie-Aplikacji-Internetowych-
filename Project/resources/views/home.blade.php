<!DOCTYPE HTML>
<html>
<head>
    <title>Plant Care Diary</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <style>
        /* przyklejony footer dla krotkich stron — bez tego ucieka do gory po reloadzie */
        body { margin: 0; }
        #page-wrapper { display: flex; flex-direction: column; min-height: 100vh; }
        #main         { flex: 1 0 auto; }
        #footer       { flex-shrink: 0; }

        /* czytelnosc na jasnym tle headera */
        #logo a {
            text-shadow: 0 2px 8px rgb(113, 128, 150);
        }
        #nav ul li a,
        #nav ul li button {
            color: #fff !important;
            text-shadow: 0 1px 4px rgb(113, 128, 150);
        }
    </style>
</head>
<body class="index">
<div id="page-wrapper">

    <header id="header" class="alt">
        <h1 id="logo"><a href="/">Plant <span>Care Diary</span></a></h1>
        <nav id="nav">
            <ul>
                <li><a href="#">{{ $user->nickname }} ({{ $user->role }})</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;font-size:inherit;">
                            Wyloguj
                        </button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <article id="main">
        <header class="special container">
            <span class="icon solid fa-seedling"></span>
            <h2>Witaj, <span style="color:#3fb1a3;">{{ $user->nickname }}</span>.</h2>

            @if(!empty($infos))
                <div style="background:#d4edda;border-left:4px solid #28a745;padding:1em;margin:1em 0;">
                    @foreach($infos as $info)<p style="margin:0;">{{ $info }}</p>@endforeach
                </div>
            @endif

            <p>Tu kiedyś będzie Twój ogród i dziennik podlewania. Na razie — cisza, spokój, pusta doniczka. Musiałam gdzieś Cie przekierować.</p>
        </header>
    </article>

    <footer id="footer">
        <ul class="copyright"><li>&copy; Plant Care Diary</li></ul>
    </footer>
</div>
</body>
</html>

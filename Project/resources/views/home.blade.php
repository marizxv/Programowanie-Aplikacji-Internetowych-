<!DOCTYPE HTML>
<html>
<head>
    <title>Plant Care Diary</title>
    <meta charset="utf-8" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
</head>
<body class="index is-preload">
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
            <h2>Witaj, {{ $user->nickname }}.</h2>

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

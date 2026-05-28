<!DOCTYPE HTML>
<html>
<head>
    <title>Katalog Roślin — Plant Care Diary</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <style>
        body { margin: 0; }
        #page-wrapper { display: flex; flex-direction: column; min-height: 100vh; }
        #main { flex: 1 0 auto; }
        #footer { flex-shrink: 0; }
        #logo a { text-shadow: 0 2px 8px rgba(0,0,0,.3); }
        #nav ul li a, #nav ul li button {
            color: #fff !important;
            text-shadow: 0 1px 4px rgba(0,0,0,.25);
        }
        .data-table { width: 100%; border-collapse: collapse; margin-top: 1em; }
        .data-table th {
            background: #3fb1a3; color: #fff;
            padding: .7em 1.1em; text-align: left; font-weight: 600;
        }
        .data-table td { padding: .65em 1.1em; border-bottom: 1px solid rgba(0,0,0,.07); }
        .data-table tr:last-child td { border-bottom: none; }
        .data-table tr:hover td { background: rgba(63,177,163,.06); }
        .watering-badge {
            display: inline-block; background: rgba(63,177,163,.12);
            color: #2a9d8f; border: 1px solid rgba(63,177,163,.3);
            border-radius: 20px; padding: .2em .8em; font-size: .82em; font-weight: 600;
        }
        .filter-bar { display: flex; gap: 1em; flex-wrap: wrap; align-items: flex-end; margin-bottom: 1.5em; }
        .filter-bar > div { display: flex; flex-direction: column; gap: .3em; flex: 1; min-width: 180px; }
        .filter-bar label { font-size: .78em; text-transform: uppercase; letter-spacing: .1em; opacity: .6; }
        .filter-bar select, .filter-bar input[type=text] { margin: 0; }
        .empty-state { text-align: center; padding: 3em 1em; opacity: .5; }
        .empty-state .icon { font-size: 3em; display: block; margin-bottom: .4em; }
    </style>
</head>
<body class="index">
<div id="page-wrapper">

    <header id="header" class="alt">
        <h1 id="logo"><a href="/catalogue">Plant <span>Care Diary</span></a></h1>
        <nav id="nav">
            <ul>
                @if($user)
                    <li><a href="{{ route('home') }}">Panel</a></li>
                @endif
                <li class="current"><a href="{{ route('catalogue') }}">Katalog roślin</a></li>
                @if($user)
                    <li><a href="{{ route('plants.index') }}">Moje rośliny</a></li>
                    <li><a href="{{ route('diary.index') }}">Pamiętnik</a></li>
                    @if($user->isAdmin())
                    <li><a href="{{ route('admin.plant-types') }}">Admin</a></li>
                    @endif
                    <li><a href="{{ route('nickname.show') }}" style="font-size:.85em;opacity:.8;">{{ $user->nickname }}</a></li>
                    <li>
                        <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                            @csrf
                            <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;font-size:inherit;">Wyloguj</button>
                        </form>
                    </li>
                @else
                    <li><a href="{{ route('login') }}">Logowanie</a></li>
                    <li><a href="{{ route('register') }}">Rejestracja</a></li>
                @endif
            </ul>
        </nav>
    </header>

    <article id="main">
        <header class="special container">
            <span class="icon solid fa-leaf"></span>
            <h2>Katalog Roślin</h2>
            <p style="opacity:.65;">Ogólne informacje o typach roślin i zaleceniach pielęgnacyjnych.</p>

            @if(!$user)
                <div style="background:rgba(63,177,163,.12);border:1px solid rgba(63,177,163,.3);border-radius:6px;padding:.9em 1.2em;display:inline-block;margin-top:.5em;font-size:.9em;">
                    <span class="icon solid fa-info-circle" style="color:#3fb1a3;margin-right:.4em;"></span>
                    <a href="{{ route('register') }}">Zarejestruj się</a> lub
                    <a href="{{ route('login') }}">zaloguj się</a>, żeby dodawać własne rośliny i prowadzić pamiętnik.
                </div>
            @endif
        </header>

        <section class="wrapper style4 special container large">
            <div class="content">

                {{-- pasek filtrów --}}
                <form method="GET" action="{{ route('catalogue') }}">
                <div class="filter-bar">
                    <div>
                        <label>Szukaj po nazwie</label>
                        <input type="text" name="search"
                               placeholder="np. Sukulenty..."
                               value="{{ $search ?? '' }}" />
                    </div>
                    <div style="flex:0;min-width:140px;">
                        <label>Podlewanie</label>
                        <select name="watering">
                            <option value="">Wszystkie</option>
                            <option value="frequent" {{ ($wateringFilter ?? '') === 'frequent' ? 'selected' : '' }}>
                                Częściej niż co tydzień
                            </option>
                            <option value="weekly" {{ ($wateringFilter ?? '') === 'weekly' ? 'selected' : '' }}>
                                Co tydzień lub rzadziej
                            </option>
                        </select>
                    </div>
                    <div style="flex:0;align-items:flex-end;">
                        <ul class="buttons" style="margin:0;">
                            <li><input type="submit" class="special small" value="Szukaj" /></li>
                            @if(!empty($search) || !empty($wateringFilter))
                                <li><a href="{{ route('catalogue') }}" class="button small">Wyczyść</a></li>
                            @endif
                        </ul>
                    </div>
                </div>
                </form>

                @if(empty($plantTypes))
                    <div class="empty-state">
                        <span class="icon solid fa-leaf"></span>
                        <p>Brak typów roślin w katalogu.<br>Administrator musi je najpierw dodać.</p>
                    </div>
                @else
                    <table class="data-table">
                        <thead>
                            <tr>
                                <th>Typ rośliny</th>
                                <th>Opis</th>
                                <th style="white-space:nowrap;">Podlewanie co</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($plantTypes as $pt)
                            <tr>
                                <td>
                                    <span class="icon solid fa-leaf" style="color:#3fb1a3;margin-right:.4em;"></span>
                                    <strong>{{ $pt['name'] }}</strong>
                                </td>
                                <td style="opacity:.75;">{{ $pt['description'] ?? '—' }}</td>
                                <td>
                                    <span class="watering-badge">
                                        {{ $pt['watering_interval_days'] }}
                                        {{ $pt['watering_interval_days'] == 1 ? 'dzień' : 'dni' }}
                                    </span>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </section>
    </article>

    <footer id="footer">
        <ul class="copyright">
            <li>&copy; Plant Care Diary</li>
            <li>Design: <a href="http://html5up.net">HTML5 UP</a></li>
        </ul>
    </footer>
</div>
</body>
</html>

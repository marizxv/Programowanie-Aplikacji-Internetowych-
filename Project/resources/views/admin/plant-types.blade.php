<!DOCTYPE HTML>
<html>
<head>
    <title>Typy Roślin [Admin] — Plant Care Diary</title>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no" />
    <link rel="stylesheet" href="{{ asset('assets/css/main.css') }}" />
    <style>
        body { margin: 0; }
        #page-wrapper { display: flex; flex-direction: column; min-height: 100vh; }
        #main { flex: 1 0 auto; }
        #footer { flex-shrink: 0; }
        #logo a { text-shadow: 0 2px 8px rgba(0,0,0,.3); }
        #nav ul li a, #nav ul li button { color: #fff !important; text-shadow: 0 1px 4px rgba(0,0,0,.25); }
        .admin-banner {
            background: rgba(230,168,23,.15); border: 1px solid rgba(230,168,23,.4);
            border-radius: 6px; padding: .7em 1.2em; margin-bottom: 1.5em;
            font-size: .88em; color: #856404;
        }
        .data-table { width: 100%; border-collapse: collapse; }
        .data-table th { background: #3fb1a3; color: #fff; padding: .7em 1.1em; text-align: left; }
        .data-table td { padding: .65em 1.1em; border-bottom: 1px solid rgba(0,0,0,.07); vertical-align: middle; }
        .data-table tr:hover td { background: rgba(63,177,163,.05); }
        .badge-active   { display:inline-block;background:rgba(39,174,96,.15);color:#27ae60;border:1px solid rgba(39,174,96,.3);border-radius:20px;padding:.15em .7em;font-size:.78em; }
        .badge-inactive { display:inline-block;background:rgba(231,76,60,.12);color:#c0392b;border:1px solid rgba(231,76,60,.3);border-radius:20px;padding:.15em .7em;font-size:.78em; }
        .section-divider { border: none; border-top: 1px solid rgba(0,0,0,.1); margin: 2em 0; }
    </style>
</head>
<body class="index">
<div id="page-wrapper">

    <header id="header" class="alt">
        <h1 id="logo"><a href="/">Plant <span>Care Diary</span></a></h1>
        <nav id="nav">
            <ul>
                <li><a href="{{ route('home') }}">Panel</a></li>
                <li><a href="{{ route('catalogue') }}">Katalog roślin</a></li>
                <li><a href="{{ route('plants.index') }}">Moje rośliny</a></li>
                <li><a href="{{ route('diary.index') }}">Pamiętnik</a></li>
                <li class="current"><a href="{{ route('admin.plant-types') }}">Admin</a></li>
                <li><a href="{{ route('nickname.show') }}" style="font-size:.85em;opacity:.8;">{{ $user->nickname }}</a></li>
                <li>
                    <form action="{{ route('logout') }}" method="POST" style="display:inline;">
                        @csrf
                        <button type="submit" style="background:none;border:none;color:inherit;cursor:pointer;font-size:inherit;">Wyloguj</button>
                    </form>
                </li>
            </ul>
        </nav>
    </header>

    <article id="main">
        <header class="special container">
            <span class="icon solid fa-cog"></span>
            <h2>Typy Roślin</h2>
            <p style="opacity:.65;">Zarządzanie katalogiem — widocznym dla wszystkich użytkowników.</p>

            @if(!empty($infos))
                <div style="background:#d4edda;border-left:4px solid #28a745;padding:1em;margin:1em auto;max-width:560px;text-align:left;border-radius:4px;">
                    @foreach($infos as $info)<p style="margin:0;color:#155724;">{{ $info }}</p>@endforeach
                </div>
            @endif
        </header>

        <section class="wrapper style4 special container large">
            <div class="content">

                <div class="admin-banner">
                    <span class="icon solid fa-exclamation-triangle"></span>
                    &nbsp; Panel administratora — zmiany są widoczne dla wszystkich użytkowników.
                </div>

                {{-- formularz dodania nowego typu --}}
                <h3 style="margin-bottom:1em;">Dodaj nowy typ rośliny</h3>
                <form action="#" method="POST">
                    @csrf
                    <div class="row gtr-50">
                        <div class="col-6 col-12-mobile">
                            <input type="text" name="name" placeholder="Nazwa typu (np. Bambus)" maxlength="100" required />
                        </div>
                        <div class="col-6 col-12-mobile">
                            <input type="number" name="watering_interval_days"
                                   placeholder="Podlewanie co X dni" min="1" max="365" required />
                        </div>
                        <div class="col-12">
                            <textarea name="description" rows="2"
                                      placeholder="Krótki opis (opcjonalny)…"
                                      style="width:100%;padding:.75em;background:none;border:solid 1px rgba(124,128,129,.2);border-radius:4px;font-family:inherit;resize:vertical;"></textarea>
                        </div>
                        <div class="col-12">
                            <ul class="buttons">
                                <li><input type="submit" class="special small" value="Dodaj typ" /></li>
                            </ul>
                        </div>
                    </div>
                </form>

                <hr class="section-divider">

                {{-- lista istniejących typów --}}
                <h3 style="margin-bottom:1em;">Istniejące typy</h3>

                @if(!empty($errors))
                    <div style="background:#ffdddd;border-left:4px solid #f44336;padding:1em;margin-bottom:1em;border-radius:4px;">
                        <ul style="margin:0;padding-left:1.2em;">
                            @foreach($errors as $err)<li>{{ $err }}</li>@endforeach
                        </ul>
                    </div>
                @endif

                <table class="data-table">
                    <thead>
                        <tr>
                            <th>Nazwa</th>
                            <th>Opis</th>
                            <th style="white-space:nowrap;">Podlewanie co</th>
                            <th>Status</th>
                            <th>Akcje</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($plantTypes as $pt)
                        <tr>
                            <td><strong>{{ $pt['name'] }}</strong></td>
                            <td style="opacity:.7;font-size:.85em;">{{ $pt['description'] ?? '—' }}</td>
                            <td style="text-align:center;">{{ $pt['watering_interval_days'] }} dni</td>
                            <td>
                                @if($pt['is_active'])
                                    <span class="badge-active">Aktywny</span>
                                @else
                                    <span class="badge-inactive">Nieaktywny</span>
                                @endif
                            </td>
                            <td>
                                <a href="#" style="font-size:.82em;margin-right:.6em;">Edytuj</a>
                                <a href="#" style="font-size:.82em;opacity:.5;">
                                    {{ $pt['is_active'] ? 'Dezaktywuj' : 'Aktywuj' }}
                                </a>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="5" style="text-align:center;opacity:.5;padding:2em;">
                                Brak typów roślin w bazie.
                            </td>
                        </tr>
                        @endforelse
                    </tbody>
                </table>

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

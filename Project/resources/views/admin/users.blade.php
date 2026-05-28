<!DOCTYPE HTML>
<html>
<head>
    <title>Użytkownicy [Admin] — Plant Care Diary</title>
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
        .role-badge {
            display: inline-block; border-radius: 20px; padding: .2em .75em;
            font-size: .78em; font-weight: 600;
        }
        .role-admin { background: rgba(230,168,23,.2); color: #856404; border: 1px solid rgba(230,168,23,.4); }
        .role-user  { background: rgba(63,177,163,.15); color: #2a9d8f; border: 1px solid rgba(63,177,163,.3); }
        .filter-bar { display:flex; gap:1em; flex-wrap:wrap; align-items:flex-end; margin-bottom:1.5em; }
        .filter-bar > div { display:flex; flex-direction:column; gap:.3em; flex:1; min-width:160px; }
        .filter-bar label { font-size:.78em; text-transform:uppercase; letter-spacing:.1em; opacity:.6; }
        .filter-bar select, .filter-bar input { margin: 0; }
        .inline-form { display:inline; }
        .inline-form select {
            padding:.2em .5em;font-size:.82em;background:none;
            border:1px solid rgba(0,0,0,.2);border-radius:4px;
        }
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
                <li class="current"><a href="{{ route('admin.users') }}">Admin</a></li>
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
            <span class="icon solid fa-users"></span>
            <h2>Użytkownicy</h2>
            <p style="opacity:.65;">Zarządzanie kontami i rolami w systemie.</p>

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
                    &nbsp; Panel administratora — zmiany ról są natychmiastowe.
                </div>

                {{-- filtry --}}
                <div class="filter-bar">
                    <div>
                        <label>Szukaj po nicku lub emailu</label>
                        <input type="text" placeholder="np. maria…" />
                    </div>
                    <div style="flex:0;min-width:140px;">
                        <label>Filtruj po roli</label>
                        <select>
                            <option value="">Wszystkie role</option>
                            @foreach($roles as $role)
                                <option value="{{ $role['id'] }}">{{ ucfirst($role['name']) }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div style="flex:0;align-items:flex-end;">
                        <ul class="buttons" style="margin:0;">
                            <li><input type="submit" class="special small" value="Szukaj" /></li>
                        </ul>
                    </div>
                </div>

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
                            <th>#</th>
                            <th>Nick</th>
                            <th>Email</th>
                            <th>Rola</th>
                            <th>Zarejestrowano</th>
                            <th>Zmień rolę</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($users as $u)
                        <tr>
                            <td style="opacity:.45;font-size:.8em;">{{ $u['id'] }}</td>
                            <td><strong>{{ $u['nickname'] }}</strong></td>
                            <td style="opacity:.7;font-size:.88em;">{{ $u['email'] }}</td>
                            <td>
                                {{-- TODO: pobierać aktywną rolę z user_roles --}}
                                <span class="role-badge role-user">user</span>
                            </td>
                            <td style="opacity:.6;font-size:.82em;white-space:nowrap;">{{ $u['created_at'] }}</td>
                            <td>
                                {{-- TODO: podpiąć działające nadawanie ról --}}
                                <form action="#" method="POST" class="inline-form">
                                    @csrf
                                    <input type="hidden" name="user_id" value="{{ $u['id'] }}" />
                                    <select name="role_id">
                                        @foreach($roles as $role)
                                            <option value="{{ $role['id'] }}">{{ ucfirst($role['name']) }}</option>
                                        @endforeach
                                    </select>
                                    &nbsp;<button type="submit"
                                            style="background:#3fb1a3;color:#fff;border:none;border-radius:4px;padding:.25em .8em;cursor:pointer;font-size:.82em;">
                                        Zapisz
                                    </button>
                                </form>
                            </td>
                        </tr>
                        @empty
                        <tr>
                            <td colspan="6" style="text-align:center;opacity:.5;padding:2em;">
                                Brak użytkowników w bazie.
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

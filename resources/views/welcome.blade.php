<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('messages.price')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<div>
    @if (Route::has('login') && Auth::check())
        <div class="log">
            <a href="{{ url('/profile') }}">Profile</a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf

                <x-responsive-nav-link :href="route('logout')"
                                       onclick="event.preventDefault();
                                        this.closest('form').submit();">
                    {{ __('Log Out') }}
                </x-responsive-nav-link>
            </form>
        </div>
    @elseif (Route::has('login') && !Auth::check())
        <div class="log">
            <a href="{{ url('/login') }}">Login</a>
            <a href="{{ url('/register') }}">Register</a>
        </div>
    @endif
    <div class="container">
        <h1>@lang('messages.price')</h1>
        <a href="{{ route('mekle') }}" class="button">@lang('messages.search')</a>

        <div class="language-switcher">
            <a class='underline' href="locale/lv">Latvian</a>
            <a class='underline' href="locale/en">English</a>
        </div>
    </div>
</div>
</body>
</html>

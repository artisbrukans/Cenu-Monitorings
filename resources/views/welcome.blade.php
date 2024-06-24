<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('messages.price')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<div class="container">
    <h1>@lang('messages.price')</h1>
    <a href="{{ route('mekle') }}" class="button">@lang('messages.search')</a>
    <a href="{{ route('pievieno') }}" class="button">@lang('messages.add')</a>

    <div class="language-switcher">
        <a class='underline' href="locale/lv">Latvian</a>
        <a class='underline' href="locale/en">English</a>
    </div>
</div>
</body>
</html>

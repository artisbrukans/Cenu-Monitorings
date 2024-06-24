<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ __('messages.title') }}</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<div class="container">
    <h1>{{ __('messages.title') }}</h1>
    <a href="{{ route('mekle') }}" class="button">{{ __('messages.search') }}</a>
    <a href="{{ route('pievieno') }}" class="button">{{ __('messages.add') }}</a>
    <div class="language-switcher">
        @csrf
        <p>Current Locale: {{ session('locale', 'default') }}</p>
        <a href="{{ route('locale.setting', 'en') }}">English</a>
        <a href="{{ route('locale.setting', 'lv') }}">Latviešu</a>
    </div>
</div>
</body>
</html>

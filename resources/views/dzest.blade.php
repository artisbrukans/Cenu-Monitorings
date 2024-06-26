<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('messages.delete')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}">
</head>
<body>
<div class="container">
    <h1>@lang('messages.delete')</h1>
    <form action="{{ url('/dzest') }}" method="POST">
        @csrf
        <div class="form-section">
            <label for="CenuZimeID">@lang('messages.pricetag')</label>
            <input type="text" id="CenuZimeID" name="CenuZimeID" required>
        </div>
        <br>
        @if(session('status'))
            <div class="success-message">
                {{ session('status') }}
            </div>
        @endif
        @if(session('error'))
            <div class="error-message">
                {{ session('error') }}
            </div>
        @endif

        <div>
            @if(Auth::check())
                @if(Auth::user()->isAdmin())
                    <button type="submit" class="button">@lang('messages.delete')</button>
                    <a href="{{ url('admin/dashboard') }}" class="button">@lang('messages.back')</a>
                @else
                    <button type="submit" class="button">@lang('messages.delete')</button>
                    <a href="{{ url('/dashboard') }}" class="button">@lang('messages.back')</a>
                @endif
            @else
                <button type="submit" class="button">@lang('messages.delete')</button>
                <a href="{{ url('/') }}" class="button">@lang('messages.back')</a>
            @endif
        </div>
    </form>
</div>
</body>
</html>

<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@lang('messages.add')</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> <!-- Assuming you have a CSS file for styling -->
</head>
<body>
<div class="container">
    <h1>@lang('messages.add')</h1>

    <!-- Display success message if it exists in session -->
    @if(session('success'))
        <div class="alert alert-success">
            {{ session('success') }}
        </div>
    @endif

    <!-- Display error message if it exists in session -->
    @if(session('error'))
        <div class="alert alert-danger">
            {{ session('error') }}
        </div>
    @endif

    <form action="{{ url('/submit') }}" method="POST">
        @csrf <!-- CSRF protection -->

        <!-- Display general error messages -->
        @if($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <div class="form-section">
            <h2>@lang('messages.product')</h2>
            <label for="svitrkods">@lang('messages.barcode'):</label>
            <input type="text" id="svitrkods" name="svitrkods" value="{{ old('svitrkods') }}" pattern="\d{8}" required title="Svītrkodam jābūt 8 ciparus garam.">
            @error('svitrkods')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="nosaukums">@lang('messages.prname'):</label>
            <input type="text" id="nosaukums" name="nosaukums" value="{{ old('nosaukums') }}" required>
            @error('nosaukums')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="daudzums">@lang('messages.count'):</label>
            <input type="number" id="daudzums" name="daudzums" value="{{ old('daudzums') }}" required>
            @error('daudzums')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="mervieniba">@lang('messages.measure'):</label>
            <input type="text" id="mervieniba" name="mervieniba" value="{{ old('mervieniba') }}" required>
            @error('mervieniba')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-section">
            <h2>@lang('messages.store')</h2>
            <label for="nosaukums_veikals">@lang('messages.shname'):</label>
            <input type="text" id="nosaukums_veikals" name="nosaukums_veikals" value="{{ old('nosaukums_veikals') }}" required>
            @error('nosaukums_veikals')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="valsts">@lang('messages.country'):</label>
            <input type="text" id="valsts" name="valsts" value="{{ old('valsts') }}" required>
            @error('valsts')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="pilseta">@lang('messages.city'):</label>
            <input type="text" id="pilseta" name="pilseta" value="{{ old('pilseta') }}" required>
            @error('pilseta')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="iela">@lang('messages.street'):</label>
            <input type="text" id="iela" name="iela" value="{{ old('iela') }}" required>
            @error('iela')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-section">
            <h2>@lang('messages.sales')</h2>
            <label for="cena_vienu">@lang('messages.one'):</label>
            <input type="number" step="0.01" id="cena_vienu" name="cena_vienu" value="{{ old('cena_vienu') }}" required min="0">
            @error('cena_vienu')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="cena_vienibu">@lang('messages.unit'):</label>
            <input type="number" step="0.01" id="cena_vienibu" name="cena_vienibu" value="{{ old('cena_vienibu') }}" required min="0">
            @error('cena_vienibu')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="akcijas_cena">@lang('messages.sale'):</label>
            <input type="number" step="0.01" id="akcijas_cena" name="akcijas_cena" value="{{ old('akcijas_cena') }}">
            @error('akcijas_cena')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="akcijas_garums">@lang('messages.limit') (YYYY-MM-DD):</label>
            <input type="date" id="akcijas_garums" name="akcijas_garums" value="{{ old('akcijas_garums') }}">
            @error('akcijas_garums')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div>
            @if(Auth::check())
                @if(Auth::user()->isAdmin())
                    <button type="submit" class="button">@lang('messages.add')</button>
                    <a href="{{ url('admin/dashboard') }}" class="button">@lang('messages.back')</a>
                @else
                    <button type="submit" class="button">@lang('messages.add')</button>
                    <a href="{{ url('/dashboard') }}" class="button">@lang('messages.back')</a>
                @endif
            @else
                <button type="submit" class="button">@lang('messages.add')</button>
                <a href="{{ url('/') }}" class="button">@lang('messages.back')</a>
            @endif
        </div>
    </form>
</div>
</body>
</html>

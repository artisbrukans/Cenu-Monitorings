<!DOCTYPE html>
<html lang="lv">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pievieno</title>
    <link rel="stylesheet" href="{{ asset('css/styles.css') }}"> <!-- Assuming you have a CSS file for styling -->
</head>
<body>
<div class="container">
    <h1>Pievieno</h1>

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
            <h2>Produkts</h2>
            <label for="svitrkods">Svītrkods:</label>
            <input type="text" id="svitrkods" name="svitrkods" value="{{ old('svitrkods') }}" pattern="\d{8}" required title="Svītrkodam jābūt 8 ciparus garam.">
            @error('svitrkods')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="nosaukums">Nosaukums:</label>
            <input type="text" id="nosaukums" name="nosaukums" value="{{ old('nosaukums') }}" required>
            @error('nosaukums')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="daudzums">Daudzums:</label>
            <input type="number" id="daudzums" name="daudzums" value="{{ old('daudzums') }}" required>
            @error('daudzums')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="mervieniba">Mērvienība:</label>
            <input type="text" id="mervieniba" name="mervieniba" value="{{ old('mervieniba') }}" required>
            @error('mervieniba')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-section">
            <h2>Veikals</h2>
            <label for="nosaukums_veikals">Nosaukums:</label>
            <input type="text" id="nosaukums_veikals" name="nosaukums_veikals" value="{{ old('nosaukums_veikals') }}" required>
            @error('nosaukums_veikals')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="valsts">Valsts:</label>
            <input type="text" id="valsts" name="valsts" value="{{ old('valsts') }}" required>
            @error('valsts')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="pilseta">Pilsēta:</label>
            <input type="text" id="pilseta" name="pilseta" value="{{ old('pilseta') }}" required>
            @error('pilseta')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="iela">Iela:</label>
            <input type="text" id="iela" name="iela" value="{{ old('iela') }}" required>
            @error('iela')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div class="form-section">
            <h2>Cena</h2>
            <label for="cena_vienu">Cena par vienu:</label>
            <input type="number" step="0.01" id="cena_vienu" name="cena_vienu" value="{{ old('cena_vienu') }}" required min="0">
            @error('cena_vienu')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="cena_vienibu">Cena par vienību:</label>
            <input type="number" step="0.01" id="cena_vienibu" name="cena_vienibu" value="{{ old('cena_vienibu') }}" required min="0">
            @error('cena_vienibu')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="akcijas_cena">Akcijas cena:</label>
            <input type="number" step="0.01" id="akcijas_cena" name="akcijas_cena" value="{{ old('akcijas_cena') }}">
            @error('akcijas_cena')
            <div class="error">{{ $message }}</div>
            @enderror

            <label for="akcijas_garums">Akcijas garums (YYYY-MM-DD):</label>
            <input type="date" id="akcijas_garums" name="akcijas_garums" value="{{ old('akcijas_garums') }}">
            @error('akcijas_garums')
            <div class="error">{{ $message }}</div>
            @enderror
        </div>
        <div style="text-align: center;">
            <button type="submit" class="button">Pievienot</button>
            <!-- Redirects to the welcome view -->
            <a href="{{ url('/') }}" class="button">Atpakaļ</a>
        </div>
    </form>
</div>
</body>
</html>

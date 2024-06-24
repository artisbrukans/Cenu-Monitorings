<?php

use App\Http\Controllers\LocaleController;
use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

Route::get('/', function () {
    return view('welcome');
});

Route::get('locale/{lang}', [LocaleController::class, 'setLocale']);

// Search product form view route
Route::get('/mekle', function () {
    $product = DB::table('Produkts')
        ->join('CenuZime', 'Produkts.Svitrkods', '=', 'CenuZime.Svitrkods')
        ->join('Veikals', 'CenuZime.VeikalsID', '=', 'Veikals.VeikalsID')
        ->join('Cena', 'CenuZime.CenaID', '=', 'Cena.CenaID')
        ->leftJoin('Akcija', 'Cena.AkcijaID', '=', 'Akcija.AkcijaID')
        ->select(
            'Produkts.Svitrkods',
            'Produkts.Nosaukums as Produkts_Nosaukums',
            'Produkts.Daudzums',
            'Produkts.Mervieniba',
            'CenuZime.Datums',
            'Veikals.Nosaukums as Veikals_Nosaukums',
            'Veikals.Iela',
            'Veikals.Pilseta',
            'Veikals.Valsts',
            'Cena.CenaParVienu',
            'Cena.CenaParVienibu',
            'Akcija.AkcijaSpeka',
            'Akcija.AkcijasCena'
        )
        ->where('Produkts.Svitrkods', 0)
        ->get();

    // Return the search view with the product details
    return view('mekle', compact('product'));
})->name('mekle');

Route::get('mekle/locale/{lang}', [LocaleController::class, 'setLocale']);

// Search product form submission route
Route::post('/mekle', function (Request $request) {
    // Validate the request data
    $validatedData = $request->validate([
        'svitrkods' => 'required|digits:8',
    ]);

    // Store the submitted data in session
    session()->put('submitted_data', [
        'svitrkods' => $request->svitrkods,
    ]);

    // Query to get the product details
    $product = DB::table('Produkts')
        ->join('CenuZime', 'Produkts.Svitrkods', '=', 'CenuZime.Svitrkods')
        ->join('Veikals', 'CenuZime.VeikalsID', '=', 'Veikals.VeikalsID')
        ->join('Cena', 'CenuZime.CenaID', '=', 'Cena.CenaID')
        ->leftJoin('Akcija', 'Cena.AkcijaID', '=', 'Akcija.AkcijaID')
        ->select(
            'Produkts.Svitrkods',
            'Produkts.Nosaukums as Produkts_Nosaukums',
            'Produkts.Daudzums',
            'Produkts.Mervieniba',
            'CenuZime.Datums',
            'Veikals.Nosaukums as Veikals_Nosaukums',
            'Veikals.Iela',
            'Veikals.Pilseta',
            'Veikals.Valsts',
            'Cena.CenaParVienu',
            'Cena.CenaParVienibu',
            'Akcija.AkcijaSpeka',
            'Akcija.AkcijasCena'
        )
        ->where('Produkts.Svitrkods', $request->svitrkods)
        ->get();

    // Return the search view with the product details
    return view('mekle', compact('product'));
});

Route::get('mekle/locale/{lang}', [LocaleController::class, 'setLocale']);


// Route to show the add product form
Route::get('/pievieno', function () {
    return view('pievieno');
})->name('pievieno');

Route::get('pievieno/locale/{lang}', [LocaleController::class, 'setLocale']);

// Route to handle form submission from pievieno.blade.php
Route::post('/submit', function (Request $request) {
    // Validate incoming form data
    $validatedData = $request->validate([
        'svitrkods' => 'required|digits:8',
        'nosaukums' => 'required|string',
        'daudzums' => 'required|integer|min:0',
        'mervieniba' => 'required|string',
        'nosaukums_veikals' => 'required|string',
        'valsts' => 'required|string',
        'pilseta' => 'required|string',
        'iela' => 'required|string',
        'cena_vienu' => 'required|numeric|min:0',
        'cena_vienibu' => 'required|numeric|min:0',
        'akcijas_cena' => 'nullable|numeric|min:0',
        'akcijas_garums' => 'nullable|date_format:Y-m-d',
    ]);

    // Check if the svitrkods already exists in the database
    $existingSvitrkods = DB::table('Produkts')
        ->where('svitrkods', $validatedData['svitrkods'])
        ->exists();

    // If no record exists, insert the new data
    if (!$existingSvitrkods) {
        DB::table('Produkts')->insert([
            'svitrkods' => $validatedData['svitrkods'],
            'nosaukums' => $validatedData['nosaukums'],
            'daudzums' => $validatedData['daudzums'],
            'mervieniba' => $validatedData['mervieniba'],
        ]);

        $request->session()->flash('success', 'Product submission successful!');
    } else {
        $request->session()->flash('info', 'Product already exists!');
    }

    // Check if the Veikals already exists in the database
    $existingVeikals = DB::table('Veikals')
        ->where('Nosaukums', $validatedData['nosaukums_veikals'])
        ->where('Iela', $validatedData['iela'])
        ->where('Pilseta', $validatedData['pilseta'])
        ->where('Valsts', $validatedData['valsts'])
        ->first();

    if (!$existingVeikals) {
        $veikalsID = DB::table('Veikals')->insertGetId([
            'Nosaukums' => $validatedData['nosaukums_veikals'],
            'Iela' => $validatedData['iela'],
            'Pilseta' => $validatedData['pilseta'],
            'Valsts' => $validatedData['valsts'],
        ]);

        $request->session()->flash('success', 'Store submission successful!');
    } else {
        $veikalsID = $existingVeikals->VeikalsID;
        $request->session()->flash('info', 'Store already exists!');
    }

    // Check if the Akcija already exists in the database
    $existingAkcija = DB::table('Akcija')
        ->where('AkcijaSpeka', $validatedData['akcijas_garums'])
        ->where('AkcijasCena', $validatedData['akcijas_cena'])
        ->first();

    if (!$existingAkcija) {
        $akcijaID = DB::table('Akcija')->insertGetId([
            'AkcijaSpeka' => $validatedData['akcijas_garums'],
            'AkcijasCena' => $validatedData['akcijas_cena'],
        ]);

        $request->session()->flash('success', 'Promotion submission successful!');
    } else {
        $akcijaID = $existingAkcija->AkcijaID;
        $request->session()->flash('info', 'Promotion already exists!');
    }

    // Check if the Cena already exists in the database
    $existingCena = DB::table('Cena')
        ->where('CenaParVienu', $validatedData['cena_vienu'])
        ->where('CenaParVienibu', $validatedData['cena_vienibu'])
        ->where('AkcijaID', $akcijaID)
        ->first();

    if (!$existingCena) {
        $cenaID = DB::table('Cena')->insertGetId([
            'CenaParVienu' => $validatedData['cena_vienu'],
            'CenaParVienibu' => $validatedData['cena_vienibu'],
            'AkcijaID' => $akcijaID,
        ]);

        $request->session()->flash('success', 'Price submission successful!');
    } else {
        $cenaID = $existingCena->CenaID;
        $request->session()->flash('info', 'Price already exists!');
    }

    // Insert new CenuZime
    DB::table('CenuZime')->insert([
        'Svitrkods' => $validatedData['svitrkods'],
        'VeikalsID' => $veikalsID,
        'Datums' => now(),
        'CenaID' => $cenaID,
    ]);

    $request->session()->flash('success', 'CenuZime submission successful!');

    return redirect('/pievieno')->with('submitted_data', $validatedData);
});

Route::get('pievieno/locale/{lang}', [LocaleController::class, 'setLocale']);

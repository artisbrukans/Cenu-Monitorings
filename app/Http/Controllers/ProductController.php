<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductController extends Controller
{
    public function searchFormView()
    {
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

        return view('mekle', compact('product'));
    }

    public function searchProduct(Request $request)
    {
        $validatedData = $request->validate([
            'svitrkods' => 'required|digits:8',
        ]);

        session()->put('submitted_data', [
            'svitrkods' => $request->svitrkods,
        ]);

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

        return view('mekle', compact('product'));
    }

    public function submitProduct(Request $request)
    {
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

        $productExists = DB::table('Produkts')->where('svitrkods', $validatedData['svitrkods'])->exists();
        $storeData = [
            'Nosaukums' => $validatedData['nosaukums_veikals'],
            'Iela' => $validatedData['iela'],
            'Pilseta' => $validatedData['pilseta'],
            'Valsts' => $validatedData['valsts'],
        ];
        $store = DB::table('Veikals')->where($storeData)->first();
        $storeID = $store ? $store->VeikalsID : DB::table('Veikals')->insertGetId($storeData);

        $promotionData = [
            'AkcijaSpeka' => $validatedData['akcijas_garums'],
            'AkcijasCena' => $validatedData['akcijas_cena'],
        ];
        $promotion = DB::table('Akcija')->where($promotionData)->first();
        $promotionID = $promotion ? $promotion->AkcijaID : DB::table('Akcija')->insertGetId($promotionData);

        $priceData = [
            'CenaParVienu' => $validatedData['cena_vienu'],
            'CenaParVienibu' => $validatedData['cena_vienibu'],
            'AkcijaID' => $promotionID,
        ];
        $price = DB::table('Cena')->where($priceData)->first();
        $priceID = $price ? $price->CenaID : DB::table('Cena')->insertGetId($priceData);

        if (!$productExists) {
            DB::table('Produkts')->insert([
                'svitrkods' => $validatedData['svitrkods'],
                'nosaukums' => $validatedData['nosaukums'],
                'daudzums' => $validatedData['daudzums'],
                'mervieniba' => $validatedData['mervieniba'],
            ]);
        }

        DB::table('CenuZime')->insert([
            'Svitrkods' => $validatedData['svitrkods'],
            'VeikalsID' => $storeID,
            'Datums' => now(),
            'CenaID' => $priceID,
        ]);

        $request->session()->flash('success', 'Product, store, promotion, and price submitted successfully!');

        return redirect('/pievieno')->with('submitted_data', $validatedData);
    }

}

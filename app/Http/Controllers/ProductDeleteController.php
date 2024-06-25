<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductDeleteController extends Controller
{
    public function showDeleteForm(Request $request)
    {
        $svitrkods = $request->input('svitrkods', '');  // Initialize $svitrkods with an empty string if not provided
        $product = collect();

        if ($svitrkods) {
            $product = DB::table('products')->where('Svitrkods', $svitrkods)->get();
        }

        return view('delete-product', compact('product', 'svitrkods'));
    }

    public function deleteProduct(Request $request)
    {
        $svitrkods = $request->input('svitrkods');
        $product = DB::table('products')->where('Svitrkods', $svitrkods)->first();

        if ($product) {
            DB::table('products')->where('Svitrkods', $svitrkods)->delete();
            return redirect()->back()->with('status', __('messages.product_deleted'));
        }

        return redirect()->back()->with('error', __('messages.product_not_found'));
    }
}

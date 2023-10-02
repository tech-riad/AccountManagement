<?php

namespace App\Http\Controllers;

use App\Models\Product;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index()
    {
        $product = Product::all();
        return view('backend.account.index',compact('product',));
    }
}

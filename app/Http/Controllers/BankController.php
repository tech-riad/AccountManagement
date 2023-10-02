<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class BankController extends Controller
{
    public function index()
    {
        $bank = Bank::all();
        return view('backend.bank.index',compact('bank'));
    }

    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'method_name' => 'required|string|max:255',
        ]);

        $bank = new Bank();
        $bank->method_name = $validatedData['method_name'];
        $bank->slug = Str::slug($bank->method_name);
        $bank->save();

        return response()->json(['message' => 'BAnk created successfully', 'bank' => $bank], 201);
    }

    public function update(Request $request, Bank $bank)
    {

        $request->validate([
            'method_name' => 'required|string|max:255',
        ]);


        $bank->update([
            'method_name' => $request->input('method_name'),
            'slug'          => Str::slug($request->input('method_name')),
        ]);


        return response()->json(['message' => 'Bank updated successfully']);
    }

    public function destroy(Bank $bank)
    {
        $bank->delete();

        return response()->json(['message' => 'Bank Method deleted successfully']);
    }


}

<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Bank;
use App\Models\Product;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index()
    {
        $product = Product::all();
        $bank = Bank::all();
        $accounts = Accounts::all();
        return view('backend.account.index',compact('product','bank','accounts'));
    }


    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'transaction_type' => 'required|in:income,expense',
            'account_method' => 'required|exists:banks,id',
            'customer_name' => 'required|string|max:255',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric',
            'created_by' => 'required|string|max:255',
            'received_by' => 'required|string|max:255',
            'product_name' => 'required|exists:products,id',
            'description' => 'nullable|string',
        ]);

        $transaction = new Accounts();
        $transaction->transaction_type = $validatedData['transaction_type'];
        $transaction->account_method = $validatedData['account_method'];
        $transaction->customer_name = $validatedData['customer_name'];
        $transaction->payment_date = $validatedData['payment_date'];
        $transaction->amount = $validatedData['amount'];
        $transaction->created_by = $validatedData['created_by'];
        $transaction->received_by = $validatedData['received_by'];
        $transaction->product_name = $validatedData['product_name'];
        $transaction->description = $validatedData['description'];

        $transaction->save();

        return response()->json(['message' => 'Transaction created successfully', 'transaction' => $transaction], 201);
    }

    public function update(Request $request, Accounts $account)
    {
        $validatedData = $request->validate([
            'transaction_type' => 'required|in:income,expense',
            'account_method' => 'required|exists:banks,id',
            'customer_name' => 'required|string|max:255',
            'payment_date' => 'required|date',
            'amount' => 'required|numeric',
            'created_by' => 'required|string|max:255',
            'received_by' => 'required|string|max:255',
            'product_name' => 'required|exists:products,id',
            'description' => 'nullable|string',
        ]);

        $account->update($validatedData);

        return response()->json(['message' => 'Transaction updated successfully']);
    }

}

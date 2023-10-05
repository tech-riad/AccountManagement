<?php

namespace App\Http\Controllers;

use App\Models\Accounts;
use App\Models\Bank;
use App\Models\Category;
use App\Models\Employee;
use Illuminate\Http\Request;

class AccountsController extends Controller
{
    public function index()
    {
        $employee  = Employee::all();
        $bank     = Bank::all();
        $accounts = Accounts::all();
        $categories = Category::all();
        return view('backend.account.index',compact('employee','bank','accounts','categories'));
    }


    public function store(Request $request)
    {

        $validatedData = $request->validate([
            'category_id'        => 'required|string',
            'transaction_type'   => 'required|in:income,expense',
            'account_method'     => 'required|exists:banks,id',
            'customer_name'      => 'required|string|max:255',
            'payment_date'       => 'required|date',
            'amount'             => 'required|numeric',
            'created_by'         => 'required|string|max:255',
            'employee_name'      => 'required|exists:employees,id',
            'description'        => 'nullable|string',
            'status'             => 'in:paid,canceled,pending',
        ]);

        $transaction = new Accounts();
        $transaction->category_id       = $validatedData['category_id'];
        $transaction->transaction_type  = $validatedData['transaction_type'];
        $transaction->account_method    = $validatedData['account_method'];
        $transaction->customer_name     = $validatedData['customer_name'];
        $transaction->payment_date      = $validatedData['payment_date'];
        $transaction->amount            = $validatedData['amount'];
        $transaction->created_by        = $validatedData['created_by'];
        $transaction->employee_name      = $validatedData['employee_name'];
        $transaction->status            = $validatedData['status'];
        $transaction->description       = $validatedData['description'];

        $transaction->save();

        return response()->json(['message' => 'Transaction created successfully', 'transaction' => $transaction], 201);
    }

    public function update(Request $request, Accounts $account)
    {
        $validatedData = $request->validate([
            'category_id'        => 'required|string',
            'transaction_type'   => 'required|in:income,expense',
            'account_method'     => 'required|exists:banks,id',
            'customer_name'      => 'required|string|max:255',
            'payment_date'       => 'required|date',
            'amount'             => 'required|numeric',
            'created_by'         => 'required|string|max:255',
            'employee_name'      => 'required|exists:employees,id',
            'description'        => 'nullable|string',
            'status'             => 'in:paid,canceled,pending',
        ]);

        $category =Category::findOrFail($request->category_id);
        $validatedData['transaction_type'] = $category->transction_type;

        $account->update($validatedData);

        return response()->json(['message' => 'Transaction updated successfully']);
    }

    public function destroy(Accounts $account)
    {
        $account->delete();

        return response()->json(['message' => 'Account Method deleted successfully']);
    }

    public function getTransactionTypes(Request $request, $categoryId)
    {

        $category = Category::findOrFail($categoryId);

        return response()->json([
            'category' => $category,
        ]);
    }

}

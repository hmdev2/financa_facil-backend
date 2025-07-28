<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;

class TransactionsController
{
    public function show() {
        return Transactions::all();
    }

    public function store(Request $request) {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $transaction = Transactions::create($validated);

        return response()->json([
            'message' => 'success!',
            'transaction' => $transaction
        ], 201);
    }

    public function destroy($id) {
        $transaction = Transactions::find($id);

        if(!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        $transaction->delete();

        return response()->json([
            'message' => 'Transaction deleted successfully!',
            'transaction' => $transaction
        ]);
    }

    public function update(Request $request, $id) {

        $transaction = Transactions::find($id);

        if(!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        $transaction->update($request->all());

        return response()->json([
            'message' => 'Transaction updated successfully',
            'transaction' => $transaction
        ]);
    }

    public function transaction($id) {

        $transaction = Transactions::find($id);

        if(!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ],404);
        }

        return response()->json([
            'transaction' => $transaction
        ]);
    }
}

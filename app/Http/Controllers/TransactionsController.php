<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transactions;

class TransactionsController
{
    public function show(Request $request) {
        return $request->user()->transactions;
    }

    public function store(Request $request) {

        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'type' => 'required|in:income,expense',
            'amount' => 'required|numeric',
            'date' => 'required|date',
        ]);

        $transaction = $request->user()->transactions()->create($validated);

        return response()->json([
            'message' => 'success!',
            'transaction' => $transaction
        ], 201);
    }

    public function destroy(Request $request, $id) {
        $transaction = Transactions::find($id);

         if($transaction->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'forbiden access'
            ], 403);
        }

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

        if($transaction->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'forbiden access'
            ], 403);
        }

        if(!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ], 404);
        }

        $transaction->update($request->only(['title', 'type', 'amount', 'date']));

        return response()->json([
            'message' => 'Transaction updated successfully',
            'transaction' => $transaction
        ]);
    }

    public function transaction(Request $request, $id) {

        $transaction = Transactions::find($id);

        if(!$transaction) {
            return response()->json([
                'message' => 'Transaction not found'
            ],404);
        }

         if($transaction->user_id !== $request->user()->id) {
            return response()->json([
                'message' => 'forbiden access'
            ], 403);
        }


        return response()->json($transaction, 200);
    }
}

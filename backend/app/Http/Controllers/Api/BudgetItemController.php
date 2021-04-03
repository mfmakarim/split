<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\BudgetItem;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetItemController extends Controller
{
    public function post (Request $request)
    {
        $title = $request->input('title');
        $amount = $request->input('amount');
        $type = $request->input('type');
        $category_id = $request->input('category_id');
        $id = $request->input('id');
        $budget_id = $request->input('budget_id');

        $amount_prev = 0;
        $amount_current = 0;

        DB::beginTransaction();
        try {
            $budgetItem = BudgetItem::updateOrCreate(['id' => $id], [
                'title' => $title,
                'amount' => $amount,
                'amount_prev' => $amount_prev,
                'amount_current' => $amount_current,
                'category_id' => $category_id,
                'budget_id' => $budget_id,
                'type' => $type,
            ]);
            DB::commit();
            
            $message = $id ? "Budget item updated!" : "Budget item created!";

            return ResponseFormatter::success($budgetItem, $message, 201);

        } catch (Exception $e) {
            DB::rollback();
            return ResponseFormatter::error(null, $e->getMessage());
        }
    }
}

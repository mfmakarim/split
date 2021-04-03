<?php

namespace App\Http\Controllers\Api;

use App\Helpers\ResponseFormatter;
use App\Http\Controllers\Controller;
use App\Models\Budget;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BudgetController extends Controller
{
    public function post (Request $request)
    {
        $user_id = 1;
        $title = $request->input('title');
        $amount = $request->input('amount');
        $id = $request->input('id');

        $amount_prev = 0;
        $amount_current = 0;
        $existCount = Budget::where('user_id', $user_id)->get()->count();
        $order = $id ? $existCount : $existCount + 1;

        DB::beginTransaction();
        try {
            $budget = Budget::updateOrCreate(['id' => $id], [
                'user_id' => $user_id,
                'title' => $title,
                'amount' => $amount,
                'amount_prev' => $amount_prev,
                'amount_current' => $amount_current,
                'order' => $order
            ]);
            DB::commit();

            $message = $id ? "Budget updated!" : "Budget created!";

            return ResponseFormatter::success($budget, $message, 201);

        } catch (Exception $e) {
            DB::rollback();
            return ResponseFormatter::error(null, $e->getMessage());
        }

    }

    public function index (Request $request)
    {
        $budgets = Budget::query();
        $limit = 10;

        $title = $request->get('title');
        
        if($title)
        {
            $budgets->where('title', 'ilike', '%'. $title .'%');
        }
        
        return ResponseFormatter::success($budgets->paginate($limit), 'Data found!');
        
    }

    public function detail ($id)
    {
        $budgetDetail = Budget::with('budget_items')->find($id);
        if ($budgetDetail) {
            return ResponseFormatter::success($budgetDetail, 'Budget detail found!');
        } else {
            return ResponseFormatter::error(null, 'Budget detail not found', 404);
        }
    }
}

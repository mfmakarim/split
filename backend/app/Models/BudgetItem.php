<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class BudgetItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'amount',
        'amount_prev',
        'amount_current',
        'category_id',
        'budget_id',
        'type',
    ];
}

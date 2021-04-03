<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'amount',
        'amount_prev',
        'amount_current',
        'order'
    ];

    public function budget_items ()
    {
        return $this->hasMany(BudgetItem::class, 'budget_id', 'id');
    }
}

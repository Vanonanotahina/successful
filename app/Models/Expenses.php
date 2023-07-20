<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Expenses extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $table = 'expenses';
    protected $primaryKey = 'ide';
    public $timestamps = false;
    protected $guarded = ['ide'];
    protected $fillable = [
        'spent_id',
        'date',
        'amount',
    ];

    public function spent()
    {
        return $this->belongsTo(Spent::class, 'spent_id');
    }
}

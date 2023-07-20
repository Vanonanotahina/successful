<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spent extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $table = 'spent';
    protected $primaryKey = 'ids';
    public $timestamps = false;
    protected $guarded = ['ids'];
    protected $fillable = [
        'type',
        'budget',
        'code',
    ];

    public function getSpentId($code){
        $spent = Spent::whereCode($code)->first();
        return $spent->ids;
    }
}

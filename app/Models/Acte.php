<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Acte extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $table = 'actes';
    protected $primaryKey = 'ida';
    public $timestamps = false;
    protected $guarded = ['ida'];
    protected $fillable = [
        'type',
        'budget',
        'code',
    ];

}

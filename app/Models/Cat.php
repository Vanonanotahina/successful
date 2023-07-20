<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cat extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $table = 'cats';
    protected $primaryKey = 'idc';
    public $timestamps = false;
    protected $guarded = ['idc'];
    protected $fillable = [
        'categorie',
    ];
}

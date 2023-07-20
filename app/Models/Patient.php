<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Patient extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $table = 'patient';
    protected $primaryKey = 'idp';
    public $timestamps = false;
    protected $guarded = ['idp'];
    protected $fillable = [
        'name',
        'birthday',
        'gender',
        'reimburse',
    ];
}

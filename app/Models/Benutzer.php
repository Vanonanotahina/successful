<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Benutzer extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $table = 'benutzers';
    protected $primaryKey = 'id';
    public $timestamps = false;
    protected $guarded = ['id'];
    protected $fillable = [
        'name',
        'email',
        'password',
        'level',
    ];
}

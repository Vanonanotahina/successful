<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use App\Models\Cat;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Place extends Model
{
    use CrudTrait;
    use HasFactory;
    protected $table = 'places';
    protected $primaryKey = 'idp';
    public $timestamps = false;
    protected $guarded = ['idp'];
    protected $fillable = [
        'name',
        'id_cat',
    ];

    public function cat()
    {
        return $this->belongsTo(Cat::class, 'id_cat');
    }
}

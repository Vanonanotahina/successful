<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Activity extends Model
{
    use HasFactory;
    protected $table = 'activity';
    protected $primaryKey = 'idac';
    public $timestamps = false;
    protected $guarded = ['idac'];
    protected $fillable = [
        'acte_id',
        'patient_id',
        'date',
        'amount',
    ];

    public function acte()
    {
        return $this->belongsTo(Acte::class, 'acte_id');
    }

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }

}

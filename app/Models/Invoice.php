<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Patient;

class Invoice extends Model
{
    use HasFactory;
    protected $table = 'invoice';
    protected $primaryKey = 'idi';
    public $timestamps = false;
    protected $guarded = ['idi'];
    protected $fillable = [
        'patient_id',
        'invoice_date',
        'total',
        'reimburse',
    ];

    public function patient()
    {
        return $this->belongsTo(Patient::class, 'patient_id');
    }
}

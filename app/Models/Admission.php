<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Admission extends Model
{
    use HasFactory;

    protected $fillable = ['patient_id', 'ward', 'admission_datetime'];

    public function patient(): HasOne
    {
        return $this->hasOne(Patient::class, 'id', 'patient_id');
    }

    /**
     * Fetch all admissions in the specified day.
     */
    public static function admissionsForDay(string $day): Collection
    {
        return self::with('patient')->whereDate('admission_datetime', $day)->get();
    }
}

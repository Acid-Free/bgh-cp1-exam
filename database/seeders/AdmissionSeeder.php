<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Admission;
use App\Models\Patient;

class AdmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // Get existing patients
        $patients = Patient::all();

        // Create admissions for existing patients
        foreach ($patients as $key => $patient) {
            Admission::create([
                'patient_id' => $patient->id,
                'ward' => 'Ward ' . ($key + 1),
                'admission_datetime' => now(),
            ]);

            // Limit to creating five admissions
            if ($key >= 4) {
                break;
            }
        }
    }
}

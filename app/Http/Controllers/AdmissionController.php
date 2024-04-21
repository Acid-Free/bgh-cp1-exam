<?php

namespace App\Http\Controllers;

use App\Models\Admission;
use App\Services\DateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class AdmissionController extends Controller
{
    protected $dateService;
    public function __construct(DateService $dateService)
    {
        $this->dateService = $dateService;
    }

    public function getAdmissionsPerDay(Request $request): JsonResponse
    {
        $validatedData = $request->validate(['admissionDate' => 'required']);
        $admissionDate = $this->dateService->parseISO8601MysqlDate($validatedData['admissionDate']);

        $admissions = Admission::admissionsForDay($admissionDate);

        $formattedAdmissions = $admissions->map(function ($admission) {
            return [
                'id' => $admission->id,
                'patientLastName' => $admission->patient->last_name,
                'patientFirstName' => $admission->patient->first_name,
                'patientmiddleName' => $admission->patient->middle_name,
                'patientSuffixName' => $admission->patient->suffix_name,
                'ward' => $admission->ward,
                'admissionDatetime' => $admission->admission_datetime,
                'dischargeDatetime' => $admission->discharge_datetime,
            ];
        });


        return response()->json($formattedAdmissions);
    }

    public function addAdmission(Request $request): JsonResponse
    {
        $request->validate([
            'patientId' => 'required|exists:patients,id',
            'ward' => 'required|string',
            'admissionDatetime' => 'required|date',
        ]);


        $mappedData = [
            'patient_id' => $request->patientId,
            'ward' => $request->ward,
            'admission_datetime' => $this->dateService->parseISO8601MysqlDatetime(
                $request->admissionDatetime
            )
        ];

        $admission = Admission::create($mappedData);

        return response()->json(['message' => 'Admission created successfully', 'data' => $admission], 201);
    }
}

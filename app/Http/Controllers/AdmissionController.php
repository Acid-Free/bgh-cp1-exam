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

    public function dischargeAdmission(Request $request): JsonResponse
    {

        $request->validate([
            'id' => 'required|exists:admissions,id',
            'dischargeDatetime' => [
                'required',
                'date',
                function ($attribute, $value, $fail) use ($request) {
                    $admission = Admission::findOrFail($request->id);
                    $admissionDatetime = $admission->admission_datetime;

                    if (strtotime($value) < strtotime($admissionDatetime)) {
                        $fail('The discharge date cannot be earlier than the admission date.');
                    }
                },
            ],
        ]);


        $mappedData = [
            'id' => $request->id,
            'discharge_datetime' => $this->dateService->parseISO8601MysqlDatetime(
                $request->dischargeDatetime
            ),
        ];

        $admission = Admission::findOrFail($mappedData['id']);

        $admission->update($mappedData);

        return response()->json(['message' => 'Admission discharged successfully', 'data' => $admission]);
    }
}
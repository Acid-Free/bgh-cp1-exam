<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use App\Services\DateService;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class PatientController extends Controller
{
    protected $dateService;
    public function __construct(DateService $dateService)
    {
        $this->dateService = $dateService;
    }

    public function getAll(): JsonResponse
    {
        $patients = Patient::orderBy('id', 'desc')->get();


        $formattedPatients = $patients->map(function ($patient) {
            return [
                'id' => $patient->id,
                'firstName' => $patient->first_name,
                'lastName' => $patient->last_name,
                'middleName' => $patient->middle_name,
                'suffixName' => $patient->suffix_name,
                'birthDate' => $patient->birth_date,
                'address' => $patient->address,
            ];
        });

        return response()->json($formattedPatients);
    }

    public function add(Request $request): JsonResponse
    {
        $validatedData =  $request->validate([
            'lastName' => 'required|string',
            'firstName' => 'required|string',
            'middleName' => 'nullable|string',
            'suffixName' => 'nullable|string',
            'birthDate' => 'required|date',
            'address' => 'required|string'
        ]);

        $mappedData = [
            'last_name' => $validatedData['lastName'],
            'first_name' => $validatedData['firstName'],
            'middle_name' => $validatedData['middleName'] ?? null,
            'suffix_name' => $validatedData['suffixName'] ?? null,
            'birth_date' => $this->dateService->parseISO8601MysqlDate($validatedData['birthDate']),
            'address' => $validatedData['address']
        ];

        $patient = Patient::create($mappedData);

        return response()->json(['message' => 'Patient updated successfully', 'data' => $patient], 201);
    }

    public function update(Request $request): JsonResponse
    {
        try {
            $validatedData = $request->validate([
                'id' => 'required',
                'lastName' => 'required|string',
                'firstName' => 'required|string',
                'middleName' => 'nullable|string',
                'suffixName' => 'nullable|string',
                'birthDate' => 'required|date',
                'address' => 'required|string'
            ]);

            $mappedData = [
                'last_name' => $validatedData['lastName'],
                'first_name' => $validatedData['firstName'],
                'middle_name' => $validatedData['middleName'] ?? null,
                'suffix_name' => $validatedData['suffixName'] ?? null,
                'birth_date' => $this->dateService->parseISO8601MysqlDate($validatedData['birthDate']),
                'address' => $validatedData['address']
            ];

            $patient = Patient::findOrFail($validatedData['id']);

            $patient->update($mappedData);

            return response()->json(['message' => 'Patient updated successfully', 'data' => $patient]);
        } catch (ModelNotFoundException $e) {
            return response()->json(['error' => 'Patient not found'], 404);
        } catch (\Exception $e) {
            Log::error('Error updating patient: ' . $e->getMessage());
            return response()->json(['error' => 'Failed to update patient'], 500);
        }
    }

    public function delete(Request $request): JsonResponse
    {
        $validatedData = $request->validate([
            'id' => 'required'
        ]);

        $patient = Patient::find($validatedData['id']);

        if (!$patient) {
            return response()->json(['message' => 'Patient not found'], 404);
        }

        // Delete the patient
        $patient->delete();

        return response()->json(['message' => 'Patient deleted successfully'], 204);
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Employee;
use App\Http\Requests\StoreEmployeeRequest;
use Illuminate\Http\Response;
use App\Http\Resources\EmployeeResource;


class EmployeeController extends Controller
{

    public function index(){
        return EmployeeResource::collection(Employee::all());
    }

    public function store(StoreEmployeeRequest $request)
    {
        $validated = $request->validated();
        
        // Conditional requirement for justification
        if ($validated['hourly_rate'] > 50 && empty($validated['justification'])) {
            return response()->json(['error' => 'Justification is required for hourly rates above 50'], Response::HTTP_BAD_REQUEST);
        }

        $employee = Employee::create($validated);

        return response()->json($employee, Response::HTTP_CREATED);
    }
}

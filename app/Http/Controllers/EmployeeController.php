<?php

namespace App\Http\Controllers;

use App\Repositories\EmployeeRepository;
use Illuminate\Http\JsonResponse;

class EmployeeController extends Controller
{
    public function __invoke(EmployeeRepository $employeeRepository): JsonResponse
    {
        return response()->json([
            'employees' => $employeeRepository->index(),
            'contractAddress' => config('clairicatures.contract_address'),
            'chain' => config('clairicatures.chain'),
        ]);
    }
}

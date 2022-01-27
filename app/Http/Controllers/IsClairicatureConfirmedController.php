<?php

namespace App\Http\Controllers;

use App\Crypto\IsTransactionConfirmed;
use App\Enum\Error;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\JsonResponse;

class IsClairicatureConfirmedController extends Controller
{
    public function __invoke(
        int $id,
        EmployeeRepository $employeeRepository,
        IsTransactionConfirmed $isTransactionConfirmed
    ): JsonResponse
    {
        $employee = $employeeRepository->employeeForId($id);

        if (is_null($employee)) {
            return $this->errorResponse(Error::EMPLOYEE_NOT_FOUND);
        }

        $mintTransactionHash = $employeeRepository->employeeMintTransactionHash($employee);

        return response()->json([
            'confirmed' => ! is_null($mintTransactionHash) && $isTransactionConfirmed($mintTransactionHash),
        ]);
    }
}

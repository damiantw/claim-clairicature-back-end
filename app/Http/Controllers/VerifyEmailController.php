<?php

namespace App\Http\Controllers;

use App\Enum\Error;
use App\Mail\VerificationEmail;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request, EmployeeRepository $employeeRepository)
    {
        $this->validate($request, ['email' => ['required', 'email']]);

        $employee = $employeeRepository->employeeForEmail($request->input('email'));

        if (is_null($employee)) {
            return $this->errorResponse(Error::EMPLOYEE_NOT_FOUND);
        }

        if ($employeeRepository->employeeHasClaimed($employee)) {
            return $this->errorResponse(Error::EMPLOYEE_HAS_ALREADY_CLAIMED);
        }

        $employeeRepository->setEmployeeEmailSent($employee);

        Mail::send(new VerificationEmail($employee));
    }
}

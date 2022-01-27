<?php

namespace App\Http\Controllers;

use App\Crypto\ValidateSignature;
use App\Crypto\ValidateWeb3Address;
use App\Enum\Error;
use App\Jobs\MintClairicatureNonFungibleToken;
use App\Repositories\EmployeeRepository;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class ClaimClairicatureNonFungibleTokenController extends Controller
{
    public function __invoke(
        Request $request,
        EmployeeRepository $employeeRepository,
        ValidateWeb3Address $validateWeb3Address,
        ValidateSignature $validateSignature
    ): JsonResponse {
        $this->validate($request, [
            'secret' => ['required', 'uuid'],
            'signature' => ['required', 'string'],
            'web3Address' => ['required', 'string'],
        ]);

        $secret = $request->input('secret');
        $signature = $request->input('signature');
        $web3Address = $request->input('web3Address');

        $employee = $employeeRepository->employeeForSecret($secret);

        if (is_null($employee)) {
            return $this->errorResponse(Error::EMPLOYEE_NOT_FOUND);
        }

        if ($employeeRepository->employeeHasClaimed($employee)) {
            return $this->errorResponse(Error::EMPLOYEE_HAS_ALREADY_CLAIMED);
        }

        if (! $validateWeb3Address($web3Address)) {
            return $this->errorResponse(Error::INVALID_WEB3_ADDRESS);
        }

        if (! $validateSignature($web3Address, $secret, $signature)) {
            return $this->errorResponse(Error::INVALID_SIGNATURE);
        }

        $employeeRepository->setEmployeeWeb3Address($employee, $web3Address);
        $employeeRepository->setEmployeeClaimed($employee);

        dispatch(new MintClairicatureNonFungibleToken($employee));

        return response()->json([
            'id' => $employee->getKey(),
            'openSeaUrl' => config('clairicatures.open_sea_base_url').
                config('clairicatures.chain').'/'.
                config('clairicatures.contract_address')."/{$employee->getKey()}",
        ]);
    }
}

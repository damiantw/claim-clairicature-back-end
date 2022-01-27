<?php

namespace App\Repositories;

use App\Models\Employee;

class EmployeeRepository
{
    public function index(): array
    {
        return Employee::all()->map(fn (Employee $employee) => [
            'id' => $employee->getKey(),
            'name' => $employee->name,
            'image' => url("clairicatures/{$employee->getKey()}.png"),
            'claimed' => $employee->claimed,
        ])->all();
    }

    public function employeeForId(int $id): ?Employee
    {
        return Employee::find($id);
    }

    public function employeeForEmail(string $email): ?Employee
    {
        return Employee::query()->where('email', strtolower($email))->first();
    }

    public function employeeForSecret(string $secret): ?Employee
    {
        return Employee::query()->where('secret', $secret)->first();
    }

    public function employeeHasClaimed(Employee $employee): bool
    {
        return $employee->claimed;
    }

    public function employeeMintTransactionHash(Employee $employee): ?string
    {
        return $employee->mint_transaction_hash;
    }

    public function setEmployeeWeb3Address(Employee $employee, string $web3Address): bool
    {
        return $employee->update(['web3_address' => $web3Address]);
    }

    public function setEmployeeMintTransactionHash(Employee $employee, string $mintTransactionHash): bool
    {
        return $employee->update(['mint_transaction_hash' => $mintTransactionHash]);
    }

    public function setEmployeeEmailSent(Employee $employee, bool $emailSent = true): bool
    {
        return $employee->update(['email_sent' => $emailSent]);
    }

    public function setEmployeeClaimed(Employee $employee, bool $claimed = true): bool
    {
        return $employee->update(['claimed' => $claimed]);
    }
}

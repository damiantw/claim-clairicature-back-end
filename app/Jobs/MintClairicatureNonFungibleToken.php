<?php

namespace App\Jobs;

use App\Crypto\ClairicaturesContract;
use App\Models\Employee;
use App\Repositories\EmployeeRepository;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class MintClairicatureNonFungibleToken implements ShouldQueue, ShouldBeUnique
{
    use InteractsWithQueue, Queueable, SerializesModels;

    public int $maxExceptions = 1;

    public function __construct(public Employee $employee)
    {
    }

    public function __invoke(ClairicaturesContract $contract, EmployeeRepository $employeeRepository)
    {
        $employeeRepository->setEmployeeMintTransactionHash($this->employee, $contract->mint($this->employee));
    }

    public function uniqueId(): int
    {
        return $this->employee->getKey();
    }
}

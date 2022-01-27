<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;
use Illuminate\Support\Arr;
use RuntimeException;

class EmployeeSeeder extends Seeder
{
    public function run()
    {
        if (! file_exists(__DIR__.'/../employees.json')) {
            throw new RuntimeException("EMPLOYEE_JSON_FILE_DOES_NOT_EXIST");
        }

        $employeesDefinitions = json_decode(file_get_contents(__DIR__.'/../employees.json'), true);

        foreach ($employeesDefinitions as $employeesDefinition) {
            Employee::create([
                'id' => Arr::get($employeesDefinition, 'id'),
                'name' => Arr::get($employeesDefinition, 'name'),
                'email' => Arr::get($employeesDefinition, 'email'),
                'secret' => Arr::get($employeesDefinition, 'secret'),
            ]);
        }
    }
}

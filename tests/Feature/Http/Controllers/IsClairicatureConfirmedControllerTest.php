<?php

namespace Tests\Feature\Http\Controllers;

use App\Crypto\IsTransactionConfirmed;
use App\Enum\Error;
use App\Models\Employee;
use Tests\TestCase;

class IsClairicatureConfirmedControllerTest extends TestCase
{
    public function testIsTransactionConfirmed()
    {
        $this->mock(IsTransactionConfirmed::class)
            ->shouldReceive('__invoke')
            ->with($txHash = '0x3bc1d2a3de80df815ffd430d2766267f08d48b1efeb1ad8c593b4843f90d6687')
            ->andReturn(false, true);
        $employee = Employee::factory()->create();
        $this->get(route('is-clairicature-confirmed' , ['id' => 999]))
            ->response
            ->assertStatus(400)
            ->assertJson(['message' => Error::EMPLOYEE_NOT_FOUND->name]);
        $this->get(route('is-clairicature-confirmed' , ['id' => $employee->id]))
            ->response
            ->assertJson(['confirmed' => false]);
        $employee->update(['mint_transaction_hash' => '0x3bc1d2a3de80df815ffd430d2766267f08d48b1efeb1ad8c593b4843f90d6687']);
        $this->get(route('is-clairicature-confirmed' , ['id' => $employee->id]))
            ->response
            ->assertJson(['confirmed' => false]);
        $this->get(route('is-clairicature-confirmed' , ['id' => $employee->id]))
            ->response
            ->assertJson(['confirmed' => true]);
    }
}

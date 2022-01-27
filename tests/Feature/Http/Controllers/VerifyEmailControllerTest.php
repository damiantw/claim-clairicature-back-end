<?php

namespace Tests\Feature\Http\Controllers;

use App\Enum\Error;
use App\Mail\VerificationEmail;
use App\Models\Employee;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class VerifyEmailControllerTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();
        Mail::fake();
    }

    public function testSendVerificationEmail()
    {
        $employee = Employee::factory()->create();
        $this->post(route('verify-email'), [
            'email' => $employee->email,
        ])->assertResponseOk();
        $this->seeInDatabase('employees', ['id' => $employee->id, 'email_sent' => true]);
        Mail::assertQueued(fn (VerificationEmail $email) => $email->employee->is($employee));
    }

    public function testEmployeeNotFoundForEmail()
    {
        $this->post(route('verify-email'), [
            'email' => 'not-found@getclair.com',
        ])->response->assertStatus(400)->assertJson(['message' => Error::EMPLOYEE_NOT_FOUND->name]);
        Mail::assertNothingQueued();
    }

    public function testEmployeeHasAlreadyClaimed()
    {
        $employee = Employee::factory()->create(['claimed' => true]);
        $this->post(route('verify-email'), [
            'email' => $employee->email,
        ])->response->assertStatus(400)->assertJson(['message' => Error::EMPLOYEE_HAS_ALREADY_CLAIMED->name]);
        Mail::assertNothingQueued();
    }
}

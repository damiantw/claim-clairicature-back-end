<?php

namespace Tests\Feature\Http\Controllers;

use App\Crypto\ValidateSignature;
use App\Crypto\ValidateWeb3Address;
use App\Enum\Error;
use App\Jobs\MintClairicatureNonFungibleToken;
use App\Models\Employee;
use Illuminate\Support\Facades\Queue;
use Mockery\MockInterface;
use Tests\TestCase;

class ClaimClairicatureNonFungibleTokenControllerTest extends TestCase
{
    protected Employee $employee;

    protected MockInterface $validateWeb3Address;

    protected MockInterface $validateSignature;

    protected function setUp(): void
    {
        parent::setUp();
        $this->employee = Employee::factory()->create();
        $this->validateWeb3Address = $this->mock(ValidateWeb3Address::class);
        $this->validateSignature = $this->mock(ValidateSignature::class);
        Queue::fake();
    }

    public function testClaimNonFungibleToken()
    {
        $this->validateWeb3Address
            ->shouldReceive('__invoke')
            ->with('0xaee876df1937d717e74126eb1eca909d0d193074')
            ->andReturnTrue();
        $this->validateSignature
            ->shouldReceive('__invoke')
            ->with('0xaee876df1937d717e74126eb1eca909d0d193074', $this->employee->secret, 'signature')
            ->andReturnTrue();
        $this->post(route('claim-clairicature-nft'), [
            'secret' => $this->employee->secret,
            'signature' => 'signature',
            'web3Address' => '0xaee876df1937d717e74126eb1eca909d0d193074'
        ])->response->assertStatus(200)->assertJson(['id' => $this->employee->id]);
        $this->seeInDatabase('employees', [
            'id' => $this->employee->id,
            'claimed' => true,
            'web3_address' => '0xaee876df1937d717e74126eb1eca909d0d193074',
        ]);
        Queue::assertPushed(fn (MintClairicatureNonFungibleToken $job) => $job->employee->is($this->employee));
    }

    public function testEmployeeNotFoundForSecret()
    {
        $this->post(route('claim-clairicature-nft'), [
            'secret' => 'c829bfec-6dfa-4cf9-ac32-ea13a5465cdf',
            'signature' => 'signature',
            'web3Address' => '0xaee876df1937d717e74126eb1eca909d0d193074'
        ])->response->assertStatus(400)->assertJson(['message' => Error::EMPLOYEE_NOT_FOUND->name]);
        $this->seeInDatabase('employees', [
            'id' => $this->employee->id,
            'claimed' => false,
            'web3_address' => null,
        ]);
        Queue::assertNothingPushed();
    }

    public function testEmployeeHasAlreadyClaimed()
    {
        $this->employee->update(['claimed' => true]);
        $this->post(route('claim-clairicature-nft'), [
            'secret' => $this->employee->secret,
            'signature' => 'signature',
            'web3Address' => '0xaee876df1937d717e74126eb1eca909d0d193074'
        ])->response->assertStatus(400)->assertJson(['message' => Error::EMPLOYEE_HAS_ALREADY_CLAIMED->name]);
        Queue::assertNothingPushed();
    }

    public function testInvalidWeb3Address()
    {
        $this->validateWeb3Address
            ->shouldReceive('__invoke')
            ->with('invalid')
            ->andReturnFalse();
        $this->post(route('claim-clairicature-nft'), [
            'secret' => $this->employee->secret,
            'signature' => 'signature',
            'web3Address' => 'invalid'
        ])->response->assertStatus(400)->assertJson(['message' => Error::INVALID_WEB3_ADDRESS->name]);
        $this->seeInDatabase('employees', [
            'id' => $this->employee->id,
            'claimed' => false,
            'web3_address' => null,
        ]);
        Queue::assertNothingPushed();
    }

    public function testInvalidSignature()
    {
        $this->validateWeb3Address
            ->shouldReceive('__invoke')
            ->with('0xaee876df1937d717e74126eb1eca909d0d193074')
            ->andReturnTrue();
        $this->validateSignature
            ->shouldReceive('__invoke')
            ->with('0xaee876df1937d717e74126eb1eca909d0d193074', $this->employee->secret, 'invalid')
            ->andReturnFalse();
        $this->post(route('claim-clairicature-nft'), [
            'secret' => $this->employee->secret,
            'signature' => 'invalid',
            'web3Address' => '0xaee876df1937d717e74126eb1eca909d0d193074'
        ])->response->assertStatus(400)->assertJson(['message' => Error::INVALID_SIGNATURE->name]);
        $this->seeInDatabase('employees', [
            'id' => $this->employee->id,
            'claimed' => false,
            'web3_address' => null,
        ]);
        Queue::assertNothingPushed();
    }
}

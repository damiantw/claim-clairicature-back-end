<?php

namespace Tests\Integration;

use App\Crypto\ClairicaturesContract;
use App\Mail\VerificationEmail;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Mail;
use Symfony\Component\Process\Process;
use Tests\TestCase;

class ClaimClairicatureNonFungibleTokenTest extends TestCase
{
    protected static Process $hardhatNode;

    protected ClairicaturesContract $contract;

    protected string $deploymentAddress;

    const DAMIAN_ID = 9;

    const DAMIAN_EMAIL = 'damian@getclair.com';

    const DAMIAN_SECRET = '5fb0f9a1-7257-47be-b92a-d2de8cf4a6d6';

    const WEB3_ADDRESS = '0x4B755289da7EE961dB11E89cFdEAD8ffC350e391';

    const SIGNATURE = '0x78ab76b0bcaf7797f60835b5cc72cab6dd79845825f38285fb5a4a3fd70aa8086e1b7f531d45fd9e38e2be6aceed958c9ad9877dc317c58152c5b296c84b09eb1c';

    public static function setUpBeforeClass(): void
    {
        static::startHardHatNode();
    }

    public static function tearDownAfterClass(): void
    {
        static::stopHardHatNode();
    }

    protected function setUp(): void
    {
        parent::setUp();
        $this->artisan('db:seed --class=EmployeeSeeder');
        $this->contract = $this->app->make(ClairicaturesContract::class);
        config([
            'clairicatures.contract_address' => $this->deploymentAddress = static::deployContract(),
            'clairicatures.json_rpc.url' => 'http://localhost:8545',
            'clairicatures.wallet.encrypted_json' => file_get_contents(__DIR__.'/fixture/hardhat-wallet.json'),
            'clairicatures.wallet.password' => 'password',
        ]);
        Mail::fake();
    }

    public function testClaimClairicatureNFT()
    {
        $this->post(route('verify-email'), [
            'email' => self::DAMIAN_EMAIL,
        ])->assertResponseOk();

        Mail::assertQueued(fn (VerificationEmail $email) => $email->employee->getKey() === self::DAMIAN_ID);

        $this->post(route('claim-clairicature-nft'), [
            'secret' => self::DAMIAN_SECRET,
            'signature' => self::SIGNATURE,
            'web3Address' => self::WEB3_ADDRESS,
        ])->response->assertJson(['id' => self::DAMIAN_ID]);

        $this->seeInDatabase('employees', [
            'id' => self::DAMIAN_ID,
            'email' => self::DAMIAN_EMAIL,
            'secret' => self::DAMIAN_SECRET,
            'web3_address' => self::WEB3_ADDRESS,
            'email_sent' => true,
            'claimed' => true,
        ]);

        $this->get(route('is-clairicature-confirmed', ['id' => self::DAMIAN_ID]))
            ->response
            ->assertJson(['confirmed' => true]);

        $this->assertEquals(1, $this->totalSupply());
        $this->assertEquals(1, $this->balanceOf(self::WEB3_ADDRESS));
        $this->assertEquals(self::WEB3_ADDRESS, $this->ownerOf(self::DAMIAN_ID));
        $this->assertEquals(self::DAMIAN_ID, $this->tokenByIndex(0));
        $this->assertEquals(self::DAMIAN_ID, $this->tokenOfOwnerByIndex(self::WEB3_ADDRESS, 0));
    }

    protected function totalSupply(): int
    {
        return $this->parseBigInt($this->contract->query('totalSupply'));
    }

    protected function balanceOf(string $address): int
    {
        return $this->parseBigInt($this->contract->query('balanceOf', $address));
    }

    protected function ownerOf(int $id)
    {
        return $this->contract->query('ownerOf', $id);
    }

    protected function tokenByIndex(int $index): int
    {
        return $this->parseBigInt($this->contract->query('tokenByIndex', $index));
    }

    protected function tokenOfOwnerByIndex(string $address, int $index): int
    {
        return $this->parseBigInt($this->contract->query('tokenOfOwnerByIndex', $address, $index));
    }

    protected function parseBigInt(array $result): int
    {
        return hexdec(Arr::get($result, 'hex'));
    }

    protected static function startHardHatNode()
    {
        self::$hardhatNode = new Process(['npx', 'hardhat', 'node'], self::contractRoot());
        self::$hardhatNode->start();
    }

    protected static function stopHardHatNode()
    {
        self::$hardhatNode->stop();
    }

    protected static function deployContract(): string
    {
        $deploy = new Process(['npx', 'hardhat', '--network', 'localhost', 'run', './scripts/deploy.js'], self::contractRoot());
        $deploy->mustRun();

        return Arr::get(json_decode($deploy->getOutput(), true), 'DEPLOYMENT_ADDRESS');
    }

    protected static function contractRoot(): string
    {
        return __DIR__ . '/../../blockchain';
    }
}

<?php

namespace App\Crypto;

use App\Models\Employee;
use Illuminate\Support\Arr;

class ClairicaturesContract
{
    use InteractsWithNodeScripts;

    public function query(string $functionName, ...$args): mixed
    {
        return $this->runNodeScript('query-clairicatures.js', [
            'CONTRACT_FUNCTION_NAME' => $functionName,
            'CONTRACT_FUNCTION_ARGS' => json_encode($args),
        ]);
    }

    public function mint(Employee $employee): string
    {
        return Arr::get($this->runNodeScript('mint-clairicatures.js', [
            'WALLET_PASSWORD' => config('clairicatures.wallet.password'),
            'WALLET_ENCRYPTED_JSON' => config('clairicatures.wallet.encrypted_json'),
            'NFT_OWNER_ADDRESS' => $employee->web3_address,
            'NFT_ID' => $employee->getKey(),
            'NFT_SECRET' => $employee->secret,
        ]), 'hash');
    }
}

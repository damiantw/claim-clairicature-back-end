<?php

namespace App\Crypto;

use Illuminate\Support\Arr;

class IsTransactionConfirmed
{
    use InteractsWithNodeScripts;

    public function __invoke(string $transactionHash): bool
    {
        return Arr::get($this->runNodeScript('get-tx.js', [
            'TRANSACTION_HASH' => $transactionHash,
        ]), 'confirmations') > 0;
    }
}

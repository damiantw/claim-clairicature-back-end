<?php

namespace App\Crypto;

class ValidateWeb3Address
{
    use InteractsWithNodeScripts;

    public function __invoke(string $web3Address): bool
    {
        return $this->runNodeScript('validate-address.js', ['ADDRESS' => $web3Address]);
    }
}

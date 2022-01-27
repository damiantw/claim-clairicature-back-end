<?php

namespace App\Crypto;

class ValidateSignature
{
    use InteractsWithNodeScripts;

    public function __invoke(string $web3Address, string $message, string $signature): bool
    {
        $signer = $this->runNodeScript('validate-signature.js', [
            'MESSAGE' => $message,
            'SIGNATURE' => $signature,
        ]);

        return $signer === $web3Address;
    }
}

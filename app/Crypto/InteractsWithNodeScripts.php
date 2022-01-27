<?php

namespace App\Crypto;

use Illuminate\Support\Arr;
use Symfony\Component\Process\Process;

trait InteractsWithNodeScripts
{
    protected function runNodeScript(string $script, array $env = []): mixed
    {
        $process = new Process(['node', base_path("node/scripts/{$script}")], base_path('node'), $this->env($env));
        $process->mustRun();

        return Arr::get(json_decode($process->getOutput(), true), 'result');
    }

    private function env(array $env): array
    {
        return array_merge([
            'CLAIRICATURES_NFT_CONTRACT_ADDRESS' => config('clairicatures.contract_address'),
            'JSON_RPC_URL' => config('clairicatures.json_rpc.url'),
        ], $env);
    }
}

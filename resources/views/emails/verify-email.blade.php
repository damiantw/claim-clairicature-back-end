@component('mail::message')
# Claim your Clairicature NFT!

Click the button below to claim the Clairicature NFT for {{ $employee->name }}.

![{{ $employee->name }}]({{ url("clairicatures/{$employee->id}.png") }})

You'll need a Web3 wallet.

The [MetaMask](https://metamask.io/) browser extension is recommended.

@component('mail::button', ['url' => config('clairicatures.front_end_url')."/Claim?secret={$employee->secret}"])
    Claim NFT
@endcomponent

Cheers 🍻
@endcomponent

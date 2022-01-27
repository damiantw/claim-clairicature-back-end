<?php

namespace App\Mail;

use App\Models\Employee;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class VerificationEmail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    public function __construct(public Employee $employee)
    {
    }

    public function build(): static
    {
        return $this->to($this->employee->email, $this->employee->name)
            ->subject('Claim Clairicature NFT')
            ->markdown('emails.verify-email');
    }
}

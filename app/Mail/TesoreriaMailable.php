<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class TesoreriaMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Pago Masivo';

    protected $masivo;
    public function __construct($masivo)
    {
        $this->masivo = $masivo;
    }

    public function build()
    {
        $data = [
            'masivo' => $this->masivo,
        ];
        return $this->view('emails.tesoreria',$data);
    }
}

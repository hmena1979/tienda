<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class PedidoMailable extends Mailable
{
    use Queueable, SerializesModels;

    public $subject = 'Pago Masivo';

    protected $pedido;
    public function __construct($pedido)
    {
        $this->pedido = $pedido;
    }

    public function build()
    {
        $data = [
            'pedido' => $this->pedido,
        ];
        return $this->view('emails.pedido',$data);
    }
}

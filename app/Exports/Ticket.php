<?php

namespace App\Exports;

use App\Services\Export\Exportable;

class Ticket extends Exportable
{

    protected $data;

    public function __construct($data)
    {
        $this->data = $data;
    }

    protected function view()
    {
        return view('mails.send_ticket', [
            'ticket' => $this->data,
        ]);

    }
}

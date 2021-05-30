<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class PropostasExport implements FromView
{
    public $propostas;

    public function __construct($propostas)
    {
        $this->propostas = $propostas;
    }

    public function view(): View
    {
        return view('excel-propostas')
            ->with('propostas', $this->propostas);
    }
}
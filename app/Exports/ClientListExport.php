<?php
namespace App\Exports;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\FromView;

class ClientListExport implements FromView
{
  public $data;
  public function __construct($data)
  {
    $this->data = $data;
  }
  public function view(): View
  {
    return view('clients.exports.clients_export',['clients'=>$this->data]);
  }
}

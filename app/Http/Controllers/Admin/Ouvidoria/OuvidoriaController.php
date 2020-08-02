<?php

namespace App\Http\Controllers\Admin\Ouvidoria;

use App\Http\Controllers\Controller;
use App\Models\Setor;
use App\Models\Ouvidoria;
use App\Models\HistoricoOuvidoria;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use App\Models\Helpers;
use Exception;


date_default_timezone_set('America/Sao_Paulo');

class OuvidoriaController extends Controller
{
    private $ouvidoria;
    private $historico;

    public function __construct(Ouvidoria $ouvidoria, HistoricoOuvidoria $historico)
    {
        $this->ouvidoria = $ouvidoria;
        $this->historico = $historico;
    }

    public function index()
    {
        $ouvidorias = $this->ouvidoria->listAllOccurrences();
        $listCountOuvidoria = $this->ouvidoria->getCountOuvidoria();
        $setores = Setor::all();


        return view('admin.ouvidoria.home', compact('ouvidorias', 'listCountOuvidoria', 'setores'));
    }
}

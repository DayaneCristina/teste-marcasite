<?php

namespace App\Http\Controllers;

use App\Models\Servico;
use Illuminate\Http\Request;

class ServicoController extends Controller
{
    public function listar()
    {
        $servico = new Servico();
        $servicos = $servico->get();
        
        return view('listar-servicos')->with('servicos', $servicos);
    }

    public function criar(Request $request)
    {
        $nome = $request->get('nome');

        $servico = new Servico();

        if ($request->get('servico_id')) {
            $servico = $servico->find($request->get('servico_id'));
        }

        $servico->nome = $nome;
        $servico->descricao = '';
        $servico->save();

        return redirect('/listar-servicos');
    }

    public function viewEditar($id)
    {
        $serivcoModel = new Servico();
        $servico = $serivcoModel->find($id);

        return view('criar-servico')->with('servico', $servico);
    }
}

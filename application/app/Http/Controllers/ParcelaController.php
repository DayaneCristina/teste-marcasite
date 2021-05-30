<?php

namespace App\Http\Controllers;

use App\Models\Parcela;
use App\Models\Proposta;
use Illuminate\Http\Request;

class ParcelaController extends Controller
{
    public function listar($id)
    {
        $propostaModel = new Proposta();
        $proposta = $propostaModel->find($id);

        $arrProposta = [
            'id' => $proposta->id,
            'cliente' => $proposta->empresa->nome_fantasia,
            'servico' => $proposta->servico->nome,
            'feita_em' => $this->formataData($proposta->created_at, 'br'),
            'valor_total' => $proposta->valor_total
        ];

        $arrParcelas = [];
        foreach($proposta->parcela as $parcela) {
            $arrParcela = [
                'id' => $parcela->id,
                'numero' => $parcela->numero,
                'valor' => $parcela->valor,
                'taxa' => $parcela->taxa,
                'data_vencimento' => $this->formataData($parcela->data_vencimento, 'br'),
                'observacao' => $parcela->observacao
            ];
            array_push($arrParcelas, $arrParcela);
        }

        return view('listar-parcelas')
            ->with('proposta', $arrProposta)
            ->with('parcelas', $arrParcelas);
    }

    public function criar(Request $request)
    {
        $numero = $request->get('numero');
        $valor = $request->get('valor');
        $taxa = $request->get('taxa');
        $dataVencimento = $request->get('data_vencimento');
        $observacao = $request->get('observacao');
        $propostaId = $request->get('proposta_id');

        $parcela = new Parcela();
        $parcela->numero = $numero;
        $parcela->valor = $valor;
        $parcela->taxa = $taxa;
        $parcela->data_vencimento = $dataVencimento;
        $parcela->observacao = $observacao;
        $parcela->proposta_id = $propostaId;
        $parcela->save();
    }
    
    public function formataData($data, $padrao = '')
    {
        $data = str_replace('/', '-', $data);
        if ($padrao == 'br') {
            return date('d/m/Y', strtotime($data));
        }

        return date('Y-m-d', strtotime($data));
    }
}

<?php

namespace App\Http\Controllers;

use App\Models\Anexo;
use App\Models\Empresa;
use App\Models\Parcela;
use App\Models\Proposta;
use App\Models\Servico;
use Illuminate\Http\Request;
use App\Exports\PropostasExport;
use Maatwebsite\Excel\Facades\Excel;

class PropostaController extends Controller
{
    public function listar(Request $request)
    {
        $empresas = $this->empresas();

        if ($request->method() == 'GET') {
            $propostaModel = new Proposta();
            $propostas = $propostaModel->get();

            return view('listar-propostas')
                ->with('propostas', $this->formataPropostasParaView($propostas))
                ->with('empresas', $empresas);
        } else {

            $query = Proposta::query();

            $de = $request->get('de');
            $ate = $request->get('ate');
            $empresa_id = $request->get('empresa_id');
            $status = $request->get('status');

            if (!empty($de) && !empty($ate)) {
                $de = $this->formataData($de);
                $ate = $this->formataData($ate);

                $query->whereBetween('created_at', [$de, $ate]);
            }

            if ($empresa_id != '') {
                $query->where('empresa_id', '=', $empresa_id);
            }

            if ($status != '') {
                $query->where('status', '=', $status);
            }

            $propostas = $query->get();

            return view('listar-propostas')
                ->with('propostas', $this->formataPropostasParaView($propostas))
                ->with('empresas', $empresas);
        }
    }

    public function criar(Request $request)
    {
        $view = 'criar-proposta';
        $errors = $this->validarDados($request);
        if(!empty($errors)) {
            $empresas = $this->empresas();
            $servicos = $this->servicos();

            $propostaFormatada = [];
            if ($request->get('proposta_id')) {
                $proposta = $this->proposta($request->get('proposta_id'));
                $propostaFormatada = $this->formataPropostaParaView($proposta);
                $view = 'criar-proposta/' . $request->get('proposta_id');
            }
            
            return redirect($view)
                ->with('proposta', $propostaFormatada)
                ->with('empresas', $empresas)
                ->with('servicos', $servicos)
                ->with('errors', $errors);
        }

        $empresaId          = $request->get('empresa_id');
        $servicoId          = $request->get('servico_id');
        $endereco           = $request->get('endereco');
        
        $valorTotal         = str_replace('.', '', $request->get('valor_total'),);
        $valorTotal         = str_replace(',', '.', $valorTotal);

        $sinal              = str_replace('.', '', $request->get('sinal'));
        $sinal              = str_replace(',', '.', $sinal);

        $quantidadeParcelas = $request->get('quantidade_parcelas');
        $dataInicio         = $request->get('data_inicio_pagamento');
        $dataVencimento     = $request->get('dia_vencimento');
        $status             = $request->get('status');

        $proposta = new Proposta();

        if ($request->get('proposta_id')) {
            $proposta = $proposta->find($request->get('proposta_id'));
            $proposta->parcela()->delete();
        }

        $proposta->empresa_id            = $empresaId;
        $proposta->servico_id            = $servicoId;
        $proposta->endereco              = $endereco;
        $proposta->valor_total           = $valorTotal;
        $proposta->sinal                 = $sinal;
        $proposta->quantidade_parcelas   = $quantidadeParcelas;
        $proposta->dia_vencimento        = $dataVencimento;
        $proposta->status                = $status;
        $proposta->data_inicio_pagamento = $this->formataData($dataInicio);
        $proposta->save();

        if ($quantidadeParcelas > 0) {
            $valorParcelas = ($valorTotal -  $sinal) / $quantidadeParcelas;

            for($i=1; $i<=$quantidadeParcelas; $i++) {
                $parcela = new Parcela();
                $parcela->numero = $i;
                $parcela->valor = (float)number_format($valorParcelas,2,'.','');
                $parcela->taxa = 0;
                $parcela->data_vencimento = $this->geraDataVencimento($dataVencimento, $i);
                $parcela->observacao = '';
                $parcela->proposta_id = $proposta->id;

                $parcela->save();
            }
        }

        if($request->hasFile('anexo')) {
            $nomeOriginal = $request->file('anexo')->getClientOriginalName();
            $nomeDoArquivo = time() . $nomeOriginal;
            $caminhoDoArquivo = $request->file('anexo')->storeAs('uploads', $nomeDoArquivo, 'public');

            $anexo = new Anexo();
            $anexo->nome = $nomeOriginal;
            $anexo->arquivo = '/storage/' . $caminhoDoArquivo;
            $anexo->proposta_id = 5;
            $anexo->save();
        }

        return redirect('/listar-propostas');
    }

    public function deletar($id)
    {
        $proposta = $this->proposta($id);

        $proposta->parcela()->delete();
        $proposta->anexo()->delete();

        $proposta->delete();

        return redirect('/listar-propostas');
    }

    public function atualizarStatus(Request $request)
    {
        $id = $request->get('proposta_id');
        $status = $request->get('status');

        $proposta = Proposta::find($id);
        $proposta->status = $status;
        $proposta->save();
    }

    public function proposta($id)
    {
        $propostaModel = new Proposta();
        $proposta = $propostaModel->find($id);

        return $proposta;
    }

    public function empresas()
    {
        $empresaModel = new Empresa();
        $empresas = $empresaModel->get();

        return $empresas;
    }

    public function servicos()
    {
        $servicoModel = new Servico();
        $servicos = $servicoModel->get();

        return $servicos;
    }
    
    public function viewCriar()
    {
        $empresas = $this->empresas();
        $servicos = $this->servicos();
        
        return view('criar-proposta')
            ->with('empresas', $empresas)
            ->with('servicos', $servicos);
    }

    public function viewEditar($id)
    {
        $proposta = $this->proposta($id);
        $empresas = $this->empresas();
        $servicos = $this->servicos();

        return view('criar-proposta')
            ->with('proposta', $this->formataPropostaParaView($proposta))
            ->with('empresas', $empresas)
            ->with('servicos', $servicos);
    }

    public function geraDataVencimento($diaVencimento, $mes)
    {
        $data = date('Y-m-'.$diaVencimento);
        $data = date('Y-m-d', strtotime($data . ' +' . $mes . ' months'));

        return $data;
    }

    public function exportarPropostas()
    {
        $propostaModel = new Proposta();
        $propostas = $this->formataPropostasParaView($propostaModel->get());

        return Excel::download(new PropostasExport($propostas), 'propostas.xlsx');
    }

    public function formataPropostaParaView($proposta)
    {
        $propostaArr = [
            'id' => $proposta->id,
            'empresa_id' => $proposta->empresa->id,
            'servico_id' => $proposta->servico->id,
            'endereco' => $proposta->endereco,
            'valor_total' => $proposta->valor_total,
            'sinal' => $proposta->sinal,
            'quantidade_parcelas' => $proposta->quantidade_parcelas,
            'inicio_pagamento' => $this->formataData($proposta->data_inicio_pagamento, 'br'),
            'dia_vencimento' => $proposta->dia_vencimento,
            'sinal' => $proposta->sinal,
            'valor_total' => $proposta->valor_total,
            'status' => $proposta->status
        ];

        return $propostaArr;
    }

    public function formataPropostasParaView($propostas) 
    {
        $propostasArr = [];
        
        foreach($propostas as $proposta) {

            $arrParcelas = [];
            foreach($proposta->parcela as $parcela) {
                array_push($arrParcelas, [
                    'numero' => $parcela->numero,
                    'valor'  => $parcela->valor,
                    'vencimento' => $this->formataData($parcela->data_vencimento, 'br')
                ]);
            }

            $propostaArr = [
                'id' => $proposta->id,
                'cliente' => $proposta->empresa->nome_fantasia,
                'feita_em' => $this->formataData($proposta->created_at, 'br'),
                'inicio_pagamento' => $this->formataData($proposta->data_inicio_pagamento, 'br'),
                'servico' => $proposta->servico->nome,
                'quantidade_parcelas' => $proposta->quantidade_parcelas,
                'parcelas' => $arrParcelas,
                'sinal' => $proposta->sinal,
                'valor_total' => $proposta->valor_total,
                'status' => ($proposta->status == 1) ? 'Aberta' : 'Fechada'
            ];

            array_push($propostasArr, $propostaArr);
        }

        return $propostasArr;
    }

    public function formataData($data, $padrao = '')
    {
        $data = str_replace('/', '-', $data);
        if ($padrao == 'br') {
            return date('d/m/Y', strtotime($data));
        }

        return date('Y-m-d', strtotime($data));
    }

    public function validarDados($request)
    {
        $errors = [];
        if (empty($request->get('empresa_id'))) {
            array_push($errors,['campo' => 'Empresa']);
        }
        
        if (empty($request->get('servico_id'))) {
            array_push($errors,['campo' => 'Serviço']);
        }

        if (empty($request->get('endereco'))) {
            array_push($errors,['campo' => 'Endereço da Obra']);
        }

        if (empty($request->get('valor_total'))) {
            array_push($errors,['campo' => 'Valor Total']);
        }

        if (empty($request->get('data_inicio_pagamento'))) {
            array_push($errors,['campo' => 'Data de Inicio do Pgto.']);
        }

        if (empty($request->get('dia_vencimento'))) {
            array_push($errors,['campo' => 'Dia de venc. das parcelas']);
        }

        if ($request->get('status') == '') {
            array_push($errors,['campo' => 'Status']);
        }

        return $errors;
    }
}

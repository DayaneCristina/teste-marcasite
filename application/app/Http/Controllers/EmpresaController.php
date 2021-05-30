<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Empresa;
use App\Models\Endereco;
use App\Models\Responsavel;
use App\Models\Email;
use App\Models\Telefone;
use Illuminate\Http\RedirectResponse;

class EmpresaController extends Controller
{
    public function listar()
    {
        $empresa=new Empresa();
        $empresas=$empresa->get();

        return view('listar-empresas')->with('empresas', $empresas);
    }

    public function criar(Request $request)
    {
        $razaoSocial  = $request->get('razaosocial');
        $nomeFantasia = $request->get('nomefantasia');

        $cnpj         = $request->get('cnpj');
        $cnpj         = str_replace('.', '', $cnpj);
        $cnpj         = str_replace('/', '', $cnpj);
        $cnpj         = str_replace('-', '', $cnpj);

        $logradouro  = $request->get('logradouro');
        $numero      = $request->get('numero');
        $complemento = $request->get('complemento');
        $cep         = $request->get('cep');
        $bairro      = $request->get('bairro');
        $cidade      = $request->get('cidade');
        $estado      = $request->get('estado');

        $nome = $request->get('nome');

        $cpf  = $request->get('cpf');
        $cpf  = str_replace('.', '', $cpf);
        $cpf  = str_replace('-', '', $cpf);
        
        $ddd      = $request->get('ddd');
        $telefone = $request->get('telefone');

        $email = $request->get('email');

        $empresa = new Empresa();

        $view = 'criar-empresa';
        if ($request->get('empresa_id')) {
            $empresa = $empresa->find($request->get('empresa_id'));
            $view = 'criar-empresa/' . $request->get('empresa_id');
        }

        $errors = $this->validarDados($request);
        if(!empty($errors)) {
            return redirect($view)
                ->with('empresa', $empresa)
                ->with('errors', $errors);
        }

        $empresa->razao_social  = $razaoSocial;
        $empresa->nome_fantasia = $nomeFantasia;
        $empresa->cnpj          = $cnpj;

        $empresa->save();

        $endereco = new Endereco();
        
        if ($request->get('empresa_id')) {
            $endereco = $empresa->endereco->first();
        }

        $endereco->empresa_id = $empresa->id;
        $endereco->cep = $cep;
        $endereco->logradouro = $logradouro;
        $endereco->numero = $numero;
        $endereco->complemento = $complemento;
        $endereco->bairro = $bairro;
        $endereco->cidade = $cidade;
        $endereco->estado = $estado;
        $endereco->save();
        
        $responsavel = new Responsavel();
        
        if ($request->get('empresa_id')) {
            $responsavel = $empresa->responsaveis->first();
        }

        $responsavel->nome = $nome;
        $responsavel->cpf = $cpf;
        $responsavel->save();

        $emailModel = new Email();

        if ($request->get('empresa_id')) {
            $emailModel = $responsavel->email->first();
        }

        $emailModel->responsavel_id = $responsavel->id;
        $emailModel->email = $email;
        $emailModel->save();

        $telefoneModel = new Telefone();
        
        if ($request->get('empresa_id')) {
            $telefoneModel = $responsavel->telefone->first();
        } 

        $telefoneModel->responsavel_id = $responsavel->id;
        $telefoneModel->ddi = '+55';
        $telefoneModel->ddd = $ddd;
        $telefoneModel->numero = $telefone;
        $telefoneModel->save();
        
        $empresa->responsaveis()->sync([$responsavel->id]);

        return redirect('/listar-empresas');
    }

    public function viewEditar($id)
    {
        $empresaModel = new Empresa();
        $empresa = $empresaModel->find($id);

        return view('criar-empresa')
            ->with('empresa', $empresa)
            ->with('endereco', $empresa->endereco->first())
            ->with('responsavel', $empresa->responsaveis->first());
    }

    public function pegarResponsavel($cpf)
    {
        if (strlen($cpf) >= 11) {

            $reponsavelModel = new Responsavel();
            $responsavel = $reponsavelModel->where('cpf', '=', $cpf)->first();

            if (!$responsavel) {
                return json_encode(['erro' => true]);
            }

            return json_encode([
                'nome'     => $responsavel->nome,
                'email'    => $responsavel->email()->first()->email,
                'ddd'      => $responsavel->telefone()->first()->ddd,
                'telefone' => $responsavel->telefone()->first()->numero,
            ]);
        }

        return json_encode(['erro' => true]);
    }
    
    public function validarDados($request)
    {
        $errors = [];
        if (empty($request->get('razaosocial'))) {
            array_push($errors,['campo' => 'Razão Social']);
        }
        
        if (empty($request->get('nomefantasia'))) {
            array_push($errors,['campo' => 'Nome Fantasia']);
        }

        if (empty($request->get('cnpj'))) {
            array_push($errors,['campo' => 'CNPJ']);
        }

        if (empty($request->get('cep'))) {
            array_push($errors,['campo' => 'CEP']);
        }

        if (empty($request->get('logradouro'))) {
            array_push($errors,['campo' => 'logradouro']);
        }

        if ($request->get('numero') == '') {
            array_push($errors,['campo' => 'Nº']);
        }

        if (empty($request->get('bairro'))) {
            array_push($errors,['campo' => 'Bairro']);
        }        

        if (empty($request->get('cidade'))) {
            array_push($errors,['campo' => 'Cidade']);
        } 
        
        if (empty($request->get('estado'))) {
            array_push($errors,['campo' => 'Estado']);
        }        
        
        if (empty($request->get('nome'))) {
            array_push($errors,['campo' => 'Nome do Responsável']);
        }  
        
        if (empty($request->get('cpf'))) {
            array_push($errors,['campo' => 'CPF']);
        }              
                
        if (empty($request->get('ddd'))) {
            array_push($errors,['campo' => 'DDD']);
        }     
        
        if (empty($request->get('telefone'))) {
            array_push($errors,['campo' => 'Telefone']);
        }              
                 
        if (empty($request->get('email'))) {
            array_push($errors,['campo' => 'E-mail']);
        }              

        return $errors;
    }
}

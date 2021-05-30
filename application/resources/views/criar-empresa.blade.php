@extends('layout')

@section('conteudo')
<div class="container padding">
    <div class="starter-template">
        <div class='row'>
            @if(isset($errors))
                @foreach ($errors as $error)
                <div class="alert alert-danger" role="alert">
                    O campo <b>"{{ $error['campo'] }}"</b> não foi preenchido corretamente
                </div>
                @endforeach
            @endif
        </div>
                
        <form method='post' action='/criar-empresa'>
            <input type='hidden'name='_token' value='{{csrf_token()}}'>

            @if (isset($empresa))
                <input type='hidden' name='empresa_id' value='{{ $empresa->id }}' />
            @endif

            <div class='row'>
                <div class="col-md-12">
                    <p> &nbsp; </p>
                    <h4> Endereço </h4>
                </div>

                <div class="col-md-12">
                    <label class="form-label"> Razão Social </label>
                    <input type='text' name='razaosocial' class='form-control' value='{{ $empresa->razao_social ?? null }}' />
                </div>

                <div class='col-md-12'>
                    <label class='form-label'> Nome Fantasia </label>
                    <input type='text' name='nomefantasia' class='form-control' value='{{ $empresa->nome_fantasia ?? null }}'/>
                </div>

                <div class='col-md-12'>
                    <label class='form-label'> CNPJ </label>
                    <input type='text' name='cnpj' class='form-control cnpj' value='{{ $empresa->cnpj ?? null }}'/>
                </div>
            </div>

            <div class='row'>
                <div class="col-md-12">
                    <p> &nbsp; </p>
                    <h4> Endereço </h4>
                </div>
                
                <div class="col-md-4">
                    <label class='form-label'> CEP </label>
                    <input type='text' name='cep' id='cep' class='form-control' value='{{ $endereco->cep ?? null }}' />
                </div>

                <div class='col-md-12'>
                    <label class='form-label'> Logradouro </label>
                    <input type='text' name='logradouro' id='logradouro' class='form-control' value='{{ $endereco->logradouro ?? null }}' />
                </div>

                <div class='col-md-6'>
                    <label class='form-label'> Nº </label>
                    <input type='text' name='numero' class='form-control' value='{{ $endereco->numero ?? null }}' />
                </div>

                <div class='col-md-6'>
                    <label class='form-label'> Complemento </label>
                    <input type='text' name='complemento' class='form-control' value='{{ $endereco->complemento ?? null }}' />
                </div>

                <div class='col-md-12'>
                    <label class='form-label'> Bairro </label>
                    <input type='text' name='bairro' id='bairro' class='form-control' value='{{ $endereco->bairro ?? null }}' />
                </div>

                <div class='col-md-12'>
                    <label class='form-label'> Cidade </label>
                    <input type='text' name='cidade' id='cidade' class='form-control' value='{{ $endereco->cidade ?? null }}' />
                </div>

                <div class='col-md-12'>
                    <label class='form-label'> Estado </label>
                    <input type='text' name='estado' id='estado' class='form-control' value='{{ $endereco->estado ?? null }}' />
                </div>
            </div>

            <div class='row'>
                <div class="col-md-12">
                    <p> &nbsp; </p>
                    <h4> Endereço </h4>
                </div>

                <div class='col-md-4'>
                    <label class='form-label'> CPF </label>
                    <input type='text' name='cpf' id='cpf' class='form-control cpf' value='{{ $responsavel->cpf ?? null }}' />
                </div>

                <div class='col-md-12'>
                    <label class='form-label'> Nome </label>
                    <input type='text' name='nome' id='nome' class='form-control' value='{{ $responsavel->nome ?? null }}' />
                </div>


                <div claass='col-md-12'>
                    <label class='form-label'> E-mail </label>
                    <input type='text' name='email' id='email' class='form-control' value='{{ isset($responsavel) ? $responsavel->email->first()->email : null }}' />
                </div>

                <div class='col-md-12'>
                    <label class='form-label'> Telefone </label>
                    <div class='row'>                        
                        <div class='col-md-2'>
                            <input type='text' name='ddd' id='ddd' size='2' maxlength='2' class='form-control' value='{{ isset($responsavel) ? $responsavel->telefone->first()->ddd : null }}' />
                        </div>

                        <div class='col-md-10'>
                            <input type='text' name='telefone' id='telefone' class='form-control' value='{{ isset($responsavel) ? $responsavel->telefone->first()->numero : null }}' />
                        </div>
                    </div>
                </div>
            </div>

            <div class='row'>
                <div class='col-md-12'>
                    <p> &nbsp; </p>
                    <input type='submit' class='btn btn-primary' value='Salvar'/>
                    
                    <a href='/listar-empresas' class='btn btn-secondary'> Voltar </a>
                </div>
            </div>
        </form>

    </div>
</div>

<script>

    $(document).ready(function(){
        $('#cep').focusout(function() {
            var cep = $(this).val();

            $.getJSON("https://viacep.com.br/ws/"+ cep +"/json/?callback=?", function(dados) {
                if (!("erro" in dados)) {
                    //Atualiza os campos com os valores da consulta.
                    $("#logradouro").val(dados.logradouro);
                    $("#bairro").val(dados.bairro);
                    $("#cidade").val(dados.localidade);
                    $("#estado").val(dados.uf);
                }
            });
        })

        $('#cpf').focusout(function() {
            var cpf = $(this).val();
                cpf = cpf.replace('.', '');
                cpf = cpf.replace('.', '');
                cpf = cpf.replace('-', '');

            $.getJSON('/pegar-responsavel/' + cpf, function(dados) {
                console.log(dados);
                if (!("erro" in dados)) {
                    $('#nome').val(dados.nome);
                    $('#ddd').val(dados.ddd);
                    $('#telefone').val(dados.telefone);
                    $('#email').val(dados.email);
                }
            })
        });
    })

</script>

@endsection
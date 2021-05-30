@extends('layout')

@section('conteudo')
<div class="container-fluid padding">
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

        <form method='post' 
            action='/criar-proposta{{ (isset($proposta['id'])) ? '/'.$proposta['id'] : '' }}' 
            enctype='multipart/form-data'
        >
            <div class='row'>
                <input type='hidden' name='_token' value='{{ csrf_token() }}' />

                @if (isset($proposta))
                <input type='hidden' name='proposta_id' value='{{ $proposta['id'] }}' />
                @endif
                
                <div class='col-md-6'>
                    <label class='form-label'> Empresa </label>
                    <select name='empresa_id' class='form-control'>
                        @foreach($empresas as $empresa)
                        
                        @if (isset($proposta))
                        <option value='{{ $empresa->id }}' {{ ($proposta['empresa_id'] == $empresa->id) ? 'selected' : '' }}> 
                            {{ $empresa->nome_fantasia }} 
                        </option> 
                        @else
                        <option value='{{ $empresa->id }}'> 
                            {{ $empresa->nome_fantasia }} 
                        </option> 
                        @endif

                        @endforeach
                    </select>
                </div>

                <div class='col-md-6'>
                    <label class='form-label'> Serviço </label>
                    <select name='servico_id' class='form-control'>
                        @foreach($servicos as $servico)
                        
                        @if (isset($proposta))
                        <option value='{{ $servico->id }}' {{ ($proposta['servico_id'] == $servico->id) ? 'selected' : '' }}> 
                            {{ $servico->nome }} 
                        </option> 
                        @else
                        <option value='{{ $servico->id }}'> 
                            {{ $servico->nome }} 
                        </option> 
                        @endif

                        @endforeach
                    </select>
                </div>

                <div class='col-md-12'>
                    <label class='form-label'> Endereço da Obra </label>
                    <input type='text' name='endereco' class='form-control' value='{{ $proposta['endereco'] ?? null }}' />
                </div>

                <div class='col-md-2'>
                    <label class='form-label'> Valor Total </label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">R$</span>
                        <input type="text" class="form-control money" id='valor-total' name='valor_total' value='{{ $proposta['valor_total'] ?? null }}' aria-describedby="basic-addon1">
                    </div>
                </div>

                <div class='col-md-2'>
                    <label class='form-label'> Sinal </label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">R$</span>
                        <input type="text" class="form-control money" id='sinal' name='sinal' value='{{ $proposta['sinal'] ?? null }}' aria-describedby="basic-addon1">
                    </div>
                </div>

                <div class='col-md-2'>
                    <label class='form-label'> Quantidade de Parcelas </label>
                    <input type='text' name='quantidade_parcelas' id='qtd-parc' class='form-control' value='{{ $proposta['quantidade_parcelas'] ?? null }}'' />
                </div>

                <div class='col-md-2'>
                    <label class="form-label">Valor da Parcela</label>
                    <div class="input-group mb-3">
                        <span class="input-group-text" id="basic-addon1">R$</span>
                        <input type="text" id='valor-parcela' class="form-control money" aria-describedby="basic-addon1" readonly>
                    </div>
                </div>

                <div class='col-md-2'>
                    <label class='form-label'> Data de Inicio do Pgto. </label>
                    <input type='text' name='data_inicio_pagamento' class='form-control date' value='{{ $proposta['inicio_pagamento'] ?? null }}' />
                </div>

                <div class="col-md-2">
                    <label class='form-label'> Dia de venc. das parcelas </label>
                    <input type='text' name='dia_vencimento' class='form-control' value='{{ $proposta['dia_vencimento'] ?? null }}' />
                </div>

                <div class='col-md-12'>
                    <label class='form-label'> Anexar arquivo </label>
                    <input type='file' class='form-control' name='anexo' /> 
                </div>

                <div class='col-md-12'>
                    <label class='form-label'> Status </label>
                    <select name='status' class='form-control'>
                        <option value="0" 
                        {{ (isset($proposta) && $proposta['status'] == 0) ? 'selected' : '' }}
                        > 
                            Fechado 
                        </option>
                        
                        <option value="1" 
                        {{ (isset($proposta) && $proposta['status'] == 1) ? 'selected' : '' }}
                        > 
                            Aberto 
                        </option>
                    </select>
                </div>
            </div>
            
            <div class="row">
                <p> &nbsp; </p>
                <div class="col-md-3">
                    <input type="submit" class='btn btn-success' value="Salvar"/>
                    <a href="/listar-propostas" class='btn btn-secondary'> Voltar </a>
                </div>
            </div>
        </form>
    </div>
</div><!-- /.container -->  

<script>
    function calculaParcela(sinal, valorTotal, qtdParcelas)
    {
        return (valorTotal - sinal) / qtdParcelas;
    }

    $(window).load(function() {
        $('#qtd-parc').focusout(function() {
            if ($('#qtd-parc').val() > 0) {
                var valorTotal = $('#valor-total').val();
                    valorTotal = valorTotal.replace('.', '');
                    valorTotal = valorTotal.replace(',', '.');

                var sinal = $('#sinal').val();
                    sinal = sinal.replace('.', '');
                    sinal = sinal.replace(',', '.');

                var qtdParc = $('#qtd-parc').val();
                var valorParc = calculaParcela(sinal, valorTotal, qtdParc);
                    valorParc = number_format(valorParc,2,',','.');
                $('#valor-parcela').val(valorParc)
            }
        })
    });
</script>

@endsection
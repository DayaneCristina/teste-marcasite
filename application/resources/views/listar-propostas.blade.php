@extends('layout')

@section('conteudo')

<div class="container-fluid padding">
    <div class="starter-template">
            
        <div class="row">
            <div class='col-md-12'>
                <a href='/criar-proposta' class='btn btn-primary'> Cadastrar Proposta </a>
            
                <a href='/exportar-propostas' class='btn btn-primary'> Exportar </a>
            </div>
        </div>
        
        <div class="row">
            <div class="col-md-12">
                <p> &nbsp; </p>
            </div>
        </div>

        <form method="post" action='/listar-propostas'>
            <input type='hidden' name='_token' id='token' value='{{csrf_token()}}'>
            <div class="row">
                <div class="col-md-2">
                    <label class='form-label'> De </label>
                    <input type="text" class='form-control date' id='de' name='de'>
                </div>

                <div class="col-md-2">
                    <label class='form-label'> Até </label>
                    <input type="text" class='form-control date' id='ate' name='ate'>
                </div>

                <div class='col-md-2'>
                    <label class="form-label"> Status </label>
                    <select name='status' class="form-control">
                        <option value=''></option>
                        <option value='0'> Fechada </option>
                        <option value='1'> Aberta </option>
                    </select>
                </div>
                
                <div class="col-md-4">
                    <label class="form-label"> Cliente </label>
                    <select name='empresa_id' class='form-control'>
                        <option value=''></option>
                        @foreach($empresas as $empresa)
                        <option value="{{ $empresa->id }}"> {{ $empresa->nome_fantasia }} </option>
                        @endforeach
                    </select>
                </div>

                <div class="col-md-2">
                    <input type="submit" class="btn btn-primary" value="Buscar" style="margin-top:32px"/>
                </div>
            </div>
        </form>

        <div class='row'>
            <div class='col-md-12'>
                <table class='table'>
                    <thead>
                        <th> Cliente </th>
                        <th> Feita em </th>
                        <th> Inicio do Pagamento </th>
                        <th> Serviço </th>
                        <th> Parcelas </th>
                        <th> Sinal </th>
                        <th> Total </th>
                        <th> Status </th>
                        <th></th>
                        <th></th>
                    </thead>

                    <tbody>
                        @foreach($propostas as $proposta)
                        <tr>
                            <td> {{ $proposta['cliente'] }} </td>
                            <td> {{ $proposta['feita_em'] }} </td>
                            <td> {{ $proposta['inicio_pagamento'] }} </td>
                            <td> {{ $proposta['servico'] }} </td>
                            <td> 
                                {{ $proposta['quantidade_parcelas'] }}

                                @if($proposta['quantidade_parcelas'] > 0)
                                <a href='/listar-parcelas/{{$proposta['id']}}'>
                                    (ver parcela)
                                </a>
                                @endif
                            </td>
                            <td> {{ $proposta['sinal'] }} </td>
                            <td> {{ $proposta['valor_total'] }} </td>
                            <td>
                                <select name='status' class='form-control' id='status' data-id="{{ $proposta['id'] }}">
                                    <option value='0' {{ ($proposta['status'] == 'Fechada') ? 'selected' : '' }} > Fechada </option>
                                    <option value='1' {{ ($proposta['status'] == 'Aberta') ? 'selected' : '' }} > Aberta </option>
                                </select> 
                            </td>
                            <td> <a href='/deletar-proposta/{{ $proposta['id'] }}'> Deletar </a> </td>
                            <td> <a href='/criar-proposta/{{ $proposta['id'] }}'> Editar </a> </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div><!-- /.container -->

<script>
    $(document).ready(function(){
        $('#status').on('change', function(){
            var valStatus = $(this).val();
            var valProposta = $(this).attr('data-id');

            $.post('/atualizar-status', {status: valStatus, proposta_id: valProposta, _token: $('#token').val()})
        })
    })
</script>

@endsection
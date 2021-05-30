@extends('layout')

@section('conteudo')
<div class="container padding">
    <div class="starter-template">
                    
        <div class='row'>
            <div class='col-md-12'>
                <h3> Parcelas pertencem a proposta: </h3>

                <table class='table'>
                    <thead>
                        <th>Cliente</th>
                        <th>Servico</th>
                        <th>Feita em</th>
                        <th>Valor Total</th>
                    </thead>

                    <tbody>
                        <tr>
                            <td> {{ $proposta['cliente'] }} </td>
                            <td> {{ $proposta['servico'] }} </td>
                            <td> {{ $proposta['feita_em'] }} </td>
                            <td> {{ $proposta['valor_total'] }} </td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>

        <div class='row'>
            <div class='col-md-12'>
                <table class='table'>
                    <thead>
                        <th> Nº da Parcela </th>
                        <th> Valor </th>
                        <th> Taxa </th>
                        <th> Vencimento </th>
                        <th> Observação </th>
                    </thead>

                    <tbody>
                        @foreach($parcelas as $parcela)
                        <tr>
                            <td>{{ $parcela['numero'] }}</td>
                            <td>{{ $parcela['valor'] }}</td>
                            <td>{{ $parcela['taxa'] }}</td>
                            <td>{{ $parcela['data_vencimento'] }}</td>
                            <td>{{ $parcela['observacao'] }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection
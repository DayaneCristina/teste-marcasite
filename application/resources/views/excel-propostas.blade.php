<table>
    <tbody>
        <tr>
            <td> <b>Cliente</b> </td>
            <td> <b>Feita em</b> </td>
            <td> <b>Inicio de Pagamento</b> </td>
            <td> <b>Serviço</b> </td>
            <td> <b>Quantidade de Parcelas</b> </td>
            <td> <b>Parcelas</b> </td>
            <td> <b>Sinal</b> </td>
            <td> <b>Total</b> </td>
            <td> <b>Status</b> </td>
        </tr>

        @foreach($propostas as $proposta)
        <tr>
            <td valign='top'> {{ $proposta['cliente'] }} </td>
            <td valign='top'> {{ $proposta['feita_em'] }} </td>
            <td valign='top'> {{ $proposta['inicio_pagamento'] }} </td>
            <td valign='top'> {{ $proposta['servico'] }} </td>
            <td valign='top'> {{ $proposta['quantidade_parcelas'] }} </td>
            <td valign='top'>
                @foreach($proposta['parcelas'] as $parcela)
                <p> <b>Nº: </b> {{ $parcela['numero'] }} </p>
                <p> <b>Valor: </b> {{ $parcela['valor'] }}</p>
                <p> <b>Vencimento: </b> {{ $parcela['vencimento'] }} </p>
                <p> &nbsp; </p>
                @endforeach
            </td>
            <td valign='top'> {{ $proposta['sinal'] }} </td>
            <td valign='top'> {{ $proposta['valor_total'] }} </td>
            <td valign='top'> {{ $proposta['status'] }} </td>
        </tr>
        @endforeach
    </tbody>
</table>
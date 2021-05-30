@extends('layout')

@section('conteudo')
<div class="container padding">
    <div class="starter-template">

        <div class=row>
            <div class='col-md-12'>
                <a href='/criar-servico' class='btn btn-primary'>
                    Cadastrar Serviço
                </a>
            </div>
        </div>

        <div class="row">
            <div class='col-md-12'>
                <table class='table'>
                    <thead>
                        <tr>
                            <th> Serviço </th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($servicos as $servico)
                        <tr>
                            <td> {{ $servico->nome }} </td>
                            <td> <a href='/criar-servico/{{ $servico->id }}'>Editar</a> </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection
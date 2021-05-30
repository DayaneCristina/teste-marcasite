@extends('layout')

@section('conteudo')

<div class="container padding">
    <div class="starter-template">
        <div class="row">
            <div class="col-md-12"> 
                <a href="/criar-empresa" class='btn btn-primary'> 
                    Cadastrar empresa 
                </a> 
            </div>
        </div>

        <div class="row">
            <div class="col-md-12">
                <table class='table'>
                    <thead>
                        <tr>
                            <th> CNPJ </th>
                            <th> Razão Social </th>
                            <th> Nome Fantasia </th>
                            <th> </th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($empresas as $empresa)
                        <tr>
                            <td> {{ $empresa->cnpj }} </td>
                            <td> {{ $empresa->razao_social }} </td>
                            <td> {{ $empresa->nome_fantasia }} </td>
                            <td> 
                                <a href='/criar-empresa/{{ $empresa->id }}'> Editar 
                            </a>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@endsection
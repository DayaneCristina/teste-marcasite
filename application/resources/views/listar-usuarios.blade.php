@extends('layout')

@section('conteudo')
<div class="container padding">
    <div class="starter-template">
            
        <div class="row">
            <div class="col-md-12"> 
                <a href='/criar-usuario' class='btn btn-primary'>
                    Cadastrar usuário
                </a> 
            </div>
        </div>

        <div class='row'>
            <div class='col-md-12'>
                <table class='table'>
                    <thead>
                        <tr>
                            <th> Nome </th>
                            <th> E-mail </th>
                            <th></th>
                        </tr>
                    </thead>

                    <tbody>
                        @foreach($users as $user)
                        <tr>
                            <td> {{$user->name}} </td>
                            <td> {{$user->email}} </td>
                            <td> <a href='/criar-usuario/{{ $user->id }}'> Editar </a> </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>
</div>

@endsection
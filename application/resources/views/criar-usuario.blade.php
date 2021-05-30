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

        <form method='post' action='/criar-usuario'>
            <div class="row">
                <input type='hidden'name='_token' value='{{csrf_token()}}'>
                
                @if (isset($user))
                    <input type="hidden" name='user_id' value="{{$user->id }}" />
                @endif

                <div class="col-md-6">
                    <label class='form-label'> Nome: </label>
                    <input type='text' name='nome' class='form-control' value='{{ $user->name ?? null }}'/>
                </div>

                <div class='col-md-6'>
                    <label class='form-label'> E-mail: </label>
                    <input type='text' name='email' class='form-control' value='{{ $user->email ?? null }}'>
                </div>

                <div class="col-md-6">
                    <label class='form-label'> Senha: </label>
                    <input type='password' id='senha' class='form-control' name='password' >
                </div>
                
                <div class="col-md-6">
                    <label class='form-label'> Confirmar Senha: </label>
                    <input type='password' id='conf-senha' class='form-control'>
                </div>
            </div>

            <div class="row">
                <p> &nbsp; </p>
                <div class='col-md-12'>
                    <input type='submit' class='btn btn-primary' value='Enviar'>
                    <a href='/listar-usuarios' class='btn btn-secondary'> Voltar </a>
                </div>
            </div>
        </form>

    </div>
</div>

<script>

    $('form').on('submit', function(){
        if ($('#senha').val() != $('#conf-senha').val()) {
            alert('Confirmação de senha de ser igual a senha');
            return false;
        }
    })

</script>

@endsection
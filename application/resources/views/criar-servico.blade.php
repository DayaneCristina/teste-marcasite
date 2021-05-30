@extends('layout')

@section('conteudo')
<div class="container padding">
    <div class="starter-template">

        <form method='post' action="/criar-servico">
            <div class="row">
                <input type='hidden' name='_token' value="{{csrf_token()}}"/>

                @if (isset($servico))
                    <input type='hidden' name='servico_id' value="{{ $servico->id }}" />
                @endif
                
                <div class='col-md-6'>
                    <label class='form-label'> Nome do Serviço </label>
                    <input type="text" name='nome' class='form-control' value='{{ $servico->nome ?? null }}' />
                </div>
            </div>

            <div class='row'>
                <p> &nbsp; </p>
                <div class="col-md-12">
                    <input type="submit" class='btn btn-primary' value="Enviar"/>
                    <a href='/listar-servicos' class='btn btn-secondary'> Voltar </a>
                </div>
            </div>
        </form>

    </div>
</div>
@endsection
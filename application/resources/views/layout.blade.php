<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="favicon.ico">

    <title>Starter Template for Bootstrap</title>

    <!-- Bootstrap core CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
    <link href="{{ asset('css/app.css') }}" rel="stylesheet">
    <link href="{{ asset('css/sidebars.css') }}" rel="stylesheet">
  </head>

  <body>
    
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.12.4/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/js/bootstrap.bundle.min.js" integrity="sha384-gtEjrD/SeCtmISkJkNUaaKMoLD0//ElJ19smozuHV6z3Iehds+3Ulb9Bn9Plx0x4" crossorigin="anonymous"></script>
    <script src='{{ asset('js/sidebars.js') }}'></script>
    <script src='{{ asset('js/jquery.mask.min.js') }}'></script>
    <script src='{{ asset('js/numberFormat.js') }}'></script>

    <script>
        $(document).ready(function(){
            $('.date').mask('00/00/0000');
            $('.money').mask("#.##0,00", {reverse: true});
            $('.cnpj').mask("00.000.000/0000-00");
            $('.cpf').mask("000.000.000-00");
        })
    </script>
        
    <nav class="navbar navbar-inverse navbar-fixed-top">
        <div class="container-fluid">
            <ul>
                <li> <a href='/listar-propostas'> Propostas </a> </li>
                <li> <a href='/listar-usuarios'> Usuários </a> </li>
                <li> <a href='/listar-empresas'> Empresas </a> </li>
                <li> <a href='/listar-servicos'> Serviços </a> </li>
            </ul>
        </div><!--/.nav-collapse -->
    </nav>

    @yield('conteudo')
    
    </body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $documento->DESCRIPCION_DOCUMENTO }} </title>
    <link rel="stylesheet" type="text/css" href=" {{ asset('css/bootstrap.min.css')  }}" />
    <style>
        table { border-collapse: collapse !important; border:1px solid #000 !important; }
        p { text-align: justify }        

  
    </style>
</head>
<body>
    <div class="container">
        {!! html_entity_decode($documento->CONTENIDO, ENT_QUOTES, 'UTF-8') !!} 
    </div>
        <script src="{{asset('js/jquery.min.js')}} " ></script>
        <script>
        $(function () {
            $("table").addClass(['table-bordered table']);
            $("img").addClass(['img-fluid']);
            $("img").parent().addClass(['text-center']);
        })();
        </script>
</body>
</html>



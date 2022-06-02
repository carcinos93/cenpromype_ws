<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title> {{ $documento->DESCRIPCION_DOCUMENTO }} </title>
  
</head>
<body class="m-0 m-0 w-100 mw-100">
    <div class="container">
        {!! html_entity_decode($documento->CONTENIDO, ENT_QUOTES, 'UTF-8') !!} 
    </div>
        <link rel="stylesheet" type="text/css" href=" {{ asset('css/bootstrap.min.css')  }}" />
        <script src="{{asset('js/jquery.min.js')}} " ></script>
        <!--<script>
              html_entity_decode(Http::get( asset('js/jquery.min.js') ), ENT_QUOTES, 'UTF-8') 
        </script>-->
        <script>
            $(function () {
                $("table").addClass(['table-bordered table']);
                $("img").addClass(['img-fluid']);
                $("img").parent().addClass(['text-center']);
                
                $("#sidebar").remove();
                $("#page-container").css({
                    "position": "relative",
                    "background-color": "inherit",
                    "background-image": "none"
                });
            });
        </script>
</body>
</html>



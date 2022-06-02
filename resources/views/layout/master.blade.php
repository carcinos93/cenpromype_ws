<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title> @yield('title') </title>
        
        <link rel="stylesheet" type="text/css" href=" {{ asset('css/app.css')  }}" />
        <link rel="stylesheet" type="text/css" href=" {{ asset('css/primeicons.css')  }}" />
        @yield('styles')
    </head>
    <body>
        <section class="h-100">
                @yield('content')
        </section>
    </body>
    @yield('initialScript')
    <script src="{{asset('js/jquery.min.js')}}" async></script>
    <script src="{{asset('js/app.js?v2.0.1')}}" async></script>

    @yield('scripts')

</html>

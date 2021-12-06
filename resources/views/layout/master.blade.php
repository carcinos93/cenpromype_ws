<!doctype html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport"
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title> @yield('title') </title>
        <link rel="stylesheet" type="text/css" href=" {{ asset('css/primeflex.min.css')  }}" />
        <link rel="stylesheet" type="text/css" href=" {{ asset('css/primeicons.css')  }}" />
        <link rel="stylesheet" type="text/css" href=" {{ asset('css/primevue.min.css')  }}" />
        <link rel="stylesheet" type="text/css" href=" {{ asset('css/theme.css')  }}" />
        <link rel="stylesheet" type="text/css" href=" {{ asset('css/bootstrap.min.css')  }}" />
        <link rel="stylesheet" type="text/css" href=" {{ asset('css/styles.css')  }}" />
        @yield('styles')
    </head>
    <body>
        <section class="h-100">
                <div id="app"></div>
                @yield('content')
        </section>
    </body>
    <script src="{{asset('js/app.js')}} " ></script>
    <script src="{{asset('js/jquery.min.js')}} " ></script>
    <script src="https://cdn.jsdelivr.net/npm/vue@2/dist/vue.js"></script>
    <script type="module" src="{{asset('js/bootstrap.js')}}"></script>
    <script type="module" src="{{asset('js/init.js')}}"></script>
    @yield('scripts')

</html>

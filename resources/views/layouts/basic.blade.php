<!doctype html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
        <meta name="base-url" content="{{ url('/') }}">

        <title>@yield('title') - Sam</title>
 
        <!-- Styles -->
        <link href="{{ URL::asset('css/app.css') }}" rel="stylesheet" type="text/css">
    </head>
    <body class="{{ $body_class or 'page' }}">
        <div id="app" class="app">

            @section('body')
            @show

        </div>
        <script src="{{ URL::asset('js/app.js') }}"></script>
    </body>
</html>
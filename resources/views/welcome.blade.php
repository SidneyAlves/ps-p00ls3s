<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <meta name="viewport" content="width=device-width, initial-scale=1">

        <title>Pulses - PS</title>
    </head>
    <body>
        <div id="app">
        {!! csrf_field() !!}
            <router-view></router-view>
        </div>
        <script src="{{ asset('js/app.js') }}">
        </script>
    </body>
</html>
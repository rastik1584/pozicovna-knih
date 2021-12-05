<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="{{ csrf_token() }}">


        <title>Požičovňa kníh</title>

        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">

        <!-- Styles -->
        <link href="{{ asset('css/app.css') }}" rel="stylesheet">
        <script src="{{ asset('js/app.js') }}" defer></script>
    </head>
    <body>
        <div id="app">
            <div class="col-3 left">
                <h1>Požičovňa kníh</h1>
                <left-menu></left-menu>
            </div>
            <div class="col-9 right pl-0">
                <router-view></router-view>
            </div>
        </div>
    </body>
</html>

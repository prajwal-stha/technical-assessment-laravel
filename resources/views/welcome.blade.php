<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{env('APP_NAME')}}</title>
    <meta name="csrf-token" content="{{ csrf_token() }}"/>
    <script src="https://use.fontawesome.com/dc1cb23417.js"></script>
    <link href="{{ mix('/css/app.css') }}" id="direction" rel="stylesheet">

</head>
<body>
<div id="root">
    <router-view></router-view>
</div>
<script src="{{ mix('/js/app.js') }}"></script>
<script src="{{ mix('/js/plugin.js') }}"></script>

</body>

</html>

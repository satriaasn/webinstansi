<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="{{ getSetting('web_description') }}">
    <meta name="author" content="{{ getSetting('web_owner') }}">

    <!-- CSRF Token -->
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ getSetting('web_name') }}</title>

    <link rel="shortcut icon" href="{{ berkas( getSetting('favicon')) }}">

    <!-- vendor css -->
    <link href="{{ callassetspath('backend/lib/font-awesome/css/font-awesome.css') }}" rel="stylesheet">
    <link href="{{ callassetspath('backend/lib/Ionicons/css/ionicons.css') }}" rel="stylesheet">

    <!-- Bracket CSS -->
    <link rel="stylesheet" href="{{ callassetspath('backend/css/bracket.css') }}">

    <script>
        window.Laravel = <?php echo json_encode([
            'csrfToken' => csrf_token(),
        ]); ?>
    </script>
</head>
<body>
@yield('content')

<!-- Scripts -->
<script src="{{ callassetspath('backend/lib/jquery/jquery.js') }}"></script>
<script src="{{ callassetspath('backend/lib/popper.js/popper.js') }}"></script>
<script src="{{ callassetspath('backend/lib/bootstrap/js/bootstrap.js') }}"></script>
</body>
</html>

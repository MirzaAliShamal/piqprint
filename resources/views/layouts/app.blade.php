<!DOCTYPE html>
<html lang="en">
<head>
    <meta name="baseURL" content="{{ url('/') }}">
    <meta name="csrfToken" content="{{ csrf_token() }}">
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>PiqPrint</title>

    <link rel="icon" href="{{ asset('images/piq-print-icon-32x32.png') }}" sizes="32x32" />
    <link rel="icon" href="{{ asset('images/piq-print-icon-192x192.png') }}" sizes="192x192" />
    <link rel="apple-touch-icon" href="{{ asset('images/piq-print-icon-180x180.png') }}" />
    <meta name="msapplication-TileImage" content="{{ asset('images/piq-print-icon-270x270.png') }}" />

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.6.0/css/all.min.css">

    <link rel="stylesheet" href="{{ asset('css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/cropper.min.css') }}">
    <link rel="stylesheet" href="{{ asset('css/style.css?v='.rand()) }}">
    <link rel="stylesheet" href="{{ asset('css/responsive.css?v='.rand()) }}">

    @yield('css')
</head>
<body>
    <div class="wrapper">
        <div class="container position-relative h-100">
            @yield('content')
        </div>
    </div>
    {{-- Loader --}}
    <div class="loading" style="display: none;">
        <span class="text-red bt5-16-semibold">Loading...</span>
        <div class="progress" role="progressbar" aria-label="Success example" aria-valuenow="25" aria-valuemin="0" aria-valuemax="100">
            <div class="progress-bar bg-red" style="width: 25%"></div>
        </div>
    </div>

    <script src="{{ asset('js/jquery.min.js') }}"></script>
    <script src="{{ asset('js/bootstrap.bundle.min.js') }}"></script>
    <script src="{{ asset('js/cropper.min.js') }}"></script>
    <script src="{{ asset('js/caman.min.js') }}"></script>
    <script src="https://js.pusher.com/7.0/pusher.min.js"></script>
    <script>
        const pusher = new Pusher('39c835d1689e46a79205', {
            cluster: 'ap2',
            encrypted: true
        });
    </script>

    @yield('js')
</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Image Gallery</title>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

    <link rel="stylesheet" href="{{ asset('css/upload-form.css') }}">

    <link rel="stylesheet" href="{{ asset('css/gallery.css') }}">
</head>
<body>
    <div class="container">
        @yield('content') 
    </div>

    <script src="{{ asset('js/upload-form.js') }}"></script>

    <script src="{{ asset('js/gallery.js') }}"></script>
</body>
</html>

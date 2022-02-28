<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>@yield('title') - zydhan.xyz</title>

       {{-- Laravel Mix - CSS File --}}
       <link rel="stylesheet" href="{{ mix('css/auth.css') }}">
       <script src="https://kit.fontawesome.com/ecbefee5af.js" crossorigin="anonymous"></script>
    </head>
    <body class="bg-gray-900 text-white scroll-smooth">
        @yield('content')

        {{-- Laravel Mix - JS File --}}
        <script src="{{ mix('js/auth.js') }}"></script>
    </body>
</html>

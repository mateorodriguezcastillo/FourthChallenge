<!DOCTYPE html>
<html lang=”en”>

<head>
    <meta charset=”UTF-8">
    <meta name=”viewport” content=”width=device-width, initial-scale=1.0">
    <meta http-equiv=”X-UA-Compatible” content=”ie=edge”>
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link href="https://unpkg.com/tailwindcss@^2/dist/tailwind.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://unpkg.com/flowbite@1.5.3/dist/flowbite.min.css" />
    <title>Post CRUD</title>
</head>

<body class="bg-gray-100">

    @yield('content')


    <script src="https://code.jquery.com/jquery-3.4.1.min.js"
        integrity="sha256-CSXorXvZcTkaix6Yvo6HppcZGetbYMGWSFlBw8HfCJo=" crossorigin="anonymous"></script>

    <script src="https://unpkg.com/flowbite@1.5.3/dist/flowbite.js"></script>

    {{-- add stack  --}}
    @stack('addon-script')

</body>
</html>

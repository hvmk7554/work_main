<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="{{ mix('/css/app.css') }}" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Nunito+Sans:wght@300;400;700&display=swap" rel="stylesheet">

    <title>{{ config('app.name') }}</title>

    <script src="{{ mix('/js/app.js') }}" defer></script>

    @inertiaHead
</head>
<body class="min-w-site text-sm font-medium min-h-full text-gray-500 dark:text-gray-400 bg-gray-100 dark:bg-gray-900">
@inertia
</body>
</html>

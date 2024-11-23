<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Akiwacu Social Network</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css">

    <link href="https://fonts.googleapis.com/css?family=pacifico" rel="stylesheet">
</head>
<body>
    @include('templates.partials.navigation')
    <div class="container">
        @include('templates.partials.alerts')
        @yield('content')
    </div>
</body>
</html>
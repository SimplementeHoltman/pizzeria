<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Mi Aplicación</title>
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>
<body>
    
    <div id="app">
        <main>
            @yield('content') <!-- Aquí se insertará el contenido de cada página -->
        </main>
    </div>

    
</body>
</html>

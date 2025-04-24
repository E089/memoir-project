
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>{{ $title ?? 'Memoir' }}</title>

    <!-- Fonts and CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Schoolbell&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Fragment+Mono&display=swap" rel="stylesheet">

    <!-- Page-specific styles -->
    @yield('styles')

    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
</head>

<body class="bg-light d-flex align-items-center justify-content-center" style="height: 100vh;">
    <div class="container">
        @yield('content')
    </div>
</body>
</html>


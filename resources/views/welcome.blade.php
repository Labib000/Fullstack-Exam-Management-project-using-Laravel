<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Welcome | Techno Batanagar</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    
    <!-- Custom Styles -->
    <style>
     body, html {
        margin: 0;
        padding: 0;
        height: 100%;
        background: url('{{ asset('images/layered-waves-haikei.svg') }}') no-repeat center bottom;
        background-size: cover;
        font-family: 'Segoe UI', sans-serif;
        overflow: hidden;
    }

    .welcome-content {
        z-index: 10;
        position: relative;
    }

    .logo {
        width: 180px;
        margin-bottom: 20px;
        border-radius: 20px;
    }

    .btn-custom {
        min-width: 200px;
        border-radius: 50px;
        font-size: 1.2rem;
    }
    </style>
</head>
<body>
   

    <!-- Main Content -->
   <div class="container d-flex align-items-center justify-content-center min-vh-100 welcome-content">
    <div class="text-center text-white">
        <img src="{{ asset('images/technobatanagar-logo.jpg') }}" alt="Techno Batanagar Logo" class="logo">

        <h1 class="mb-4 fw-bold">Welcome to Techno Batanagar</h1>

        <div class="d-grid gap-3 col-6 mx-auto">
            <a href="{{ url('/admin/login') }}" class="btn btn-light btn-lg btn-custom shadow">Admin</a>
            <a href="{{ url('/student/login') }}" class="btn btn-outline-light btn-lg btn-custom shadow">Student</a>
            <a href="{{ url('/moderator/login') }}" class="btn btn-warning btn-lg btn-custom shadow">Moderator</a>
        </div>
    </div>
</div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

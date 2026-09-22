<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login | Pillai Ceramics</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Plus Jakarta Sans', sans-serif;
            background-color: #0f172a;
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        .login-card {
            width: 100%;
            max-width: 420px;
            border-radius: 1rem;
            border: none;
            box-shadow: 0 20px 25px -5px rgba(0,0,0,0.3);
        }
    </style>
</head>
<body>

<div class="card login-card p-4 p-md-5 bg-white">
    <div class="text-center mb-4">
        <p><img src="{{ asset('images/logo.png') }}" 
                     alt="Pillai Ceramics Logo" 
                     class="h-10 sm:h-12 w-auto object-contain" 
                     style="max-height: 48px;" /></p>
        <p class="text-muted fs-7 mr-3">Sign in to access Admin Portal</p>
    </div>

    @if($errors->any())
        <div class="alert alert-danger fs-7 py-2">
            {{ $errors->first() }}
        </div>
    @endif

    <form action="{{ route('admin.login.submit') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label class="form-label fw-semibold fs-7">Email Address</label>
            <input type="email" name="email" class="form-required form-control" value="{{ old('email') }}" required autofocus placeholder="admin@pillaiceramics.in">
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold fs-7">Password</label>
            <input type="password" name="password" class="form-control" required placeholder="••••••••">
        </div>

        <div class="d-flex justify-content-between align-items-center mb-4 fs-7">
            <div class="form-check">
                <input type="checkbox" name="remember" class="form-check-input" id="remember">
                <label class="form-check-label" for="remember">Remember me</label>
            </div>
        </div>

        <button type="submit" class="btn btn-primary w-100 py-2 fw-semibold">Sign In</button>
    </form>
</div>

</body>
</html>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - SAO Event Management System</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.0/font/bootstrap-icons.css">
    <style>
        body {
            background: linear-gradient(135deg, #2c3e50 0%, #3498db 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 400px;
        }

        .login-card {
            background: white;
            border-radius: 12px;
            box-shadow: 0 10px 40px rgba(0, 0, 0, 0.2);
            padding: 40px;
        }

        .login-header {
            text-align: center;
            margin-bottom: 40px;
        }

        .login-header h1 {
            color: #2c3e50;
            font-size: 1.8rem;
            font-weight: bold;
            margin-bottom: 10px;
        }

        .login-header p {
            color: #7f8c8d;
            font-size: 0.95rem;
        }

        .form-group {
            margin-bottom: 20px;
        }

        .form-label {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 8px;
            display: block;
        }

        .form-control {
            padding: 12px 15px;
            border: 2px solid #e0e0e0;
            border-radius: 6px;
            transition: all 0.3s ease;
            font-size: 0.95rem;
        }

        .form-control:focus {
            border-color: #3498db;
            box-shadow: 0 0 0 0.2rem rgba(52, 152, 219, 0.25);
        }

        .btn-login {
            background: linear-gradient(135deg, #2c3e50, #3498db);
            border: none;
            color: white;
            padding: 12px;
            font-size: 1rem;
            font-weight: 600;
            border-radius: 6px;
            cursor: pointer;
            width: 100%;
            transition: all 0.3s ease;
            margin-top: 10px;
        }

        .btn-login:hover {
            background: #3498db;
            transform: translateY(-2px);
            box-shadow: 0 5px 20px rgba(52, 152, 219, 0.3);
            color: white;
        }

        .alert {
            border-radius: 6px;
            border: none;
            margin-bottom: 20px;
        }

        .demo-credentials {
            background: #f0f8ff;
            border-left: 4px solid #3498db;
            padding: 15px;
            border-radius: 6px;
            margin-top: 30px;
            font-size: 0.9rem;
        }

        .demo-credentials h6 {
            color: #2c3e50;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .demo-credentials p {
            color: #666;
            margin: 5px 0;
            word-break: break-all;
        }

        .demo-credentials code {
            background: white;
            padding: 2px 6px;
            border-radius: 3px;
            color: #e74c3c;
            font-weight: 600;
        }
    </style>
</head>

<body>
    <div class="login-container">
        <div class="login-card">
            <!-- Header -->
            <div class="login-header">
                <h1><i class="bi bi-calendar-event"></i></h1>
                <h1>SAO Events</h1>
                <p>School Organization Event Management</p>
            </div>

            <!-- Error Messages -->
            @if ($errors->any())
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="bi bi-exclamation-triangle"></i>
                    <strong>Login Failed:</strong>
                    <ul class="mb-0 mt-2">
                        @foreach ($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            @endif

            <!-- Login Form -->
            <form action="{{ route('login.store') }}" method="POST">
                @csrf

                <div class="form-group">
                    <label class="form-label" for="username">Username or Email</label>
                    <input type="text" class="form-control @error('username') is-invalid @enderror" id="username"
                        name="username" value="{{ old('username') }}" placeholder="Enter your username or email"
                        required autofocus>
                    @error('username')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <div class="form-group">
                    <label class="form-label" for="password">Password</label>
                    <input type="password" class="form-control @error('password') is-invalid @enderror" id="password"
                        name="password" placeholder="Enter your password" required>
                    @error('password')
                        <div class="invalid-feedback d-block">{{ $message }}</div>
                    @enderror
                </div>

                <button type="submit" class="btn-login">
                    <i class="bi bi-box-arrow-in-right"></i> Login
                </button>
            </form>

            <!-- Demo Credentials -->
            <div class="demo-credentials">
                <h6><i class="bi bi-info-circle"></i> Demo Credentials</h6>
                <p><strong>Username:</strong> <code>admin</code></p>
                <p><strong>Password:</strong> <code>password123</code></p>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>

</html>
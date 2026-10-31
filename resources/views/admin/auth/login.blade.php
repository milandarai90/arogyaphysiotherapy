
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="theme-color" content="#173f78">

    <title>Admin Login | Arogya Physiotherapy Center</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css" rel="stylesheet">

    <style>
        :root {
            --admin-primary: #173f78;
            --admin-primary-dark: #12325f;
            --admin-background: #f4f6fb;
        }

        * {
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            margin: 0;
            padding: 24px;
            display: flex;
            align-items: center;
            justify-content: center;
            background: var(--admin-background);
            font-family: Arial, sans-serif;
        }

        .login-wrapper {
            width: 100%;
            max-width: 430px;
        }

        .login-card {
            background: #fff;
            border: 0;
            border-radius: 16px;
            padding: 38px;
            box-shadow: 0 8px 35px rgba(23, 63, 120, .09);
        }

        .brand-logo {
            width: 68px;
            height: 68px;
            margin: 0 auto 16px;
            border-radius: 50%;
            background: #edf3fc;
            color: var(--admin-primary);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 28px;
        }

        .brand-name {
            color: var(--admin-primary);
            font-size: 27px;
            font-weight: 800;
            letter-spacing: 1px;
            margin-bottom: 4px;
        }

        .login-subtitle {
            color: #667085;
            font-size: 14px;
        }

        .form-label {
            font-size: 14px;
            font-weight: 600;
            color: #344054;
        }

        .form-control {
            min-height: 46px;
            border-radius: 8px;
            border-color: #d0d5dd;
        }

        .form-control:focus {
            border-color: var(--admin-primary);
            box-shadow: 0 0 0 .2rem rgba(23, 63, 120, .12);
        }

        .btn-login {
            min-height: 46px;
            background: var(--admin-primary);
            color: #fff;
            border: 0;
            border-radius: 8px;
            font-weight: 600;
            transition: .2s;
        }

        .btn-login:hover {
            background: var(--admin-primary-dark);
            color: #fff;
        }

        .website-link {
            color: var(--admin-primary);
            font-size: 13px;
            font-weight: 600;
        }

        .website-link:hover {
            color: var(--admin-primary-dark);
        }

        .login-footer {
            color: #98a2b3;
            font-size: 12px;
            text-align: center;
            margin-top: 22px;
        }

        @media (max-width: 480px) {
            .login-card {
                padding: 28px 22px;
            }
        }
    </style>
</head>

<body>

<div class="login-wrapper">

    <div class="login-card">

        <div class="text-center mb-4">

            <div class="brand-logo">
                <i class="fa-solid fa-heart-pulse"></i>
            </div>

            <h1 class="brand-name">AROGYA</h1>

            <h5 class="fw-bold mb-1">Admin Login</h5>

            <p class="login-subtitle mb-0">
                Physiotherapy Center Management
            </p>

        </div>

        @if(session('success'))
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <i class="fa-solid fa-circle-check me-2"></i>
                {{ session('success') }}

                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        @endif

        @if($errors->any())
            <div class="alert alert-danger" role="alert">
                <i class="fa-solid fa-circle-exclamation me-2"></i>

                @foreach($errors->all() as $error)
                    <div>{{ $error }}</div>
                @endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('admin.login.submit') }}">
            @csrf

            <div class="mb-3">
                <label for="email" class="form-label">Email Address</label>

                <input
                    type="email"
                    name="email"
                    id="email"
                    class="form-control @error('email') is-invalid @enderror"
                    value="{{ old('email') }}"
                    placeholder="Enter admin email"
                    autocomplete="username"
                    required
                    autofocus
                >

                @error('email')
                    <div class="invalid-feedback">{{ $message }}</div>
                @enderror
            </div>

            <div class="mb-3">
                <label for="password" class="form-label">Password</label>

                <input
                    type="password"
                    name="password"
                    id="password"
                    class="form-control"
                    placeholder="Enter your password"
                    autocomplete="current-password"
                    required
                >
            </div>

            <div class="form-check mb-4">
                <input
                    type="checkbox"
                    name="remember"
                    value="1"
                    class="form-check-input"
                    id="remember"
                >

                <label class="form-check-label small" for="remember">
                    Remember me
                </label>
            </div>

            <button type="submit" class="btn btn-login w-100">
                <i class="fa-solid fa-right-to-bracket me-2"></i>
                Login to Dashboard
            </button>

        </form>

        <div class="text-center mt-4">
            <a href="{{ route('home') }}" class="website-link text-decoration-none">
                <i class="fa-solid fa-arrow-left me-1"></i>
                Back to Website
            </a>
        </div>

    </div>

    <div class="login-footer">
        &copy; {{ date('Y') }} Arogya Physiotherapy Center. All rights reserved.
    </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>

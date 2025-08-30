<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.1/font/bootstrap-icons.css" rel="stylesheet">
    <style>
        body {
            background: #f8f9fa;
        }

        .card-hover {
            transition: transform 0.3s ease, box-shadow 0.3s ease;
            cursor: pointer;
        }

        .card-hover:hover {
            transform: translateY(-10px) scale(1.05);
            box-shadow: 0 12px 25px rgba(0, 0, 0, 0.25);
        }

        .card i {
            transition: transform 0.3s ease;
        }

        .card-hover:hover i {
            transform: scale(1.2) rotate(-10deg);
        }
    </style>
</head>
<body>
    <div class="container text-center" style="margin-top: 100px;">
        <h1 class="mb-4">Welcome</h1>
        <p class="mb-5">Select your role to continue:</p>

        <div class="row justify-content-center g-4">
            
            <div class="col-md-3">
                <a href="{{ route('admin.login') }}" class="text-decoration-none text-dark">
                    <div class="card card-hover p-4">
                        <i class="bi bi-shield-lock-fill display-1 mb-3 text-primary"></i>
                        <h3>Admin</h3>
                        <p>Manage your system and users</p>
                    </div>
                </a>
            </div>

            
            <div class="col-md-3">
                <a href="{{ route('customer.login') }}" class="text-decoration-none text-dark">
                    <div class="card card-hover p-4">
                        <i class="bi bi-person-fill display-1 mb-3 text-success"></i>
                        <h3>Customer</h3>
                        <p>Access your dashboard and profile</p>
                    </div>
                </a>
            </div>
        </div>
    </div>
</body>
</html>

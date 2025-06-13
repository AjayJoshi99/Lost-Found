<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Lost & Found</title>
    
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet">

    <link href="css/style.css" rel="stylesheet">
</head>
<body class="d-flex align-items-center justify-content-center min-vh-100 bg-dark">
<div class="login-card shadow-lg">
    <h3 class="text-center mb-4">Login</h3>
    <?php if (isset($_GET['error'])): ?>
        <p style="color:red;"><?php echo htmlspecialchars($_GET['error']); ?></p>
    <?php endif; ?>


    <form action="db_logic/process_login.php" method="POST">
        <div class="form-group mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" name="email" class="form-control form-control-lg" required>
        </div>

        <div class="form-group mb-4">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
            <input type="password" id="password" name="password" class="form-control form-control-lg" required>
            <span class="input-group-text toggle-password" style="cursor:pointer;">
                <i class="fa fa-eye" id="toggleIcon"></i>
            </span>
    </div>
</div>

        <button type="submit" class="btn btn-primary w-100">Login</button>
    </form>
</div>

<script>
    const toggle = document.querySelector('.toggle-password');
    const password = document.querySelector('#password');
    const icon = document.querySelector('#toggleIcon');

    toggle.addEventListener('click', () => {
        const isPassword = password.type === 'password';
        password.type = isPassword ? 'text' : 'password';
        icon.classList.toggle('fa-eye');
        icon.classList.toggle('fa-eye-slash');
    });
</script>

</body>
</html>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
  <title>Login - Lost & Found</title>

  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet"/>
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" rel="stylesheet"/>

  <style>
    body {
      background: url('https://media3.giphy.com/media/v1.Y2lkPTc5MGI3NjExNXljNWVqbW5zZTkxZnV5dnBjZ3AxNWw5OTV4Y2hqNXhxazFybHllOCZlcD12MV9pbnRlcm5hbF9naWZfYnlfaWQmY3Q9Zw/3oEduKF1LbjFpfHqXm/giphy.gif') no-repeat center center fixed;
      background-size: cover;
      font-family: 'Segoe UI', sans-serif;
    }

    .login-wrapper {
      background-color: #ffffffee;
      border-radius: 14px;
      padding: 45px 40px;
      width: 100%;
      max-width: 480px;
      box-shadow: 0 10px 35px rgba(0, 0, 0, 0.3);
    }

    .login-wrapper h3 {
      font-weight: 700;
      font-size: 1.8rem;
      margin-bottom: 25px;
      color: #1c1c1c;
    }

    .form-label {
      font-weight: 500;
      color: #444;
    }

    .form-control {
      border-radius: 8px;
      height: 48px;
      font-size: 15px;
    }

    .btn-primary {
      background-color: #0056b3;
      border: none;
      height: 45px;
      border-radius: 8px;
      font-weight: 600;
      transition: 0.3s;
    }

    .btn-primary:hover {
      background-color: #003e80;
    }

    .toggle-password {
      background: none;
      border: none;
      cursor: pointer;
    }

    .form-error {
      color: #721c24;
      background-color: #f8d7da;
      border: 1px solid #f5c6cb;
      border-radius: 6px;
      padding: 10px;
      margin-bottom: 15px;
      font-size: 0.9rem;
    }

    .input-group-text {
      background-color: transparent;
      border: none;
    }

    @media (max-width: 576px) {
      .login-wrapper {
        padding: 30px 25px;
      }
    }
  </style>
</head>

<body class="d-flex align-items-center justify-content-center min-vh-100">

  <div class="login-wrapper">
    <h3 class="text-center">Lost & Found Login</h3>

    <?php if (isset($_GET['error'])): ?>
      <div class="form-error">
        <?php echo htmlspecialchars($_GET['error']); ?>
      </div>
    <?php endif; ?>

    <form action="db_logic/process_login.php" method="POST">
      <div class="mb-3">
        <label for="email" class="form-label">Email address</label>
        <input type="email" name="email" class="form-control" required autocomplete="off" />
      </div>

      <div class="mb-4">
        <label for="password" class="form-label">Password</label>
        <div class="input-group">
          <input type="password" id="password" name="password" class="form-control" required  autocomplete="off"/>
          <button type="button" class="input-group-text toggle-password">
            <i class="fa fa-eye" id="toggleIcon"></i>
          </button>
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

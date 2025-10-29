<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Asset Management System</title>
    <link rel="stylesheet" href="../public/css/main.css">
    <style>
        .login-container {
            max-width: 400px;
            margin: 100px auto;
            padding: 2rem;
            background: white;
            border-radius: 8px;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
        }
        .login-form {
            display: flex;
            flex-direction: column;
        }
        .login-form input {
            margin-bottom: 1rem;
            padding: 0.75rem;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 1rem;
        }
        .login-form button {
            background-color: #2c3e50;
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 4px;
            font-size: 1rem;
            cursor: pointer;
        }
        .login-form button:hover {
            background-color: #34495e;
        }
        .error, .success {
            margin-bottom: 1rem;
            padding: 0.75rem 2rem 0.75rem 1rem;
            border-radius: 4px;
            position: relative;
            animation: slideIn 0.3s ease;
        }
        .error {
            color: #721c24;
            background: #f8d7da;
            border-left: 4px solid #dc3545;
        }
        .success {
            color: #155724;
            background: #d4edda;
            border-left: 4px solid #28a745;
        }
        .error button, .success button {
            position: absolute;
            right: 0.5rem;
            top: 50%;
            transform: translateY(-50%);
            background: none;
            border: none;
            font-size: 1.5rem;
            cursor: pointer;
            color: inherit;
            opacity: 0.7;
        }
        .error button:hover, .success button:hover {
            opacity: 1;
        }
        @keyframes slideIn {
            from { opacity: 0; transform: translateY(-10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .auto-hide {
            animation: slideOut 0.3s ease 3s forwards;
        }
        @keyframes slideOut {
            to { opacity: 0; transform: translateY(-10px); height: 0; margin: 0; padding: 0; }
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Asset Management System</h2>
        <h3>Login</h3>
        
        <?php if (isset($_GET['error'])): ?>
            <div class="error" id="error-toast">
                <span><?php echo htmlspecialchars($_GET['error']); ?></span>
                <button onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        <?php endif; ?>
        
        <?php if (isset($_GET['success'])): ?>
            <div class="success" id="success-toast">
                <span><?php echo htmlspecialchars($_GET['success']); ?></span>
                <button onclick="this.parentElement.style.display='none'">&times;</button>
            </div>
        <?php endif; ?>
        
        <form method="POST" action="index.php?controller=auth&action=login" class="login-form">
            <input type="email" name="email" placeholder="Email" required>
            <input type="password" name="password" placeholder="Password" required>
            <button type="submit">Login</button>
        </form>
    </div>
    
    <script>
        setTimeout(function() {
            const toasts = document.querySelectorAll('.error, .success');
            toasts.forEach(toast => {
                toast.classList.add('auto-hide');
                setTimeout(() => toast.remove(), 3000);
            });
        }, 5000);
    </script>
</body>
</html>

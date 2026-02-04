<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KKV Management System - Login</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * {
            box-sizing: border-box;
            margin: 0;
            padding: 0;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }
        
        body {
            background: linear-gradient(135deg, #3a7bd5, #00d2ff);
            height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            color: #333;
            line-height: 1.6;
            padding: 20px;
        }
        
        .login-container {
            width: 100%;
            max-width: 420px;
            background-color: #fff;
            border-radius: 10px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.2);
            overflow: hidden;
        }
        
        .login-header {
            background-color: #3a7bd5;
            color: white;
            padding: 25px 20px;
            text-align: center;
            font-size: 24px;
            font-weight: bold;
        }
        
        .login-header i {
            margin-right: 10px;
            font-size: 28px;
        }
        
        .login-body {
            padding: 30px;
        }
        
        .form-group {
            margin-bottom: 20px;
            position: relative;
        }
        
        .form-group label {
            display: block;
            margin-bottom: 8px;
            font-weight: 600;
            color: #444;
        }
        
        .input-with-icon {
            position: relative;
        }
        
        .input-with-icon i {
            position: absolute;
            left: 12px;
            top: 50%;
            transform: translateY(-50%);
            color: #3a7bd5;
            font-size: 18px;
        }
        
        .input-with-icon input {
            width: 100%;
            padding: 12px 12px 12px 40px;
            border: 1px solid #ddd;
            border-radius: 4px;
            font-size: 16px;
            transition: border-color 0.3s;
        }
        
        .input-with-icon input:focus {
            border-color: #3a7bd5;
            outline: none;
            box-shadow: 0 0 0 2px rgba(58, 123, 213, 0.2);
        }
        
        .remember-forgot {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 20px;
        }
        
        .remember-me {
            display: flex;
            align-items: center;
        }
        
        .remember-me input {
            margin-right: 8px;
        }
        
        .forgot-password {
            color: #3a7bd5;
            text-decoration: none;
            font-weight: 500;
        }
        
        .forgot-password:hover {
            text-decoration: underline;
        }
        
        .btn-login {
            width: 100%;
            padding: 14px;
            background-color: #3a7bd5;
            color: white;
            border: none;
            border-radius: 4px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: background-color 0.3s;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        
        .btn-login i {
            margin-right: 10px;
        }
        
        .btn-login:hover {
            background-color: #2d68b3;
        }
        
        .login-footer {
            text-align: center;
            margin-top: 20px;
            padding-top: 20px;
            border-top: 1px solid #eee;
            color: #777;
        }
        
        .login-footer a {
            color: #3a7bd5;
            text-decoration: none;
        }
        
        .login-footer a:hover {
            text-decoration: underline;
        }
        
        .error-message {
            color: #e74c3c;
            font-size: 14px;
            margin-top: 5px;
            display: none;
        }
        
        @media (max-width: 480px) {
            .login-container {
                max-width: 100%;
            }
            
            .login-body {
                padding: 20px;
            }
            
            .remember-forgot {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .forgot-password {
                margin-top: 10px;
            }
        }
           .alert {
        padding: 12px 15px;
        margin-bottom: 20px;
        border-radius: 5px;
        font-size: 14px;
        display: flex;
        align-items: center;
        gap: 10px;
    }

    .alert-error {
        background-color: #fee;
        border: 1px solid #f5c6cb;
        color: #721c24;
    }

    .alert-success {
        background-color: #eff8ff;
        border: 1px solid #b8daff;
        color: #004085;
    }

    .input-error {
        border-color: #dc3545 !important;
        box-shadow: 0 0 0 2px rgba(220, 53, 69, 0.1) !important;
    }

    .error-message {
        color: #dc3545;
        font-size: 12px;
        margin-top: 5px;
        display: none;
    }

    /* Pastikan input memiliki border yang bisa di-style */
    .input-with-icon input {
        border: 1px solid #ddd;
        transition: border-color 0.3s ease;
    }

    .input-with-icon input:focus {
        border-color: #007bff;
        outline: none;
    }
    </style>
</head>

<body>
    <div class="login-container">
    <div class="login-header">
        <i class="fas fa-tools"></i> KKV Management System
    </div>
    
    <div class="login-body">
        <form id="loginForm" method="POST" action="{{ route('login') }}">
            {{ csrf_field() }}
            <!-- ERROR MESSAGE CONTAINER - TAMBAHKAN INI -->
            @if($errors->any())
            <div class="alert alert-error">
                <i class="fas fa-exclamation-triangle"></i>
                {{ $errors->first() }}
            </div>
            @endif
            @if(session('status'))
            <div class="alert alert-success">
                <i class="fas fa-check-circle"></i>
                {{ session('status') }}
            </div>
            @endif
            <div class="form-group">
                <label for="email">Email</label>
                <div class="input-with-icon">
                    <i class="fas fa-user"></i>
                    <input type="text" id="email" name="email" 
                           value="{{ old('email') }}" 
                           placeholder="Enter your email" 
                           required
                           class="{{ $errors->has('email') ? 'input-error' : '' }}">
                </div>
                <div class="error-message" id="emailError">Please enter a valid email</div>
            </div>
            
            <div class="form-group">
                <label for="password">Password</label>
                <div class="input-with-icon">
                    <i class="fas fa-lock"></i>
                    <input type="password" id="password" name="password" 
                           placeholder="Enter your password" 
                           required
                           class="{{ $errors->has('password') ? 'input-error' : '' }}">
                </div>
                <div class="error-message" id="passwordError">Please enter your password</div>
            </div>

            <button type="submit" class="btn-login">
                <i class="fas fa-sign-in-alt"></i> Login
            </button>
        </form>
        
        <div class="login-footer">
            <p>Don't have an account? <a href="mailto:karyadi.simamora@ottopharm.com">Contact Administrator</a></p>
            <p>Version 2.1.0 © 2025</p>
        </div>
    </div>
</div>

<script>
    document.getElementById('loginForm').addEventListener('submit', function(e) {
        // HAPUS e.preventDefault() - biarkan form submit normal
        let username = document.getElementById('email').value.trim();
        let password = document.getElementById('password').value.trim();
        let valid = true;

        // Reset error messages
        document.getElementById('emailError').style.display = 'none';
        document.getElementById('passwordError').style.display = 'none';

        // Client-side validation
        if (username === '') {
            document.getElementById('emailError').style.display = 'block';
            valid = false;
        }
        if (password === '') {
            document.getElementById('passwordError').style.display = 'block';
            valid = false;
        }

        // Jika valid, biarkan form submit secara normal
        // Jika tidak valid, prevent default
        if (!valid) {
            e.preventDefault();
        }
    });

    // Hide error messages ketika user mulai mengetik
    document.getElementById('email').addEventListener('input', function() {
        document.getElementById('emailError').style.display = 'none';
    });

    document.getElementById('password').addEventListener('input', function() {
        document.getElementById('passwordError').style.display = 'none';
    });
</script>
</body>
</html>
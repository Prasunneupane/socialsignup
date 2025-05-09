<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login with Google</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
            padding-top: 100px;
        }
        .login-container {
            max-width: 400px;
            margin: 0 auto;
            background-color: #fff;
            padding: 30px;
            border-radius: 5px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .google-btn {
            background-color: #fff;
            color: #757575;
            border: 1px solid #ddd;
            padding: 10px 20px;
            border-radius: 5px;
            cursor: pointer;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 20px auto;
            width: 100%;
            transition: background-color 0.3s;
        }
        .google-btn:hover {
            background-color: #f1f1f1;
        }
        .google-icon {
            margin-right: 10px;
            width: 18px;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="login-container">
            <h2 class="mb-4">Welcome</h2>
            <p class="text-muted mb-4">Sign in to continue</p>
            
            <?php
            // Include config file
            
            require_once 'config.php';
            session_start();
            // Generate a state parameter to prevent CSRF attacks
            $_SESSION['oauth_state'] = bin2hex(random_bytes(16));
            
            // Build the authorization URL
            $auth_params = [
                'client_id' => $client_id,
                'redirect_uri' => $redirect_uri,
                'response_type' => 'code',
                'scope' => $scope,
                'state' => $_SESSION['oauth_state'],
                'access_type' => 'offline',
                'prompt' => 'consent'
            ];
            
            $auth_link = $auth_url . '?' . http_build_query($auth_params);
            ?>
            
            <a href="<?php echo $auth_link; ?>" class="google-btn">
                <svg class="google-icon" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48">
                    <path fill="#EA4335" d="M24 9.5c3.54 0 6.71 1.22 9.21 3.6l6.85-6.85C35.9 2.38 30.47 0 24 0 14.62 0 6.51 5.38 2.56 13.22l7.98 6.19C12.43 13.72 17.74 9.5 24 9.5z"/>
                    <path fill="#4285F4" d="M46.98 24.55c0-1.57-.15-3.09-.38-4.55H24v9.02h12.94c-.58 2.96-2.26 5.48-4.78 7.18l7.73 6c4.51-4.18 7.09-10.36 7.09-17.65z"/>
                    <path fill="#FBBC05" d="M10.53 28.59c-.48-1.45-.76-2.99-.76-4.59s.27-3.14.76-4.59l-7.98-6.19C.92 16.46 0 20.12 0 24c0 3.88.92 7.54 2.56 10.78l7.97-6.19z"/>
                    <path fill="#34A853" d="M24 48c6.48 0 11.93-2.13 15.89-5.81l-7.73-6c-2.15 1.45-4.92 2.3-8.16 2.3-6.26 0-11.57-4.22-13.47-9.91l-7.98 6.19C6.51 42.62 14.62 48 24 48z"/>
                    <path fill="none" d="M0  0h48v48H0z"/>
                </svg>
                Sign in with Google
            </a>
            
            <p class="mt-4 text-muted">Don't have an account? <a href="#">Register</a></p>
        </div>
    </div>
</body>
</html>
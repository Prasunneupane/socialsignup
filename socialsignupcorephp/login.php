<?php
// callback.php - This file handles the OAuth callback

session_start();

// // Debugging
// error_reporting(E_ALL);
// ini_set('display_errors', 1);

// echo "Session data:<br>";
// var_dump($_SESSION);
// echo "<br><br>";

// echo "GET data:<br>";
// var_dump($_GET);
// echo "<br><br>";
require_once 'config.php';
require_once 'db.php';

// Check if the state parameter matches
if (!isset($_GET['state']) || $_GET['state'] !== $_SESSION['oauth_state']) {
    die('State parameter does not match. Possible CSRF attack.');
}

// Check if authorization code is present
if (isset($_GET['code'])) {
    $code = $_GET['code'];
    // var_dump($_GET);exit;
    
    // Exchange the authorization code for an access token
    $token_data = [
        'code' => $code,
        'client_id' => $client_id,
        'client_secret' => $client_secret,
        'redirect_uri' => $redirect_uri,
        'grant_type' => 'authorization_code'
    ];
    
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $token_url);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query($token_data));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    $response = curl_exec($ch);
    curl_close($ch);
    
    $token_info = json_decode($response, true);
    
    if (isset($token_info['access_token'])) {
        // Use the access token to get user information
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $user_info_url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, ['Authorization: Bearer ' . $token_info['access_token']]);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        $user_info_response = curl_exec($ch);
        curl_close($ch);
        
        $user_info = json_decode($user_info_response, true);
        
        if (isset($user_info['sub'])) {
            // Store user information in the database
            $google_id = $user_info['sub'];
            $email = $user_info['email'] ?? '';
            $name = $user_info['name'] ?? '';
            $picture = $user_info['picture'] ?? '';
            
            // Check if user exists in the database
            $stmt = $conn->prepare("SELECT * FROM users WHERE google_id = ?");
            $stmt->bind_param("s", $google_id);
            $stmt->execute();
            $result = $stmt->get_result();
            
            if ($result->num_rows > 0) {
                // User exists, update information
                $user = $result->fetch_assoc();
                $user_id = $user['id'];
                
                $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, picture = ?, last_login = NOW() WHERE id = ?");
                $stmt->bind_param("sssi", $name, $email, $picture, $user_id);
                $stmt->execute();
            } else {
                // New user, insert into database
                $stmt = $conn->prepare("INSERT INTO users (google_id, name, email, picture, created_at, last_login) VALUES (?, ?, ?, ?, NOW(), NOW())");
                $stmt->bind_param("ssss", $google_id, $name, $email, $picture);
                $stmt->execute();
                $user_id = $conn->insert_id;
            }
            
            // Save access token in sessions
            $_SESSION['access_token'] = $token_info['access_token'];
            $_SESSION['user_id'] = $user_id;
            $_SESSION['user_name'] = $name;
            $_SESSION['user_email'] = $email;
            $_SESSION['user_picture'] = $picture;
            
            // Redirect to dashboard
            header('Location: dashboard.php');
            exit;
        } else {
            die('Failed to get user information.');
        }
    } else {
        die('Failed to get access token.');
    }
} else {
    die('Authorization code not found.');
}
?>
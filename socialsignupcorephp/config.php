<?php
// config.php - Store configuration variables
$client_id = '1024633207248-kthv7di4i98t92npfre4kr78gj9s8uds.apps.googleusercontent.com'; // Replace with your actual client ID
$client_secret = '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'; // Replace with your actual client secret
$redirect_uri = 'http://localhost/socialsignupcorephp/login.php'; // Update with your redirect URI
$auth_url = 'https://accounts.google.com/o/oauth2/auth';
$token_url = 'https://oauth2.googleapis.com/token';
$user_info_url = 'https://www.googleapis.com/oauth2/v3/userinfo';
$scope = 'email profile'; // The permissions you're requesting

// Database configuration
$db_host = 'localhost';
$db_user = 'root';
$db_pass = '';
$db_name = 'google_auth';
?>


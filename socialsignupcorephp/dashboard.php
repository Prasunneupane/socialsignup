<?php
// dashboard.php - User dashboard after successful login
session_start();

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: index.php');
    exit;
}

// Get user data from session
$user_id = $_SESSION['user_id'];
$user_name = $_SESSION['user_name'];
$user_email = $_SESSION['user_email'];
$user_picture = $_SESSION['user_picture'];
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .profile-img {
            width: 100px;
            height: 100px;
            border-radius: 50%;
            object-fit: cover;
            border: 3px solid #fff;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .header {
            background-color: #f8f9fa;
            padding: 20px 0;
            border-bottom: 1px solid #e9ecef;
        }
        .dashboard-content {
            padding: 30px 0;
        }
    </style>
</head>
<body>
    <div class="header">
        <div class="container">
            <div class="row align-items-center">
                <div class="col-md-6">
                    <h2>Welcome to Dashboard</h2>
                </div>
                <div class="col-md-6 text-end">
                    <div class="d-flex align-items-center justify-content-end">
                        <div class="me-3">
                            <p class="mb-0 fw-bold"><?php echo htmlspecialchars($user_name); ?></p>
                            <p class="mb-0 text-muted small"><?php echo htmlspecialchars($user_email); ?></p>
                        </div>
                        <img src="<?php echo htmlspecialchars($user_picture); ?>" alt="Profile" class="profile-img">
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="dashboard-content">
        <div class="container">
            <div class="row">
                <div class="col-12">
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">Your Profile Information</h5>
                            <p>You've successfully logged in using Google Authentication.</p>
                            <ul class="list-group mt-3">
                                <li class="list-group-item"><strong>User ID:</strong> <?php echo htmlspecialchars($user_id); ?></li>
                                <li class="list-group-item"><strong>Name:</strong> <?php echo htmlspecialchars($user_name); ?></li>
                                <li class="list-group-item"><strong>Email:</strong> <?php echo htmlspecialchars($user_email); ?></li>
                            </ul>
                            <a href="logout.php" class="btn btn-danger mt-3">Logout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
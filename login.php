<?php
// Start session
session_start();

// Include database connection
require_once 'connection.php';

// Initialize error variable
$error = "";

// Process login form submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST["email"] ?? "";
    $password = $_POST["password"] ?? "";
    
    // Basic validation
    if (empty($email) || empty($password)) {
        $error = "All fields are required";
    } else {
        // Prepare SQL statement to prevent SQL injection
        $stmt = $conn->prepare("SELECT id, email, password FROM users WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $user = $result->fetch_assoc();
            
            // Verify password
            if (password_verify($password, $user['password'])) {
                // Password is correct, create session
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['user_email'] = $user['email'];
                
                // Redirect to dashboard or home page
                header("Location: dashboard.php");
                exit;
            } else {
                $error = "Invalid email or password";
            }
        } else {
            $error = "Invalid email or password";
        }
        
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>KORT WYEM - Sign In</title>
    <link rel="stylesheet" href="asset/style.css">
</head>
<body>
    <div class="logo-container">
        <img src="asset/logo1.1.png" alt="KORTambayan Logo" class="logo">
    </div>
    
    <div class="login-container">
        <div class="login-header">SIGN IN</div>
        
        <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <?php if (!empty($error)): ?>
                <div class="error-message">
                    <?php echo $error; ?>
                </div>
            <?php endif; ?>
            
            <div class="form-group">
                <input type="email" name="email" placeholder="EMAIL ADDRESS" required>
            </div>
            
            <div class="form-group">
                <input type="password" name="password" placeholder="PASSWORD" required>
            </div>
            
            <button type="submit" class="signin-button">SIGN IN</button>
            
            <div class="reg">
                <a href="register.php">Looking for a spot? Join now</a>
            </div>
        </form>
    </div>
</body>
</html>
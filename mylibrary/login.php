<?php
session_start();

// Database connection
$servername = "localhost";
$username = "root"; // Default username in XAMPP
$password = ""; // Default password in XAMPP
$dbname = "da"; // Your database name, ensure it's correct

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error); 
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $user = $_POST['username'];
    $pass = $_POST['password'];

    // Prepare the query to get the user from the database
    $stmt = $conn->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->bind_param("s", $user);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if the user exists and verify the password
    if ($result->num_rows > 0) {
        $user_data = $result->fetch_assoc();
        if (password_verify($pass, $user_data['password'])) {
            // Password is correct
            $_SESSION['user_id'] = $user_data['id'];
            $_SESSION['user_name'] = $user_data['name'];
            $_SESSION['role'] = $user_data['role'];

            // Redirect to the home page after login
            header("Location: home.php");
            exit();
        } else {
            $error_message = "Invalid username or password.";
        }
    } else {
        $error_message = "No user found with that email.";
    }

    $stmt->close();
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Login - Library Management</title>
    <link rel="stylesheet" href="styles.css" />
    <style>
        body {
            font-family: Arial, sans-serif;
            background: url('images/library-bg.jpg') no-repeat center center fixed;
            background-size: cover;
            margin: 0;
            padding: 0;
            color: white;
        }
        nav {
            background: rgba(0, 0, 0, 0.8);
            padding: 15px;
            text-align: center;
            width: 100%;
            position: fixed;
            top: 0;
            left: 0;
            z-index: 1000;
        }
        nav ul {
            list-style: none;
            padding: 0;
            margin: 0;
            display: flex;
            justify-content: center;
        }
        nav ul li {
            margin: 0 15px;
        }
        nav ul li a {
            color: white;
            text-decoration: none;
            font-size: 18px;
            font-weight: bold;
            padding: 10px 15px;
            background: #27ae60;
            border-radius: 5px;
            transition: background 0.3s;
        }
        nav ul li a:hover {
            background: #219150;
        }
        .login-container {
            margin: 120px auto;
            max-width: 400px;
            background: rgba(0, 0, 0, 0.7);
            padding: 30px;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.5);
        }
        h2 {
            text-align: center;
            margin-bottom: 20px;
        }
        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 12px;
            margin: 10px 0;
            border: none;
            border-radius: 5px;
            box-sizing: border-box;
        }
        .login-btn {
            width: 100%;
            padding: 12px;
            background: #f39c12;
            color: black;
            font-size: 16px;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .login-btn:hover {
            background: #e67e22;
        }
        .error-message {
            color: red;
            text-align: center;
            margin-top: 10px;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <li><a href="home.php">Home</a></li>
            <li><a href="books.php">Books</a></li>
            <li><a href="cart.php">Cart</a></li>
            <li><a href="contact.php">Contact</a></li>
            <li><a href="login.php" class="active">Login</a></li>
        </ul>
    </nav>

    <div class="login-container">
        <h2>Login</h2>
        <form method="POST" action="login.php">
            <input type="text" name="username" placeholder="Username" required />
            <input type="password" name="password" placeholder="Password" required />
            <button type="submit" class="login-btn">Login</button>
        </form>
        <?php
            if (isset($error_message)) {
                echo '<div class="error-message">' . $error_message . '</div>';
            }
        ?>
    </div>
</body>
</html>


<?php
$conn = new mysqli("localhost", "root", "", "dairy_sanklan");

// Fetch only companies where active = 'A'
$companies = $conn->query("SELECT srno, comname FROM Company_Detail WHERE active = 'A'");

// Login check
if (isset($_POST['login'])) {
    $company_id = $_POST['company_id'];
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Check login for active company (active = 'A')
    $stmt = $conn->prepare("SELECT * FROM Company_Detail WHERE srno=? AND username=? AND password=? AND active='A'");
    $stmt->bind_param("iss", $company_id, $username, $password);
    $stmt->execute();
    $res = $stmt->get_result();

    if ($res->num_rows > 0) {
        session_start();
        $_SESSION['user'] = $username;
        $_SESSION['company_id'] = $company_id;
        header("Location: index.php");
    } else {
        $error = "Invalid login or company is not active.";
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Login Page</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background: #f1f1f1;
            margin: 0;
            padding: 0;
        }
        .login-container {
            width: 420px;
            margin: 80px auto;
            background: #fff;
            border-radius: 10px;
            padding: 30px;
            box-shadow: 0 0 15px rgba(0,0,0,0.2);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        label {
            display: block;
            margin-top: 15px;
            color: #34495e;
        }
        select, input[type="text"], input[type="password"] {
            width: 100%;
            padding: 10px;
            margin-top: 5px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        input[type="submit"] {
            background: #3498db;
            color: white;
            padding: 12px;
            margin-top: 20px;
            width: 100%;
            border: none;
            border-radius: 6px;
            cursor: pointer;
            font-size: 16px;
        }
        input[type="submit"]:hover {
            background: #2980b9;
        }
        .status {
            margin-top: 10px;
            font-weight: bold;
            color: green;
            text-align: center;
        }
        .error {
            color: #e74c3c;
            margin-top: 15px;
            text-align: center;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <h2>Company Login</h2>
        <form method="POST">
            <label for="company_id">Select Company (Only Active):</label>
            <select name="company_id" id="company_id" required>
                <option value="">-- Select Company --</option>
                <?php while ($row = $companies->fetch_assoc()) { ?>
                    <option value="<?= $row['srno'] ?>" <?= (isset($_POST['company_id']) && $_POST['company_id'] == $row['srno']) ? 'selected' : '' ?>>
                        <?= htmlspecialchars($row['comname']) ?>
                    </option>
                <?php } ?>
            </select>

            

            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <input type="submit" name="login" value="Login">

            <?php if (isset($error)) echo "<div class='error'>$error</div>"; ?>
        </form>
    </div>
</body>
</html>

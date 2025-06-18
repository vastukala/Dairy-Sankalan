<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "dairy_sanklan");

date_default_timezone_set('Asia/Kolkata'); // ensure time zone is set

// Detect session based on current hour
$currentHour = (int)date('H');
$sessionFlag = ($currentHour < 15) ? 'M' : 'E';

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['save'])) {
    $accno = $_POST['accno'];
    $acname = $_POST['acname'];
    $date = $_POST['date'];
    $animal = strtolower($_POST['animal']); // buffalo or cow
    $liter = $_POST['liter'];
    $fat = $_POST['fat'];
    $snf = $_POST['snf'];

    // Insert 'M' or 'E' in morning/evening columns
    $morning = ($sessionFlag === 'M') ? 'M' : NULL;
    $evening = ($sessionFlag === 'E') ? 'E' : NULL;

    $cowliter = ($animal === 'cow') ? $liter : NULL;
    $bufliter = ($animal === 'buffalo') ? $liter : NULL;

    // Check if a record already exists for this accno, date, and session
    $check_stmt = $conn->prepare("SELECT entryno FROM milk_sanklan1 WHERE accno = ? AND sandate = ? AND (morning = ? OR evening = ?)");
    $check_stmt->bind_param("isss", $accno, $date, $sessionFlag, $sessionFlag);
    $check_stmt->execute();
    $existing_entry = $check_stmt->get_result()->fetch_assoc();

    if ($existing_entry) {
        // Update existing record
        $stmt = $conn->prepare("UPDATE milk_sanklan1 SET cowliter = ?, bufliter = ?, fat = ?, snf = ? WHERE entryno = ?");
        $stmt->bind_param("ddssi", $cowliter, $bufliter, $fat, $snf, $existing_entry['entryno']);
        $success_message = "Record updated successfully.";
    } else {
        // Insert new record
        $stmt = $conn->prepare("INSERT INTO milk_sanklan1 (sandate, accno, acname, morning, evening, cowliter, bufliter, fat, snf) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");
        $stmt->bind_param("sisssddss", $date, $accno, $acname, $morning, $evening, $cowliter, $bufliter, $fat, $snf);
        $success_message = "Record inserted successfully.";
    }

    if ($stmt->execute()) {
        $_SESSION['message'] = "<p class='success'>$success_message</p>";
    } else {
        $_SESSION['message'] = "<p class='error'>Error: " . $conn->error . "</p>";
    }

    header("Location: index.php");
    exit;
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Milk Entry Form</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background-color: #f4f8fb;
            margin: 0;
            padding: 0;
        }
        .view-reports-button {
            position: absolute;
            top: 70px;
            right: 20px;
            z-index: 10;
        }
        .view-reports-button button {
            padding: 10px 20px;
            background-color: #2c3e50;
            color: white;
            border: none;
            border-radius: 5px;
            cursor: pointer;
        }
        .container {
            width: 450px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            border-radius: 12px;
            box-shadow: 0 0 10px rgba(0,0,0,0.15);
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        label {
            display: block;
            margin-top: 15px;
            color: #34495e;
            font-weight: 500;
        }
        input[type="text"],
        input[type="number"],
        input[type="date"] {
            width: 100%;
            padding: 10px;
            margin-top: 6px;
            border: 1px solid #ccc;
            border-radius: 6px;
        }
        input[type="submit"] {
            background-color: #3498db;
            color: white;
            border: none;
            padding: 12px;
            margin-top: 20px;
            border-radius: 6px;
            width: 100%;
            font-size: 16px;
            cursor: pointer;
        }
        input[type="submit"]:hover {
            background-color: #2980b9;
        }
        .success, .error {
            padding: 10px;
            margin-top: 15px;
            border-radius: 6px;
            text-align: center;
            font-weight: bold;
        }
        .success { background-color: #2ecc71; color: white; }
        .error { background-color: #e74c3c; color: white; }
    </style>
</head>
<body>

    <div class="view-reports-button">
        <a href="view_reports.php" target="_blank" style="text-decoration: none;">
            <button>View Reports</button>
        </a>
    </div>

    <div class="container">
        <h2>Milk Entry Form</h2>
        <?php
        if (isset($_SESSION['message'])) {
            echo $_SESSION['message'];
            unset($_SESSION['message']);
        }
        ?>
        <form method="POST" autocomplete="off">
            <label for="accno">Account No:</label>
            <input type="number" name="accno" id="accno" required>

            <label for="acname">Name:</label>
            <input type="text" name="acname" id="acname" readonly required>

            <label for="animal">Animal:</label>
            <input type="text" name="animal" id="animal" readonly style="background-color: #e9ecef;">

            <label for="session_display">Session:</label>
            <input type="text" id="session_display" value="<?= $sessionFlag === 'M' ? 'Morning' : 'Evening' ?>" readonly style="background-color: #e9ecef;">

            <label for="date">Date:</label>
            <input type="date" name="date" value="<?= date('Y-m-d') ?>">

            <label for="liter">Liter:</label>
			<input type="text" name="liter" required pattern="^\d+(\.\d{1,2})?$" title="Enter a valid number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">

			<label for="fat">Fat:</label>
			<input type="text" name="fat" required pattern="^\d+(\.\d{1,2})?$" title="Enter a valid number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">

			<label for="snf">SNF:</label>
			<input type="text" name="snf" required pattern="^\d+(\.\d{1,2})?$" title="Enter a valid number" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');">


            <input type="submit" name="save" value="Save Entry">
        </form>
    </div>

    <script>
        document.getElementById("accno").addEventListener("blur", function () {
            var accno = this.value;
            var acnameInput = document.getElementById("acname");
            var animalInput = document.getElementById("animal");

            if (accno) {
                var xhr = new XMLHttpRequest();
                xhr.open("POST", "get_name.php", true);
                xhr.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xhr.onload = function () {
                    try {
                        var res = JSON.parse(xhr.responseText);
                        acnameInput.value = res.name || "";
                        animalInput.value = res.animal || "";
                    } catch (e) {
                        acnameInput.value = "";
                        animalInput.value = "";
                    }
                };
                xhr.send("accno=" + encodeURIComponent(accno));
            } else {
                acnameInput.value = "";
                animalInput.value = "";
            }
        });
    </script>
</body>
</html>

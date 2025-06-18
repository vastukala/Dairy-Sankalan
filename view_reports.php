<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "dairy_sanklan");

// Fetch all rows
$rows = [];
$result = $conn->query("SELECT * FROM milk_sanklan1 ORDER BY entryno DESC");

$showMorning = false;
$showEvening = false;
$showCow = false;
$showBuffalo = false;

$totalLiter = 0;
$totalFat = 0;
$totalSnf = 0;
$fatCount = 0;
$snfCount = 0;

while ($row = $result->fetch_assoc()) {
    $rows[] = $row;

    if (!$showMorning && !empty($row['morning'])) $showMorning = true;
    if (!$showEvening && !empty($row['evening'])) $showEvening = true;
    if (!$showCow && !empty($row['cowliter'])) $showCow = true;
    if (!$showBuffalo && !empty($row['bufliter'])) $showBuffalo = true;

    $lit = (float)($row['cowliter'] ?? 0) + (float)($row['bufliter'] ?? 0);
    $totalLiter += $lit;

    if (is_numeric($row['fat'])) {
        $totalFat += (float)$row['fat'];
        $fatCount++;
    }

    if (is_numeric($row['snf'])) {
        $totalSnf += (float)$row['snf'];
        $snfCount++;
    }
}

$avgFat = $fatCount > 0 ? round($totalFat / $fatCount, 2) : 0;
$avgSnf = $snfCount > 0 ? round($totalSnf / $snfCount, 2) : 0;
?>

<!DOCTYPE html>
<html>
<head>
    <title>Milk Entry Reports</title>
    <style>
        body {
            font-family: "Segoe UI", sans-serif;
            background-color: #f9f9f9;
            margin: 20px;
        }
        h2 {
            text-align: center;
            color: #2c3e50;
        }
        .export-btn {
            text-align: right;
            margin-bottom: 10px;
        }
        .export-btn button {
            padding: 8px 16px;
            background-color: #27ae60;
            color: white;
            border: none;
            border-radius: 4px;
            cursor: pointer;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 15px;
        }
        th, td {
            border: 1px solid #ccc;
            padding: 10px 12px;
            text-align: center;
        }
        th {
            background-color: #2980b9;
            color: white;
        }
        tr:nth-child(even) {
            background-color: #f4f8fb;
        }
        tfoot tr {
            background-color: #f0f0f0;
            font-weight: bold;
        }
    </style>
</head>
<body>
    <h2>Milk Entry Report</h2>

    <div class="export-btn">
        <a href="export_excel.php" target="_blank">
            <button>⬇ Download Excel</button>
        </a>
        <a href="export_pdf.php" target="_blank" style="text-decoration: none; margin-left: 10px;">
            <button style="background-color: #c0392b;">⬇ Download PDF</button>
        </a>
    </div>

    <table>
        <thead>
            <tr>
                <th>ID</th>
                <th>Account No</th>
                <th>Name</th>
                <th>Date</th>
                <?php if ($showMorning): ?><th>Morning</th><?php endif; ?>
                <?php if ($showEvening): ?><th>Evening</th><?php endif; ?>
                <?php if ($showCow): ?><th>Cow (Ltr)</th><?php endif; ?>
                <?php if ($showBuffalo): ?><th>Buffalo (Ltr)</th><?php endif; ?>
                <th>Fat</th>
                <th>SNF</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rows as $row): ?>
            <tr>
                <td><?= $row['entryno'] ?></td>
                <td><?= $row['accno'] ?></td>
                <td><?= htmlspecialchars($row['acname']) ?></td>
                <td><?= $row['sandate'] ? date("Y-m-d", strtotime($row['sandate'])) : '-' ?></td>
                <?php if ($showMorning): ?><td><?= $row['morning'] ?? '-' ?></td><?php endif; ?>
                <?php if ($showEvening): ?><td><?= $row['evening'] ?? '-' ?></td><?php endif; ?>
                <?php if ($showCow): ?><td><?= $row['cowliter'] ?? '-' ?></td><?php endif; ?>
                <?php if ($showBuffalo): ?><td><?= $row['bufliter'] ?? '-' ?></td><?php endif; ?>
                <td><?= $row['fat'] ?? '-' ?></td>
                <td><?= $row['snf'] ?? '-' ?></td>
            </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="background-color:#dff0d8;">
                <td colspan="<?= 4 + ($showMorning ? 1 : 0) + ($showEvening ? 1 : 0) + ($showCow ? 1 : 0) + ($showBuffalo ? 1 : 0) ?>">Total Liter</td>
                <td colspan="2"><?= $totalLiter ?> Ltr</td>
            </tr>
            <tr style="background-color:#f7ecb5;">
                <td colspan="<?= 4 + ($showMorning ? 1 : 0) + ($showEvening ? 1 : 0) + ($showCow ? 1 : 0) + ($showBuffalo ? 1 : 0) ?>">Average Fat / SNF</td>
                <td><?= $avgFat ?></td>
                <td><?= $avgSnf ?></td>
            </tr>
        </tfoot>
    </table>
</body>
</html>

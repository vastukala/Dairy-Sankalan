<?php
session_start();
if (!isset($_SESSION['user'])) {
    header("Location: login.php");
    exit;
}

$conn = new mysqli("localhost", "root", "", "dairy_sanklan");

$filter = $_GET['filter'] ?? 'all';
$custom_date = $_GET['custom_date'] ?? '';

$whereClauses = [];
if ($filter !== 'all') {
    switch ($filter) {
        case 'this_morning':
            $whereClauses[] = "sandate = CURDATE() AND morning = 'M'";
            break;
        case 'this_evening':
            $whereClauses[] = "sandate = CURDATE() AND evening = 'E'";
            break;
        case 'today':
            $whereClauses[] = "sandate = CURDATE()";
            break;
        case 'this_week':
            $whereClauses[] = "YEARWEEK(sandate, 1) = YEARWEEK(CURDATE(), 1)";
            break;
        case 'this_month':
            $whereClauses[] = "YEAR(sandate) = YEAR(CURDATE()) AND MONTH(sandate) = MONTH(CURDATE())";
            break;
        case 'this_year':
            $whereClauses[] = "YEAR(sandate) = YEAR(CURDATE())";
            break;
        case 'custom':
            if (!empty($custom_date)) {
                $whereClauses[] = "sandate = '" . $conn->real_escape_string($custom_date) . "'";
            }
            break;
    }
}

$whereSql = '';
if (!empty($whereClauses)) {
    $whereSql = 'WHERE ' . implode(' AND ', $whereClauses);
}

$query = "SELECT * FROM milk_sanklan1 $whereSql ORDER BY entryno DESC";
$result = $conn->query($query);

$rows = [];
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

    <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 10px;">
        <div style="display: flex; align-items: center;">
            <a href="index.php" style="text-decoration: none; margin-right: 20px;">
                <button style="padding: 8px 16px; background-color: #34495e; color: white; border: none; border-radius: 4px; cursor: pointer;">&#8592; Back</button>
            </a>
            <form method="GET" action="view_reports.php" id="filterForm" style="margin: 0; display: flex; align-items: center;">
                <label for="filter" style="font-weight: bold; color: #2c3e50; margin-right: 10px;">Filter:</label>
                <select name="filter" id="filter" style="padding: 8px; border-radius: 4px; border: 1px solid #ccc;">
                    <option value="all" <?= $filter === 'all' ? 'selected' : '' ?>>All</option>
                    <option value="this_morning" <?= $filter === 'this_morning' ? 'selected' : '' ?>>This Morning</option>
                    <option value="this_evening" <?= $filter === 'this_evening' ? 'selected' : '' ?>>This Evening</option>
                    <option value="today" <?= $filter === 'today' ? 'selected' : '' ?>>Today</option>
                    <option value="this_week" <?= $filter === 'this_week' ? 'selected' : '' ?>>This Week</option>
                    <option value="this_month" <?= $filter === 'this_month' ? 'selected' : '' ?>>This Month</option>
                    <option value="this_year" <?= $filter === 'this_year' ? 'selected' : '' ?>>This Year</option>
                    <option value="custom" <?= $filter === 'custom' ? 'selected' : '' ?>>Custom</option>
                </select>
                <div id="custom-date-container" style="margin-left: 10px; display: <?= $filter === 'custom' ? 'block' : 'none' ?>;">
                    <input type="date" name="custom_date" id="custom_date" value="<?= htmlspecialchars($custom_date) ?>" style="padding: 7px; border-radius: 4px; border: 1px solid #ccc;">
                    <button type="submit" style="padding: 8px 12px; border-radius: 4px; border: none; background-color: #3498db; color: white; cursor: pointer;">Go</button>
                </div>
            </form>
        </div>
        <div class="export-btn">
            <?php
            $export_params = '';
            if ($filter !== 'all') {
                $export_params = '?filter=' . urlencode($filter);
                if ($filter === 'custom' && !empty($custom_date)) {
                    $export_params .= '&custom_date=' . urlencode($custom_date);
                }
            }
            ?>
            <a href="export_excel.php<?= $export_params ?>" target="_blank">
                <button>⬇ Download Excel</button>
            </a>
            <a href="export_pdf.php<?= $export_params ?>" target="_blank" style="text-decoration: none; margin-left: 10px;">
                <button style="background-color: #c0392b;">⬇ Download PDF</button>
            </a>
        </div>
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

    <script>
        document.getElementById('filter').addEventListener('change', function() {
            var customDateContainer = document.getElementById('custom-date-container');
            if (this.value === 'custom') {
                customDateContainer.style.display = 'block';
            } else {
                customDateContainer.style.display = 'none';
                document.getElementById('filterForm').submit();
            }
        });
    </script>
</body>
</html>

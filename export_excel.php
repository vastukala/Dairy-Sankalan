<?php
header("Content-Type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=milk_entry_report.xls");
header("Pragma: no-cache");
header("Expires: 0");

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
$totalLiter = 0;
$totalFat = 0;
$totalSnf = 0;
$fatCount = 0;
$snfCount = 0;

while ($row = $result->fetch_assoc()) {
    $rows[] = $row;
    $totalLiter += (float)($row['cowliter'] ?? 0) + (float)($row['bufliter'] ?? 0);
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

echo "<table border='1'>";
echo "<thead><tr>
        <th>ID</th>
        <th>Account No</th>
        <th>Name</th>
        <th>Date</th>
        <th>Morning</th>
        <th>Evening</th>
        <th>Cow (Ltr)</th>
        <th>Buffalo (Ltr)</th>
        <th>Fat</th>
        <th>SNF</th>
    </tr></thead>";

echo "<tbody>";
foreach ($rows as $row) {
    echo "<tr>";
    echo "<td>" . $row['entryno'] . "</td>";
    echo "<td>" . $row['accno'] . "</td>";
    echo "<td>" . htmlspecialchars($row['acname']) . "</td>";
    echo "<td>" . ($row['sandate'] ? date("Y-m-d", strtotime($row['sandate'])) : '-') . "</td>";
    echo "<td>" . ($row['morning'] ?? '-') . "</td>";
    echo "<td>" . ($row['evening'] ?? '-') . "</td>";
    echo "<td>" . ($row['cowliter'] ?? '-') . "</td>";
    echo "<td>" . ($row['bufliter'] ?? '-') . "</td>";
    echo "<td>" . ($row['fat'] ?? '-') . "</td>";
    echo "<td>" . ($row['snf'] ?? '-') . "</td>";
    echo "</tr>";
}
echo "</tbody>";

echo "<tfoot>";
echo "<tr>
        <td colspan='8' style='font-weight:bold;'>Total Liter</td>
        <td colspan='2' style='font-weight:bold;'>" . $totalLiter . " Ltr</td>
      </tr>";
echo "<tr>
        <td colspan='8' style='font-weight:bold;'>Average Fat / SNF</td>
        <td style='font-weight:bold;'>" . $avgFat . "</td>
        <td style='font-weight:bold;'>" . $avgSnf . "</td>
      </tr>";
echo "</tfoot>";

echo "</table>";
?>

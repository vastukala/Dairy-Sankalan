<?php
require('fpdf/fpdf.php');

class PDF extends FPDF
{
    // Page header
    function Header()
    {
        $this->SetFont('Arial', 'B', 12);
        $this->Cell(0, 10, 'Milk Entry Report', 0, 1, 'C');
        $this->Ln(5);
    }

    // Page footer
    function Footer()
    {
        $this->SetY(-15);
        $this->SetFont('Arial', 'I', 8);
        $this->Cell(0, 10, 'Page ' . $this->PageNo(), 0, 0, 'C');
    }
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

$pdf = new PDF('L', 'mm', 'A4'); // Landscape, mm, A4
$pdf->AddPage();
$pdf->SetFont('Arial', 'B', 10);

// Table Header
$header = ['ID', 'Account No', 'Name', 'Date', 'Morning', 'Evening', 'Cow (Ltr)', 'Buffalo (Ltr)', 'Fat', 'SNF'];
$widths = [15, 25, 50, 30, 20, 20, 30, 30, 20, 20];
for ($i = 0; $i < count($header); $i++) {
    $pdf->Cell($widths[$i], 10, $header[$i], 1, 0, 'C');
}
$pdf->Ln();

$pdf->SetFont('Arial', '', 9);

foreach ($rows as $row) {
    $pdf->Cell($widths[0], 10, $row['entryno'], 1);
    $pdf->Cell($widths[1], 10, $row['accno'], 1);
    $pdf->Cell($widths[2], 10, htmlspecialchars($row['acname']), 1);
    $pdf->Cell($widths[3], 10, ($row['sandate'] ? date("Y-m-d", strtotime($row['sandate'])) : '-'), 1);
    $pdf->Cell($widths[4], 10, ($row['morning'] ?? '-'), 1);
    $pdf->Cell($widths[5], 10, ($row['evening'] ?? '-'), 1);
    $pdf->Cell($widths[6], 10, ($row['cowliter'] ?? '-'), 1);
    $pdf->Cell($widths[7], 10, ($row['bufliter'] ?? '-'), 1);
    $pdf->Cell($widths[8], 10, ($row['fat'] ?? '-'), 1);
    $pdf->Cell($widths[9], 10, ($row['snf'] ?? '-'), 1);
    $pdf->Ln();
}

// Summary Rows
$pdf->SetFont('Arial', 'B', 10);
$label_colspan_width = array_sum(array_slice($widths, 0, 8));

$pdf->Cell($label_colspan_width, 10, 'Total Liter', 1, 0, 'R');
$pdf->Cell($widths[8] + $widths[9], 10, $totalLiter . ' Ltr', 1, 0, 'C');
$pdf->Ln();

$pdf->Cell($label_colspan_width, 10, 'Average Fat / SNF', 1, 0, 'R');
$pdf->Cell($widths[8], 10, $avgFat, 1, 0, 'C');
$pdf->Cell($widths[9], 10, $avgSnf, 1, 0, 'C');
$pdf->Ln();


$pdf->Output('D', 'milk_entry_report.pdf');
?> 

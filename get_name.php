<?php
$conn = new mysqli("localhost", "root", "", "dairy_sanklan");

if (isset($_POST['accno'])) {
    $accno = $_POST['accno'];
    $stmt = $conn->prepare("SELECT sname, cow, bufalo FROM sabasad_master WHERE accno = ? LIMIT 1");
    $stmt->bind_param("i", $accno);
    $stmt->execute();
    $res = $stmt->get_result();

    $response = ['name' => '', 'animal' => ''];
    if ($row = $res->fetch_assoc()) {
        $response['name'] = $row['sname'];
        if ($row['bufalo'] === 'B') {
            $response['animal'] = 'Buffalo';
        } elseif ($row['cow'] === 'C') {
            $response['animal'] = 'Cow';
        }
    }

    echo json_encode($response);
}
?>

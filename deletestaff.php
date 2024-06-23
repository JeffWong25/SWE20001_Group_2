<?php
require_once("settings.php");

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $staffIds = json_decode($_POST['staffids'], true);

    if (!empty($staffIds)) {
        $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$dbconn) {
            echo json_encode(["status" => "error", "message" => "Connection failed: " . mysqli_connect_error()]);
            exit;
        }

        $staffIds = array_map('intval', $staffIds);
        $staffIdsList = implode(',', $staffIds);

        $sql = "DELETE FROM staff WHERE staffid IN ($staffIdsList)";
        $result = mysqli_query($dbconn, $sql);

        if ($result) {
            echo json_encode(["status" => "success"]);
        } else {
            echo json_encode(["status" => "error", "message" => "Error: " . mysqli_error($dbconn)]);
        }

        mysqli_close($dbconn);
    } else {
        echo json_encode(["status" => "error", "message" => "No staff selected"]);
    }
} else {
    echo json_encode(["status" => "error", "message" => "Invalid request method"]);
}
?>

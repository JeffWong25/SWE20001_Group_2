<?php
session_start();
if (isset($_SESSION["staff"]) && $_SESSION["accesslevel"] === 'manager') { 
    if (isset($_GET['item_id'])) {
        $item_id = $_GET['item_id'];
        require_once("settings.php");
        $dbconn = @mysqli_connect($host, $user, $pwd, $sql_db);
        if (!$dbconn) {
            echo json_encode(array('status' => 'error', 'message' => 'Connection failed: ' . mysqli_connect_error()));
            exit();
        }
        $sql = "DELETE FROM menu_items WHERE item_id = ?";
        $stmt = $dbconn->prepare($sql);
        $stmt->bind_param("i", $item_id);
        if ($stmt->execute()) {
            $file_path = __DIR__ . "\\product\\{$item_id}.php";
            if (file_exists($file_path)) {
                if (unlink($file_path)) {
                    echo json_encode(array('status' => 'success', 'message' => 'Item and corresponding page deleted successfully'));
                } else {
                    echo json_encode(array('status' => 'error', 'message' => 'Item deleted but failed to delete the corresponding page'));
                }
            }echo json_encode(array('status' => 'success', 'message' => 'Item deleted successfully (no corresponding page found)'));      
        } else {
            echo json_encode(array('status' => 'error', 'message' => 'Failed to delete item'));
        }
        $stmt->close();
        mysqli_close($dbconn);
    } else {
        echo json_encode(array('status' => 'error', 'message' => 'Invalid item ID'));
    }
} else {
    echo json_encode(array('status' => 'error', 'message' => 'Unauthorized'));
}
?>

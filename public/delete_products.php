<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $data = json_decode(file_get_contents('php://input'), true);
    $ids = implode(',', array_map('intval', $data['ids']));

    $db = new Database();
    $connection = $db->getConnection();
    $connection->query("DELETE FROM products WHERE id IN ($ids)");
}
?>

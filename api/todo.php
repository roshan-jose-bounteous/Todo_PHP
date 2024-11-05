<?php
session_start();
include 'db.php';

if (!isset($_SESSION['user_id'])) {
    die("Unauthorized");
}

$user_id = $_SESSION['user_id'];

switch ($_GET['action']) {
    case 'create':
        $task = $_POST['task'];
        $stmt = $conn->prepare("INSERT INTO todos (user_id, task) VALUES (?, ?)");
        $stmt->bind_param("is", $user_id, $task);
        $stmt->execute();
        echo $conn->insert_id;
        break;

    case 'read':
        $result = $conn->query("SELECT id, task FROM todos WHERE user_id = $user_id");
        echo json_encode($result->fetch_all(MYSQLI_ASSOC));
        break;

    case 'update':
        $id = $_POST['id'];
        $task = $_POST['task'];
        $stmt = $conn->prepare("UPDATE todos SET task = ? WHERE id = ? AND user_id = ?");
        $stmt->bind_param("sii", $task, $id, $user_id);
        $stmt->execute();
        echo "Task updated";
        break;

    case 'delete':
        $id = $_POST['id'];
        $stmt = $conn->prepare("DELETE FROM todos WHERE id = ? AND user_id = ?");
        $stmt->bind_param("ii", $id, $user_id);
        $stmt->execute();
        echo "Task deleted";
        break;
}

$conn->close();
?>

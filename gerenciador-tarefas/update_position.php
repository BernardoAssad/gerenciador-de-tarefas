<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gerenciador-tarefas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["taskOrder"])) {
    $taskOrder = $_POST["taskOrder"];

    foreach ($taskOrder as $position => $taskId) {
        $sql = "UPDATE tasks SET position = '$position' WHERE id = '$taskId'";
        $conn->query($sql);
    }

    echo "Posição atualizada com sucesso.";
} else {
    echo "Erro ao atualizar a posição.";
}

$conn->close();
?>

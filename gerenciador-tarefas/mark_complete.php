<?php

if (isset($_POST['taskId'])) {
    $taskId = $_POST['taskId'];

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "gerenciador-tarefas";

    $conn = new mysqli($servername, $username, $password, $dbname);

    if ($conn->connect_error) {
        die("Conexão falhou: " . $conn->connect_error);
    }

    $sql = "DELETE FROM tasks WHERE id = $taskId";

    if ($conn->query($sql) === TRUE) {
        echo "Tarefa marcada como concluída e excluída com sucesso!";
    } else {
        echo "Erro ao excluir tarefa: " . $conn->error;
    }

    $conn->close();
}
?>

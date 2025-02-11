<?php

$servername = "localhost";
$username = "root";
$password = "";
$dbname = "gerenciador-tarefas";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Falha na conexão: " . $conn->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["taskName"])) {
    $taskName = $_POST["taskName"];
    $taskDescription = $_POST["taskDescription"];
    $taskDate = date("Y-m-d");
    $taskDueDate = $_POST["taskDueDate"];
    $taskResponsible = $_POST["taskResponsible"];
    $taskColor = $_POST["taskColor"];

    $sql = "INSERT INTO tasks (name, description, date_added, date_max, responsible, color) VALUES ('$taskName', '$taskDescription', '$taskDate', '$taskDueDate', '$taskResponsible', '$taskColor')";

    if ($conn->query($sql) === TRUE) {
        echo "Tarefa adicionada com sucesso.";
    } else {
        echo "Erro ao adicionar tarefa: " . $conn->error;
    }
}

$sql = "SELECT id, name, description, date_added, date_max, responsible, color FROM tasks ORDER BY position";
$result = $conn->query($sql);
?>

<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="css/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Gerenciador de Tarefas</title>
</head>
<body>

<div class="container mt-5">
    <div class="task-form mt-3">
        <h1 class="fs-1 lead mb-5">Adicionar Nova Tarefa</h1>
        <form id="taskForm">
            <div class="form-group">
                <label for="taskName" class="lead">Nome da Tarefa:</label>
                <input type="text" class="form-control" name="taskName" required>
            </div>
            <div class="form-group">
                <label for="taskDescription" class="lead">Descrição:</label>
                <textarea class="form-control" name="taskDescription" rows="3"></textarea>
            </div>
            <div class="form-group">
                <label for="taskDueDate" class="lead">Data Máxima:</label>
                <input type="date" class="form-control" name="taskDueDate" required>
            </div>
            <div class="form-group">
                <label for="taskResponsible" class="lead">Responsável:</label>
                <input type="text" class="form-control" name="taskResponsible" required>
            </div>
            <div class="form-group">
                <label for="taskColor" class="lead">Cor da Tarefa:</label>
                <input type="color" class="form-control" name="taskColor" value="#ffffff" required>
            </div>
            <button type="submit" class="btn btn-primary mt-4 lead">Adicionar Tarefa</button>
        </form>
    </div>

    <div class="container mt-5">
        <div id="taskList" class="sortable-list">
            <?php
            if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) {
                    echo '<div class="task" data-task-id="' . $row["id"] . '" style="background-color: ' . $row["color"] . ';">' .
                        '<h4>' . $row["name"] . '</h4>' .
                        '<p>' . $row["description"] . '</p>' .
                        '<p>Data de Adição: ' . date('d/m/Y', strtotime($row["date_added"])) . '</p>' .
                        '<p>Data Máxima: ' . date('d/m/Y', strtotime($row["date_max"])) . '</p>' .
                        '<p>Responsável: ' . $row["responsible"] . '</p>' .
                        '<button class="btn btn-success mark-complete">Marcar como Concluído</button>' .
                        '</div>';
                }
            } else {
                echo '<p class="empty-message">Nenhuma tarefa encontrada.</p>';
            }
            ?>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
    <script src="js/script.js"></script>
</body>
</html>

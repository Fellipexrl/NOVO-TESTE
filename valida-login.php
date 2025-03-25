<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['usuario']) && isset($_POST['senha'])) {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];

        $servername = "localhost";
        $username = "seu_usuario";
        $password = "sua_senha";
        $dbname = "sistema_login";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM usuarios WHERE usuario = ? AND senha = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("ss", $usuario, $senha);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $_SESSION['usuario'] = $usuario;
            header("Location: painel.php");
            exit();
        } else {
            echo "Usuário ou senha incorretos.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Por favor, preencha todos os campos.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>
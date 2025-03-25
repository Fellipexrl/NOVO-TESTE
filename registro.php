<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['usuario']) && isset($_POST['senha']) && isset($_POST['email']) && isset($_POST['celular'])) {
        $usuario = $_POST['usuario'];
        $senha = $_POST['senha'];
        $email = $_POST['email'];
        $celular = $_POST['celular'];

        $servername = "localhost";
        $username = "seu_usuario";
        $password = "sua_senha";
        $dbname = "sistema_login";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM usuarios WHERE usuario = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $usuario);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            echo "O nome de usuário já está em uso. Por favor, escolha outro.";
        } else {
            $sql = "INSERT INTO usuarios (usuario, senha, email, celular) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ssss", $usuario, $senha, $email, $celular);

            if ($stmt->execute()) {
                header("Location: login.html");
                exit();
            } else {
                echo "Erro ao registrar o usuário. Por favor, tente novamente.";
            }
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
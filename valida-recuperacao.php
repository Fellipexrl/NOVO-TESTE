<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['email'])) {
        $email = $_POST['email'];

        $servername = "localhost";
        $username = "seu_usuario";
        $password = "sua_senha";
        $dbname = "sistema_login";

        $conn = new mysqli($servername, $username, $password, $dbname);

        if ($conn->connect_error) {
            die("Conexão falhou: " . $conn->connect_error);
        }

        $sql = "SELECT * FROM usuarios WHERE email = ?";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();

        if ($result->num_rows > 0) {
            $to = $email;
            $subject = "Recuperação de Senha";
            $message = "Clique no link a seguir para redefinir sua senha: http://seusite.com/redefinir-senha.php?email=" . urlencode($email);
            $headers = "From: no-reply@seusite.com";

            if (mail($to, $subject, $message, $headers)) {
                echo "Um e-mail de recuperação de senha foi enviado para " . htmlspecialchars($email) . ".";
            } else {
                echo "Falha ao enviar o e-mail de recuperação de senha.";
            }
        } else {
            echo "O e-mail fornecido não está registrado.";
        }

        $stmt->close();
        $conn->close();
    } else {
        echo "Por favor, insira um endereço de e-mail válido.";
    }
} else {
    echo "Método de requisição inválido.";
}
?>
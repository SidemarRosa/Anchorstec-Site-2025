<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    // Conexão com o banco de dados
    $host = "mysql.anchorstec.com.br"; // Geralmente algo como "mysql01.kinghost.net"
    $db = "anchorstec";
    $user = "anchorstec";
    $pass = "Alcalina1";

    try {
        // Cria a conexão com PDO
        $pdo = new PDO("mysql:host=$host;dbname=$db;charset=utf8", $user, $pass);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        // Obtém os dados do formulário
        $name = htmlspecialchars(trim($_POST['name']));
        $email = htmlspecialchars(trim($_POST['email']));
        $message = htmlspecialchars(trim($_POST['message']));

        // Validação básica
        if (empty($name) || empty($email) || empty($message)) {
            die("Todos os campos são obrigatórios.");
        }

        // Prepara e executa a inserção no banco com data e hora de envio
        $stmt = $pdo->prepare("INSERT INTO contatos (nome, email, mensagem, data_envio) VALUES (:name, :email, :message, NOW())");
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':email', $email);
        $stmt->bindParam(':message', $message);

        if ($stmt->execute()) {
            echo "Mensagem enviada com sucesso!";
        } else {
            echo "Erro ao salvar os dados no banco.";
        }
    } catch (PDOException $e) {
        echo "Erro na conexão com o banco de dados: " . $e->getMessage();
    }
}

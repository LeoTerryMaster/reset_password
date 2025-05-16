<?php
require 'vendor/autoload.php';
require 'config.php';
require 'db.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        exit('E-mail inválido.');
    }

    $stmt = $pdo->prepare("SELECT * FROM users WHERE email = ?");
    $stmt->execute([$email]);
    $user = $stmt->fetch();

    if (!$user) {
        exit('E-mail não encontrado.');
    }

    $token = bin2hex(random_bytes(32));
    $stmt = $pdo->prepare("INSERT INTO password_resets (email, token) VALUES (?, ?)");
    $stmt->execute([$email, $token]);

    $link = BASE_URL . "/reset_password.php?token=" . $token;

    $mail = new PHPMailer(true);
    try {
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USER;
        $mail->Password = SMTP_PASS;
        $mail->SMTPSecure = 'tls';
        $mail->Port = SMTP_PORT;

        $mail->setFrom(FROM_EMAIL, FROM_NAME);
        $mail->addAddress($email);
        $mail->isHTML(true);
        $mail->Subject = 'Recuperação de senha';
        $mail->Body = "
            <p>Olá, {$user['username']}!</p>
            <p>Para redefinir sua senha, clique no link abaixo:</p>
            <p><a href='$link'>$link</a></p>
            <p>Esse link expirará em 1 hora.</p>
        ";

        $mail->send();
        echo "E-mail de recuperação enviado com sucesso!";
    } catch (Exception $e) {
        echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
    }
}
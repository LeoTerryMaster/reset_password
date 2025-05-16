<?php
require 'db.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $token = $_POST['token'];
    $newPassword = password_hash($_POST['new_password'], PASSWORD_BCRYPT);

    $stmt = $pdo->prepare("SELECT email FROM password_resets WHERE token = ? AND created_at >= NOW() - INTERVAL 1 HOUR");
    $stmt->execute([$token]);
    $row = $stmt->fetch();

    if ($row) {
        $email = $row['email'];
        $stmt = $pdo->prepare("UPDATE users SET password = ? WHERE email = ?");
        $stmt->execute([$newPassword, $email]);
        $stmt = $pdo->prepare("DELETE FROM password_resets WHERE email = ?");
        $stmt->execute([$email]);
        echo "Senha alterada com sucesso!";
    } else {
        echo "Token inválido ou expirado.";
    }
} elseif (isset($_GET['token'])) {
    $token = $_GET['token'];
    ?>
    <form method="post" action="reset_password.php">
        <input type="hidden" name="token" value="<?= htmlspecialchars($token) ?>">
        <input type="password" name="new_password" placeholder="Nova senha" required>
        <button type="submit">Alterar senha</button>
    </form>
    <?php
} else {
    echo "Token inválido.";
}
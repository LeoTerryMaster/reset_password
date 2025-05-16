# 📧 Como instalar o PHPMailer com Composer no seu projeto PHP

Este guia mostra como instalar e usar o PHPMailer com Composer para enviar e-mails, como por exemplo, em sistemas de recuperação de senha, formulários de contato e notificações.

---

## ✅ Pré-requisitos

- PHP 7.2 ou superior  
- [Composer](https://getcomposer.org/download/) instalado  
- Acesso a terminal ou prompt de comando  
- Um servidor local (como XAMPP, Laragon, Wamp, etc.) ou servidor online  

---

## 📦 Instalação do PHPMailer

1. Acesse o diretório do seu projeto:

   ```bash
   cd /caminho/para/seu-projeto
   ```

2. Execute o seguinte comando para instalar o PHPMailer via Composer:

   ```bash
   composer require phpmailer/phpmailer
   ```

3. Isso criará automaticamente:

   - Uma pasta `vendor/`  
   - Um arquivo `composer.json`  
   - Um arquivo `vendor/autoload.php`  

---

## 🛠️ Exemplo de uso simples

```php
<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$mail = new PHPMailer(true);

try {
    // Configurações do servidor SMTP
    $mail->isSMTP();
    $mail->Host = 'smtp.seuservidor.com';
    $mail->SMTPAuth = true;
    $mail->Username = 'seu@email.com';
    $mail->Password = 'sua-senha';
    $mail->SMTPSecure = 'tls'; // ou 'ssl'
    $mail->Port = 587; // ou 465 para SSL

    // Remetente e destinatário
    $mail->setFrom('seu@email.com', 'Seu Nome');
    $mail->addAddress('destinatario@email.com');

    // Conteúdo do e-mail
    $mail->isHTML(true);
    $mail->Subject = 'Assunto do Email';
    $mail->Body    = '<h1>Este é um email de teste com PHPMailer</h1>';

    $mail->send();
    echo 'E-mail enviado com sucesso!';
} catch (Exception $e) {
    echo "Erro ao enviar e-mail: {$mail->ErrorInfo}";
}
```

---

## 🧩 Estrutura do projeto esperada

```
/seu-projeto
├── vendor/
│   └── autoload.php
├── composer.json
└── seu_arquivo.php
```

---

## ❓ Dicas úteis

- Para Gmail, habilite **apps menos seguros** ou use uma **senha de app** com autenticação em 2 fatores.  
- Sempre use `try/catch` para capturar erros de envio.  
- **Nunca exponha sua senha real em repositórios públicos!**  

---

## 🔗 Links úteis

- [Documentação oficial do PHPMailer](https://github.com/PHPMailer/PHPMailer)  
- [Guia oficial do Composer](https://getcomposer.org/doc/00-intro.md)  

---

Feito com 💙 por [TerryMaster & AI]

<?php
$pdo = new PDO("mysql:host=localhost;dbname=sua_db", "usuario", "senha", [
    PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
]);
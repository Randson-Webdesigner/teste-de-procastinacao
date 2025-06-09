<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $from = filter_var($_POST['yourEmail'], FILTER_VALIDATE_EMAIL);
    $to = filter_var($_POST['friendEmail'], FILTER_VALIDATE_EMAIL);

    if (!$from) {
        echo json_encode(["success" => false, "msg" => "Seu e-mail é inválido."]);
        exit;
    }

    // Se o campo de amigo estiver vazio, envie para o próprio usuário
    if (!$to) {
        $to = $from;
    }

    $mail = new PHPMailer(true);

    $mail->SMTPDebug = 2;
    $mail->Debugoutput = 'html';

    try {
        // Configuração do servidor SMTP
        $mail->isSMTP();
        $mail->Host = 'smtp.titan.email';
        $mail->SMTPAuth = true;
        $mail->Username = 'contato@radardorh.com.br';
        $mail->Password = '@Talentus2025';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Remetente e destinatário
        $mail->setFrom('contato@radardorh.com.br', 'Radar do RH');
        $mail->addAddress($to);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Teste de Procrastinação - Compartilhamento';
        $mail->Body = "Teste simples de envio de e-mail via PHPMailer.";

        $mail->send();
        echo json_encode(["success" => true, "msg" => "E-mail enviado com sucesso!"]);
    } catch (Exception $e) {
        echo json_encode(["success" => false, "msg" => "Erro ao enviar: {$mail->ErrorInfo}"]);
    }
} else {
    echo json_encode(["success" => false, "msg" => "Requisição inválida."]);
} 
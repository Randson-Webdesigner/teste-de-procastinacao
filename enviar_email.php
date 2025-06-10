<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

header('Content-Type: application/json');

// Função para registrar logs
function logDebug($message) {
    $logFile = 'email_resultado.log';
    $timestamp = date('Y-m-d H:i:s');
    file_put_contents($logFile, "[$timestamp] $message\n", FILE_APPEND);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $from = filter_var($_POST['yourEmail'], FILTER_VALIDATE_EMAIL);
    $to = filter_var($_POST['friendEmail'], FILTER_VALIDATE_EMAIL);

    logDebug("Iniciando envio de email");
    logDebug("Email de origem: " . $from);
    logDebug("Email de destino: " . $to);

    if (!$from) {
        logDebug("Erro: Email de origem inválido");
        echo json_encode(["success" => false, "msg" => "Seu e-mail é inválido."]);
        exit;
    }

    // Se o campo de amigo estiver vazio, envie para o próprio usuário
    if (!$to) {
        $to = $from;
        logDebug("Email de destino não informado, usando email de origem");
    }

    $mail = new PHPMailer(true);

    // Configurações de debug
    $mail->SMTPDebug = 3;
    $mail->Debugoutput = function($str, $level) {
        logDebug("SMTP Debug: $str");
    };

    try {
        // Configuração do servidor SMTP
        logDebug("Configurando servidor SMTP");
        $mail->isSMTP();
        $mail->Host = 'smtp.titan.email';
        $mail->SMTPAuth = true;
        $mail->Username = 'contato@radardorh.com.br';
        $mail->Password = '@Talentus2025';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;

        // Teste de conexão SMTP
        logDebug("Testando conexão SMTP");
        if (!$mail->smtpConnect()) {
            throw new Exception("Falha na conexão SMTP");
        }
        logDebug("Conexão SMTP estabelecida com sucesso");

        // Remetente e destinatário
        logDebug("Configurando remetente e destinatário");
        $mail->setFrom('contato@radardorh.com.br', 'Radar do RH');
        $mail->addAddress($to);

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Teste de Procrastinação - Compartilhamento';
        $mail->Body = "
            <html>
            <body>
                <h2>Resultado do Teste de Procrastinação</h2>
                <p>Olá,</p>
                <p>Este é o resultado do seu teste de procrastinação.</p>
                <p>Data e hora do envio: " . date('d/m/Y H:i:s') . "</p>
                <hr>
                <p>Mensagem enviada automaticamente pelo sistema Radar do RH.</p>
            </body>
            </html>";

        logDebug("Tentando enviar email");
        $mail->send();
        logDebug("Email enviado com sucesso!");

        echo json_encode(["success" => true, "msg" => "E-mail enviado com sucesso!"]);
    } catch (Exception $e) {
        logDebug("ERRO: " . $e->getMessage());
        echo json_encode(["success" => false, "msg" => "Erro ao enviar: {$mail->ErrorInfo}"]);
    }
} else {
    logDebug("Erro: Requisição inválida");
    echo json_encode(["success" => false, "msg" => "Requisição inválida."]);
} 
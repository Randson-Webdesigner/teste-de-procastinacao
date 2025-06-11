<?php
require 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

// Configuração de encoding
mb_internal_encoding('UTF-8');
header('Content-Type: application/json; charset=utf-8');

// Configuração do timezone
date_default_timezone_set('America/Sao_Paulo');

// Função para registrar logs
function logDebug($message) {
    $logFile = 'email_resultado.log';
    $timestamp = date('Y-m-d H:i:s');
    $formattedMessage = "[$timestamp] " . mb_convert_encoding($message, 'UTF-8') . "\n";
    file_put_contents($logFile, $formattedMessage, FILE_APPEND);
    error_log($formattedMessage);
}

// Log inicial para debug
logDebug("Script iniciado");
logDebug("Método da requisição: " . $_SERVER["REQUEST_METHOD"]);
logDebug("POST data: " . print_r($_POST, true));

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    try {
        // Verifica se os campos necessários existem
        if (!isset($_POST['yourEmail'])) {
            throw new Exception("Campo 'yourEmail' não encontrado na requisição");
        }

        $from = filter_var($_POST['yourEmail'], FILTER_VALIDATE_EMAIL);
        $to = isset($_POST['friendEmail']) ? filter_var($_POST['friendEmail'], FILTER_VALIDATE_EMAIL) : null;

        logDebug("Email de origem: " . ($from ?: "inválido"));
        logDebug("Email de destino: " . ($to ?: "não informado"));

        if (!$from) {
            throw new Exception("Email de origem inválido");
        }

        // Se o campo de amigo estiver vazio, envie para o próprio usuário
        if (!$to) {
            $to = $from;
            logDebug("Email de destino não informado, usando email de origem");
        }

        logDebug("Email de origem final (para PHPMailer): " . $from);
        logDebug("Email de destino final (para PHPMailer): " . $to);

        $mail = new PHPMailer(true);

        // Configurações de debug
        $mail->SMTPDebug = 3;
        $mail->Debugoutput = function($str, $level) {
            logDebug("SMTP Debug: " . mb_convert_encoding($str, 'UTF-8'));
        };

        // Configuração do servidor SMTP
        logDebug("Configurando servidor SMTP");
        $mail->isSMTP();
        $mail->Host = 'smtp.titan.email';
        $mail->SMTPAuth = true;
        $mail->Username = 'contato@radardorh.com.br';
        $mail->Password = '@Talentus2025';
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = 587;
        $mail->Timeout = 30;
        $mail->CharSet = 'UTF-8';

        // Teste de conexão SMTP
        logDebug("Testando conexão SMTP");
        if (!$mail->smtpConnect()) {
            throw new Exception("Falha na conexão SMTP");
        }
        logDebug("Conexão SMTP estabelecida com sucesso");

        // Remetente e destinatário
        logDebug("Configurando remetente e destinatário");
        $mail->setFrom('contato@radardorh.com.br', 'Radar do RH');
        $mail->addAddress($from, 'Você');

        // Adiciona o email do amigo, se for diferente do remetente e válido
        if ($to && $to !== $from) {
            $mail->addAddress($to, 'Para a Empresa ');
        }

        // Recebendo as variáveis do POST
        $userName = isset($_POST['userName']) ? $_POST['userName'] : 'Usuário';
        $grauTexto = isset($_POST['grauTexto']) ? $_POST['grauTexto'] : '';
        $resultDescription = isset($_POST['resultDescription']) ? $_POST['resultDescription'] : '';

        // Formatação da data e hora atual
        $dataHoraAtual = date('d/m/Y H:i:s');

        // Conteúdo do e-mail
        $mail->isHTML(true);
        $mail->Subject = 'Teste de Procrastinação - Radar do RH';
        $mail->Body = "
            <html>
            <head>
                <style>
                    body {
                        font-family: Arial, sans-serif;
                        line-height: 1.6;
                        color: #333333;
                        max-width: 600px;
                        margin: 0 auto;
                        padding: 20px;
                    }
                    .header {
                        background-color: #E63168;
                        color: white;
                        padding: 20px;
                        text-align: center;
                        border-radius: 5px 5px 0 0;
                    }
                    .content {
                        background-color: #ffffff;
                        padding: 20px;
                        border: 1px solid #e0e0e0;
                        border-radius: 0 0 5px 5px;
                    }
                    .footer {
                        text-align: center;
                        margin-top: 20px;
                        font-size: 12px;
                        color: #666666;
                    }
                    .button {
                        display: inline-block;
                        padding: 10px 20px;
                        background-color: #3498db;
                        color: white;
                        text-decoration: none;
                        border-radius: 5px;
                        margin: 20px 0;
                    }
                    .highlight {
                        background-color: #f8f9fa;
                        padding: 15px;
                        border-left: 4px solid #3498db;
                        margin: 20px 0;
                    }
                    .result-box {
                        background-color: #f1f8ff;
                        border: 1px solid #b3d7ff;
                        padding: 15px;
                        margin: 20px 0;
                        border-radius: 5px;
                    }

                    p{
                        font-size: 16px;
                    }
                    
                </style>
            </head>
            <body>
                <div class='header'>
                    <h1>Radar do RH</h1>
                    <p>Teste de Procrastinação</p>
                </div>
                
                <div class='content'>
                    <h2>Olá, " . htmlspecialchars($userName) . "!</h2>
                    
                    <p>Recebemos seu resultado do Teste de Procrastinação. Este é um momento importante para refletir sobre seus hábitos e identificar oportunidades de melhoria.</p>
                    
                    <div class='highlight'>
                        <p><strong>Data e hora do teste:</strong> " . $dataHoraAtual . "</p>
                        <p><strong>Status:</strong> Análise Concluída</p>
                    </div>

                    <div class='result-box'>
                        <h3>Seu Resultado</h3>
                        <p><strong>Grau de Procrastinação:</strong> " . htmlspecialchars($grauTexto) . "</p>
                        <p>" . htmlspecialchars($resultDescription) . "</p>
                    </div>

                    <p>Algumas dicas para melhorar sua produtividade:</p>
                    <ul>
                        <li>Estabeleça metas claras e realistas</li>
                        <li>Divida tarefas grandes em partes menores</li>
                        <li>Use técnicas de gerenciamento de tempo</li>
                        <li>Elimine distrações durante o trabalho</li>
                    </ul>

                    <p>Lembre-se: A procrastinação é um hábito que pode ser modificado com dedicação e prática.</p>
                </div>

                <div class='footer'>
                    <p>Este é um email automático, por favor não responda.</p>
                    <p>© " . date('Y') . " Radar do RH - Todos os direitos reservados</p>
                    <p>Para mais informações, visite: <a href='https://radardorh.com.br'>radardorh.com.br</a></p>
                </div>
            </body>
            </html>";

        // Versão em texto plano para clientes que não suportam HTML
        $mail->AltBody = "
            Radar do RH - Teste de Procrastinação
            
            Olá, " . $userName . "!
            
            Recebemos seu resultado do Teste de Procrastinação. Este é um momento importante para refletir sobre seus hábitos e identificar oportunidades de melhoria.
            
            Data e hora do teste: " . $dataHoraAtual . "
            Status: Análise Concluída
            
            Seu Resultado:
            Grau de Procrastinação: " . $grauTexto . "
            " . $resultDescription . "
            
            Dicas para melhorar sua produtividade:
            - Estabeleça metas claras e realistas
            - Divida tarefas grandes em partes menores
            - Use técnicas de gerenciamento de tempo
            - Elimine distrações durante o trabalho
            
            Lembre-se: A procrastinação é um hábito que pode ser modificado com dedicação e prática.
            
            Para mais informações, visite: https://www.radardorh.com.br
            
            © " . date('Y') . " Radar do RH - Todos os direitos reservados
            Este é um email automático, por favor não responda.";

        logDebug("Tentando enviar email");
        $mail->send();
        logDebug("Email enviado com sucesso!");

        echo json_encode([
            "success" => true, 
            "msg" => "E-mail enviado com sucesso!"           
        ], JSON_UNESCAPED_UNICODE);
    } catch (Exception $e) {
        $errorMessage = "Erro ao enviar e-mail: " . $e->getMessage();
        logDebug("ERRO: " . $errorMessage);
        echo json_encode([
            "success" => false, 
            "msg" => $errorMessage,
            "details" => "Por favor, tente novamente mais tarde ou entre em contato com o suporte."
        ], JSON_UNESCAPED_UNICODE);
    }
} else {
    logDebug("Erro: Requisição inválida - Método " . $_SERVER["REQUEST_METHOD"]);
    echo json_encode([
        "success" => false, 
        "msg" => "Requisição inválida.",
        "details" => "O método de requisição deve ser POST"
    ], JSON_UNESCAPED_UNICODE);
} 
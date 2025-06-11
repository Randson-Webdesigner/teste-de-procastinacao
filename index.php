<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/png" href="img/favicon.png">
    <title>Teste de Procrastinação</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="container">
        <img class="logo" src="img/lg.jpg" width="300" alt="Logo" class="logo"><br>
        <div class="start-container" id="start-container">
            <h1>Bem-vindo ao Teste de Procrastinação</h1>
            <p class="description">Digite seu nome para começar:</p>
            <input type="text" id="user-name" placeholder="Seu nome" autocomplete="off" />
            <button id="start-btn">Começar</button>
        </div>
        <!-- Tela de instruções -->
        <div class="instructions-container" id="instructions-container" style="display: none;">
            <h2>Instruções</h2>
            <p class="description">
                    Você sofre de Procrastinação? Faça o teste e descubra
                    (duração: 3 minutos)<br><br>
                <strong>"Seu primeiro passo para superar a procrastinação é ser honesto consigo mesmo."</strong>
            </p>
            <div style="display: flex; gap: 1rem; justify-content: center;">
                <button id="back-to-name"></button>             
                <button id="next-to-test">Vamos lá!</button>
            </div>
        </div>
        <!-- Teste de procrastinação -->
        <div class="test-container" id="test-container" style="display: none;">
            <h1>Teste de Procrastinação</h1>
            <p class="description">Responda as perguntas abaixo para descobrir seu nível de procrastinação.</p>
            <div id="progress-bar-container">
                <div id="progress-bar"></div>
                
            </div>
            <div id="question-individual-container">
                <!-- Pergunta individual será inserida aqui via JavaScript -->
            </div>
            <div id="question-nav" style="display: flex; gap: 1rem; justify-content: center; margin-top: 2rem;">
                <button id="prev-question"></button>
                <button id="next-question">Avançar</button>
            </div>
            <div class="result-container" style="display: none;">
                <div class="result-box">
                    <img src="img/favicon.png" Avatar" class="result-avatar">
                    <div class="result-message">
                        <h2 id="result-title">Seu Resultado</h2>
                        <div id="result-highlight"></div>
                        <div id="result-description"></div>
                        <div id="result-extra"></div>
                        <button id="result-action-btn">COMPARTILHAR TESTE DE PROCRASTINAÇÃO</button>
                    </div>
                </div>
            </div>
            <!-- Modal de Compartilhamento -->
            <div id="share-modal" class="modal" style="display: none;">
                <div class="modal-content">
                    <span class="close-modal" id="close-share-modal">&times;</span>
                    <h3>Compartilhar Teste de Procrastinação</h3>
                    <form id="share-form">
                        <label for="your-email">Seu e-mail</label>
                        <input type="email" id="your-email" name="your-email" required placeholder="seu@email.com">
                        <label for="friend-email">E-mail para compartilhar</label>
                        <input type="email" id="friend-email" name="friend-email" placeholder="empresa@email.com">
                        <button type="submit" id="send-share">Compartilhar</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="script.js"></script>
</body>
</html> 
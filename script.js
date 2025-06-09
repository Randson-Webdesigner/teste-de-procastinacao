let userName = '';

const questions = [
    { question: "Eu adio as coisas e elas acabam não sendo feitas" },
    { question: "Enquanto eu procrastino, eu continuo pensando sobre o que eu deveria estar fazendo" },
    { question: "Outras pessoas ficam me cobrando por procrastinar" },
    { question: "Minha procrastinação faz com que eu me atrase para muitas coisas" },
    { question: "Eu invento desculpas para não começar" },
    { question: "Eu evito situações e tarefas estressantes" },
    { question: "Quando uma tarefa me estressa, eu espero até o último minuto para fazê-la" },
    { question: "Eu evito más notícias" },
    { question: "Eu ignoro tarefas desagradáveis até o último minuto" },
    { question: "Eu evito informações que eu não quero realmente ouvir" },
    { question: "Eu digo para mim mesmo que tenho bastante tempo, mesmo quando isso não é verdade" },
    { question: "Eu tenho problemas para me organizar" },
    { question: "Eu subestimo quanto tempo irei demorar para fazer as coisas" },
    { question: "Eu superestimo quanto tempo tenho disponível para fazer as coisas" },
    { question: "Eu adio tarefas porque não consigo me concentrar" },
    { question: "Eu hesito porque tenho medo de cometer um erro ou falhar" },
    { question: "Eu evito fazer coisas que as outras pessoas possam não gostar" },
    { question: "Eu evito coisas que não tenho certeza sobre como fazer" },
    { question: "Dúvidas sobre minha capacidade e incerteza me fazem adiar tarefas difíceis" },
    { question: "Eu não estou sempre certo sobre que decisão tomar, então eu adio o máximo possível" },
    { question: "Eu odeio que me digam o que fazer" },
    { question: "Eu procrastino intencionalmente quando outros me dizem o que fazer" },
    { question: "Eu mostro para as outras pessoas o meu desprazer ao 'me enrolar'" },
    { question: "Eu concordo em fazer coisas para os outros, mas depois eu me arrependo" },
    { question: "É difícil, para mim, dizer não a outras pessoas" },
    { question: "Eu assumo mais do que eu consigo administrar" },
    { question: "Se eu não consigo fazer algo perfeitamente, eu nem começo a fazer" },
    { question: "Eu me sinto sobrecarregado quando há muito para fazer" },
    { question: "Ou eu dou o meu máximo ou eu adio as coisas totalmente" },
    { question: "Às vezes, trabalho tão arduamente que eu me esgoto" },
    { question: "Eu fico buscando diversão ao invés de trabalhar" },
    { question: "Quando eu não me sinto motivado, eu não ajo" },
    { question: "É difícil, para mim, parar de fazer algo divertido ou relaxante e retomar as tarefas" },
    { question: "Eu evito tarefas desagradáveis até que alguém as faça por mim" },
    { question: "Sentiu medo, como se algo horrível fosse acontecer?" }
].map(q => ({
    ...q,
    options: [
        { value: 1, text: "Nunca" },
        { value: 2, text: "Raramente" },
        { value: 3, text: "Às vezes" },
        { value: 4, text: "Frequentemente" },
        { value: 5, text: "Sempre" }
    ]
}));

const results = {
    low: {
        title: "Baixo Nível de Procrastinação",
        description: "Você demonstra boa capacidade de gerenciamento de tempo e responsabilidade. Continue mantendo essa organização e disciplina!"
    },
    medium: {
        title: "Nível Moderado de Procrastinação",
        description: "Você tem alguns hábitos de procrastinação, mas ainda mantém um bom controle sobre suas tarefas. Considere trabalhar em técnicas de gestão de tempo para melhorar ainda mais."
    },
    high: {
        title: "Alto Nível de Procrastinação",
        description: "Você tende a procrastinar frequentemente. Considere buscar estratégias para melhorar sua produtividade e gerenciamento de tempo, como a técnica Pomodoro ou a criação de listas de tarefas."
    }
};

let currentQuestion = 0;
let answers = Array(questions.length).fill(null);

function updateProgressBar() {
    const progressBar = document.getElementById('progress-bar');
    const total = questions.length;
    const atual = currentQuestion + 1;
    const percent = Math.round((atual / total) * 100);
    progressBar.style.width = percent + '%';
}

function renderQuestion(index) {
    const container = document.getElementById('question-individual-container');
    container.innerHTML = '';
    const q = questions[index];
    const questionDiv = document.createElement('div');
    questionDiv.className = 'question';
    const questionTitle = document.createElement('h3');
    questionTitle.textContent = `${index + 1}. ${q.question}`;
    questionDiv.appendChild(questionTitle);
    const optionsDiv = document.createElement('div');
    optionsDiv.className = 'options';
    q.options.forEach((option, i) => {
        const optionLabel = document.createElement('label');
        optionLabel.className = 'option';
        const radio = document.createElement('input');
        radio.type = 'radio';
        radio.name = `question-${index}`;
        radio.value = option.value;
        if (answers[index] === option.value) radio.checked = true;
        radio.onclick = () => {
            answers[index] = option.value;
        };
        optionLabel.appendChild(radio);
        optionLabel.appendChild(document.createTextNode(option.text));
        optionsDiv.appendChild(optionLabel);
    });
    questionDiv.appendChild(optionsDiv);
    container.appendChild(questionDiv);
    updateProgressBar();
}

function calculateResult(answers) {
    const total = answers.reduce((sum, value) => sum + value, 0);
    const average = total / answers.length;
    if (average <= 2) return 'low';
    if (average <= 3.5) return 'medium';
    return 'high';
}

function showResult(result) {
    document.getElementById('question-individual-container').style.display = 'none';
    document.getElementById('question-nav').style.display = 'none';
    const resultContainer = document.querySelector('.result-container');
    const resultTitle = document.getElementById('result-title');
    const resultHighlight = document.getElementById('result-highlight');
    const resultDescription = document.getElementById('result-description');
    const resultExtra = document.getElementById('result-extra');
    const resultActionBtn = document.getElementById('result-action-btn');

    // Ocultar a frase de instrução
    const descriptionPhrase = document.querySelector('.test-container .description');
    if (descriptionPhrase) descriptionPhrase.style.display = 'none';

    let grauTexto = '';
    if (result === 'low') grauTexto = 'procrastinação de grau leve';
    else if (result === 'medium') grauTexto = 'procrastinação de grau moderado';
    else grauTexto = 'procrastinação de grau elevado';

    resultTitle.textContent = 'Seu Resultado';
    resultHighlight.innerHTML = `<b>${userName}</b>, suas respostas apontam para <b>${grauTexto}</b>.`;
    resultDescription.textContent = results[result].description;
    resultExtra.innerHTML = `São cada vez mais as pessoas que desenvolvem estes sintomas, onde você ainda consegue dar um jeito de fazer as coisas, mas o estresse pode estar lhe atingindo. <br><br> Que tal buscar estratégias para melhorar sua produtividade e bem-estar?`;
    resultContainer.style.display = 'block';

    // Abrir modal ao clicar no botão de compartilhar
    resultActionBtn.onclick = () => {
        document.getElementById('share-modal').style.display = 'flex';
    };

    // Fechar modal
    document.getElementById('close-share-modal').onclick = () => {
        document.getElementById('share-modal').style.display = 'none';
    };

    // Fechar modal ao clicar fora do conteúdo
    window.onclick = function(event) {
        const modal = document.getElementById('share-modal');
        if (event.target === modal) {
            modal.style.display = 'none';
        }
    };

    // Simular envio do formulário
    document.getElementById('share-form').onsubmit = function(e) {
        e.preventDefault();
        const yourEmail = document.getElementById('your-email').value;
        const friendEmail = document.getElementById('friend-email').value;
        document.getElementById('share-modal').style.display = 'none';
        this.reset();
    };
}

function updateNavButtons() {
    const prevBtn = document.getElementById('prev-question');
    const nextBtn = document.getElementById('next-question');
    prevBtn.disabled = currentQuestion === 0;
    if (currentQuestion === questions.length - 1) {
        nextBtn.textContent = 'Finalizar';
    } else {
        nextBtn.textContent = 'Avançar';
    }
}

function initializeTestIndividual() {
    currentQuestion = 0;
    answers = Array(questions.length).fill(null);
    document.getElementById('question-individual-container').style.display = 'block';
    document.getElementById('question-nav').style.display = 'flex';
    document.querySelector('.result-container').style.display = 'none';
    renderQuestion(currentQuestion);
    updateNavButtons();
    document.getElementById('prev-question').onclick = () => {
        if (currentQuestion > 0) {
            currentQuestion--;
            renderQuestion(currentQuestion);
            updateNavButtons();
        }
    };
    document.getElementById('next-question').onclick = () => {
        if (answers[currentQuestion] === null) {
            alert('Por favor, selecione uma opção antes de avançar.');
            return;
        }
        if (currentQuestion < questions.length - 1) {
            currentQuestion++;
            renderQuestion(currentQuestion);
            updateNavButtons();
        } else {
            // Finalizar
            if (answers.includes(null)) {
                alert('Por favor, responda todas as perguntas.');
                return;
            }
            const result = calculateResult(answers);
            showResult(result);
        }
    };
}

document.addEventListener('DOMContentLoaded', () => {
    const startBtn = document.getElementById('start-btn');
    const startContainer = document.getElementById('start-container');
    const instructionsContainer = document.getElementById('instructions-container');
    const testContainer = document.getElementById('test-container');
    const userNameInput = document.getElementById('user-name');
    const backToNameBtn = document.getElementById('back-to-name');
    const nextToTestBtn = document.getElementById('next-to-test');

    startBtn.onclick = () => {
        const name = userNameInput.value.trim();
        if (name.length === 0) {
            alert('Por favor, digite seu nome para começar o teste.');
            return;
        }
        userName = name;
        startContainer.style.display = 'none';
        instructionsContainer.style.display = 'block';
    };

    backToNameBtn.onclick = () => {
        instructionsContainer.style.display = 'none';
        startContainer.style.display = 'block';
    };

    nextToTestBtn.onclick = () => {
        instructionsContainer.style.display = 'none';
        testContainer.style.display = 'block';
        initializeTestIndividual();
    };
}); 
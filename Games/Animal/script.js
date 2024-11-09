const fichasDisplay = document.getElementById('fichas');
const girarButton = document.getElementById('girar');
const betSound = document.getElementById('bet-sound');
const win5xSound = document.getElementById('win-5x-sound');
const win50xSound = document.getElementById('win-50x-sound');
const muteButton = document.getElementById('mute-button');
const backgroundMusic = document.getElementById('background-music');  // Música de fundo

let fichas = 10;
let vitórias = 0;
let animais = ['🐶', '🐱', '🐸', '🦁', '🐯', '🐰'];

// Definir o volume da música de fundo
backgroundMusic.volume = 0.5; // Volume ajustável (0 a 1)

// Função para garantir que a música começa a tocar ao carregar a página
window.onload = () => {
  if (!backgroundMusic.paused) {
    backgroundMusic.play();  // Tocar a música automaticamente se não estiver pausada
  }
};

// Função para gerar o resultado das roletas com probabilidades ajustadas
function gerarResultado() {
  const reels = document.querySelectorAll('.reel');
  let erroProbabilidade = 0.75;
  let vitoria5xProbabilidade = 0.23;
  let jackpot50xProbabilidade = 0.02;

  if (vitórias >= 2) {
    vitoria5xProbabilidade = 0.000001;
    jackpot50xProbabilidade = 0.000001;
  }

  let resultado;
  const sorteio = Math.random();

  if (sorteio < jackpot50xProbabilidade) {
    resultado = [randAnimal(), randAnimal(), randAnimal()];
    return iniciarRotacao(reels, resultado, "50x");
  } else if (sorteio < vitoria5xProbabilidade + jackpot50xProbabilidade) {
    resultado = [randAnimal(), randAnimal(), randAnimal()];
    return iniciarRotacao(reels, resultado, "5x");
  } else if (Math.random() > erroProbabilidade) {
    resultado = [randAnimal(), randAnimal(), randAnimal()];
    return iniciarRotacao(reels, resultado, "perda");
  } else {
    resultado = [randAnimal(), randAnimal(), randAnimal()];
    return iniciarRotacao(reels, resultado, "perda");
  }
}

// Função para gerar um animal aleatório
function randAnimal() {
  return animais[Math.floor(Math.random() * animais.length)];
}

// Função para iniciar a rotação das roletas
function iniciarRotacao(reels, resultado, premio) {
  let animando = true;
  let interval = 100;
  let count = 0;
  let resultadoFinal = [];

  const spinReels = () => {
    count++;

    reels.forEach(reel => {
      const slots = reel.querySelectorAll('.slot');
      slots.forEach(slot => {
        slot.style.transform = `translateY(-100px)`;
      });
      setTimeout(() => {
        const firstSlot = reel.querySelector('.slot');
        reel.appendChild(firstSlot);
        firstSlot.style.transform = `translateY(0)`;
      }, interval);
    });

    if (count > 20) {
      animando = false;
      mostrarResultado(reels, resultado, premio);
    }
  };

  const spinInterval = setInterval(() => {
    if (animando) {
      spinReels();
    } else {
      clearInterval(spinInterval);
    }
  }, interval);
}

// Função para mostrar o resultado após a rotação
function mostrarResultado(reels, resultado, premio) {
  reels[0].querySelectorAll('.slot')[0].textContent = resultado[0];
  reels[1].querySelectorAll('.slot')[0].textContent = resultado[1];
  reels[2].querySelectorAll('.slot')[0].textContent = resultado[2];

  verificarResultado(resultado, premio);
}

// Função para verificar o resultado e aplicar o prêmio
function verificarResultado(resultado, premio) {
  let premioMultiplicador = 0;

  if (premio === "50x") {
    premioMultiplicador = 50;
    fichas += 50;
    win50xSound.play();
    alert('Você ganhou o Jackpot 50x! 🎉');
    vitórias++;
  } else if (premio === "5x") {
    premioMultiplicador = 5;
    fichas += 5;
    win5xSound.play();
    alert('Você ganhou o Jackpot 5x! 🎉');
    vitórias++;
  } else {
    fichas -= 1;
    if (fichas < 0) fichas = 0;
    betSound.play();
    alert('Você perdeu! 😞');
  }

  fichasDisplay.textContent = fichas;
}

// Evento de clique no botão "Girar"
girarButton.addEventListener('click', () => {
  const creditosEscolhidos = parseInt(creditosInput.value);

  if (fichas >= creditosEscolhidos && creditosEscolhidos >= 1 && creditosEscolhidos <= 10) {
    fichas -= creditosEscolhidos;
    fichasDisplay.textContent = fichas;
    betSound.play();
    gerarResultado();
  } else {
    alert('Créditos insuficientes ou valor inválido!');
  }
});

// Lógica para tocar música em loop e controlar o mute/desmute
let isMuted = false;
muteButton.addEventListener('click', () => {
  if (isMuted) {
    backgroundMusic.muted = false;
    muteButton.textContent = "Mutar Música";
  } else {
    backgroundMusic.muted = true;
    muteButton.textContent = "Desmutar Música";
  }
  isMuted = !isMuted;  // Alterna entre mutar e desmutar
});

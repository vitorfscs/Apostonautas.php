let slideIndex = 0;

function moveSlide(n) {
    const slides = document.querySelectorAll(".carousel img");
    const totalSlides = slides.length;

    slideIndex += n;

    if (slideIndex >= totalSlides) {
        slideIndex = 0;
    } else if (slideIndex < 0) {
        slideIndex = totalSlides - 1;
    }

    // Ajusta o movimento com base na largura da imagem e na margem entre elas
    const slideWidth = slides[0].clientWidth;
    const newTransform = `translateX(${-slideIndex * (slideWidth * 0.8)}px)`; // Mostra 20% da próxima imagem

    document.querySelector(".carousel").style.transform = newTransform;
}

// Abre o popup de login
document.getElementById("loginBtn").addEventListener("click", function() {
    document.getElementById("loginPopup").style.display = "flex";
});

// Fecha o popup de login
document.getElementById("closeLoginPopup").addEventListener("click", function() {
    document.getElementById("loginPopup").style.display = "none";
});

// Abre o popup de cadastro ao clicar no link "Cadastre-se"
document.getElementById("goToSignup").addEventListener("click", function() {
    document.getElementById("loginPopup").style.display = "none";
    document.getElementById("signupPopup").style.display = "flex";
});

// Fecha o popup de cadastro
document.getElementById("closeSignupPopup").addEventListener("click", function() {
    document.getElementById("signupPopup").style.display = "none";
});

// Volta para o popup de login ao clicar no link "Entrar"
document.getElementById("goToLogin").addEventListener("click", function() {
    document.getElementById("signupPopup").style.display = "none";
    document.getElementById("loginPopup").style.display = "flex";
});

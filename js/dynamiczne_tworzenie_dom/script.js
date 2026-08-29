// UNIWERSALNY WZORZEC: Tworzenie elementu <img> i dodawanie do DOM

const galeria = document.getElementById("galeria");
const sciezkaObrazka = "smok.png";

// 1. Stworzenie nowego elementu <img> w pamięci
const nowyObraz = document.createElement("img");

// 2. Ustawienie atrybutów i klasy CSS
nowyObraz.src = sciezkaObrazka;
nowyObraz.alt = sciezkaObrazka;
nowyObraz.classList.add("miniatury");

// 3. Wstawienie elementu na stronę
galeria.appendChild(nowyObraz);
// UNIWERSALNY WZORZEC: Dynamiczne tworzenie i wstawianie elementu w DOM
// -----------------------------------------------------------------------------

// --- KROK 1: Stworzenie nowego elementu w pamięci ---
// [ZOBACZ W README: SEC-1]
const nowyObraz = document.createElement("img");

// --- KROK 2: Ustawienie atrybutów źródłowych i klasy CSS ---
// [ZOBACZ W README: SEC-2]
const sciezkaObrazka = "smok.png"; // Przyjmujemy dane z poprzedniego kroku
nowyObraz.src = sciezkaObrazka;
nowyObraz.alt = sciezkaObrazka;
nowyObraz.classList.add("miniatury");

// --- KROK 3: Wklejenie gotowego elementu do galerii na stronie ---
// [ZOBACZ W README: SEC-3]
const galeria = document.querySelector("section");
galeria.appendChild(nowyObraz);
// UNIWERSALNY WZORZEC: Skrypt (część 1) — walidacja danych wejściowych
// -----------------------------------------------------------------------------

// --- KROK 1: Pobranie wartości z pola i elementu wynikowego ---
// [ZOBACZ W README: SEC-1]
let liczbaDziesietna = document.getElementById('liczba').value;
let wynikElement = document.getElementById('wynik');

// --- KROK 2: Sprawdzenie poprawności wpisanej wartości ---
// [ZOBACZ W README: SEC-2]
if (liczbaDziesietna === "" || isNaN(liczbaDziesietna)) {
    wynikElement.innerHTML = "Proszę wpisać poprawną liczbę!";
    return;
}

// --- KROK 3: Przygotowanie liczby do konwersji ---
// [ZOBACZ W README: SEC-3]
let liczba = Math.floor(Math.abs(Number(liczbaDziesietna)));

// UNIWERSALNY WZORZEC: Skrypt (część 1) — pobieranie danych i kwota całkowita
// -----------------------------------------------------------------------------

// --- KROK 1: Pobranie danych ze wszystkich kontrolek formularza ---
// [ZOBACZ W README: SEC-1]
const kursReact = document.getElementById('react').checked;
const kursJS = document.getElementById('js').checked;
const liczbaRat = parseInt(document.getElementById('raty').value);
const miasto = document.getElementById('miasto').value;
const wynik = document.getElementById('wynik');

// --- KROK 2: Ustalenie cen poszczególnych kursów ---
// [ZOBACZ W README: SEC-2]
const cenaReact = 5000;
const cenaJS = 3000;

// --- KROK 3: Zsumowanie ceny wybranych kursów ---
// [ZOBACZ W README: SEC-3]
let kwotaCalkowita = 0;
if (kursReact) kwotaCalkowita += cenaReact;
if (kursJS) kwotaCalkowita += cenaJS;

// --- KROK 4: Sprawdzenie, czy wybrano jakikolwiek kurs ---
// [ZOBACZ W README: SEC-4]
if (kwotaCalkowita === 0) {
    wynik.textContent = "Wybierz przynajmniej jeden kurs.";
    return;
}

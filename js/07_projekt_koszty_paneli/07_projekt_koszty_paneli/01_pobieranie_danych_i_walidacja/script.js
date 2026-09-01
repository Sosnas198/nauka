// UNIWERSALNY WZORZEC: Skrypt (część 1) — pobieranie danych z pól i walidacja
// -----------------------------------------------------------------------------

// --- KROK 1: Pobranie wartości z pól formularza ---
// [ZOBACZ W README: SEC-1]
const szerokosc = parseFloat(document.getElementById('szerokosc').value);
const dlugosc = parseFloat(document.getElementById('dlugosc').value);
const typPanelu = document.querySelector('input[name="typ_panelu"]:checked');
const wynik = document.getElementById('wynik');

// --- KROK 2: Sprawdzenie poprawności wszystkich danych naraz ---
// [ZOBACZ W README: SEC-2]
if (!szerokosc || !dlugosc || !typPanelu || szerokosc <= 0 || dlugosc <= 0) {
    wynik.textContent = "Wprowadź poprawne dane.";
    return;
}

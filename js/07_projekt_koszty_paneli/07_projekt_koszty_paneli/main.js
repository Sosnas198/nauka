// POŁĄCZONY WZORZEC (Moduły 01–03)
// -----------------------------------------------------------------------------
// UWAGA: w oryginalnym kodzie źródłowym (koszty.html) ta funkcja znajduje się
// bezpośrednio wewnątrz znacznika <script> w treści strony i pozostaje tam
// bez zmian. Ten plik to wyłącznie referencyjna, połączona wersja modułów.

function Oblicz() {
    // Moduł 01: [SEC-1] Pobranie wartości z pól formularza
    const szerokosc = parseFloat(document.getElementById('szerokosc').value);
    const dlugosc = parseFloat(document.getElementById('dlugosc').value);
    const typPanelu = document.querySelector('input[name="typ_panelu"]:checked');
    const wynik = document.getElementById('wynik');

    // Moduł 01: [SEC-2] Sprawdzenie poprawności wszystkich danych naraz
    if (!szerokosc || !dlugosc || !typPanelu || szerokosc <= 0 || dlugosc <= 0) {
        wynik.textContent = "Wprowadź poprawne dane.";
        return;
    }

    // Moduł 02: [SEC-1] Obliczenie pola powierzchni pomieszczenia
    const pole = szerokosc * dlugosc;

    // Moduł 02: [SEC-2] Ustalenie kosztu za metr kwadratowy zależnie od typu panelu
    let kosztZaM2 = 0;
    if (typPanelu.value === "laminowane") kosztZaM2 = 12;
    else if (typPanelu.value === "winylowe") kosztZaM2 = 14;
    else if (typPanelu.value === "deska") kosztZaM2 = 18;

    // Moduł 02: [SEC-3] Obliczenie całkowitego kosztu montażu
    const koszt = pole * kosztZaM2;

    // Moduł 03: [SEC-1] Zbudowanie i wyświetlenie komunikatu z wynikiem
    wynik.textContent = `Pole powierzchni pomieszczenia: ${pole} m², koszt montażu ${koszt} zł`;
}

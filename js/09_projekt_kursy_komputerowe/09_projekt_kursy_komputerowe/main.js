// POŁĄCZONY WZORZEC (Moduły 01–03)
// -----------------------------------------------------------------------------
// UWAGA: w oryginalnym kodzie źródłowym (raty.html) ta funkcja znajduje się
// bezpośrednio wewnątrz znacznika <script> w treści strony i pozostaje tam
// bez zmian. Ten plik to wyłącznie referencyjna, połączona wersja modułów.

function Oblicz() {
    // Moduł 01: [SEC-1] Pobranie danych ze wszystkich kontrolek formularza
    const kursReact = document.getElementById('react').checked;
    const kursJS = document.getElementById('js').checked;
    const liczbaRat = parseInt(document.getElementById('raty').value);
    const miasto = document.getElementById('miasto').value;
    const wynik = document.getElementById('wynik');

    // Moduł 01: [SEC-2] Ustalenie cen poszczególnych kursów
    const cenaReact = 5000;
    const cenaJS = 3000;

    // Moduł 01: [SEC-3] Zsumowanie ceny wybranych kursów
    let kwotaCalkowita = 0;
    if (kursReact) kwotaCalkowita += cenaReact;
    if (kursJS) kwotaCalkowita += cenaJS;

    // Moduł 01: [SEC-4] Sprawdzenie, czy wybrano jakikolwiek kurs
    if (kwotaCalkowita === 0) {
        wynik.textContent = "Wybierz przynajmniej jeden kurs.";
        return;
    }

    // Moduł 02: [SEC-1] Sprawdzenie poprawności liczby rat
    if (isNaN(liczbaRat) || liczbaRat < 1) {
        wynik.textContent = `Kurs odbędzie się w ${miasto}. Koszt całkowity: ${kwotaCalkowita} zł.`;
        return;
    }

    // Moduł 03: [SEC-1] Obliczenie wysokości jednej raty
    const rata = (kwotaCalkowita / liczbaRat).toFixed(2);

    // Moduł 03: [SEC-2] Zbudowanie i wyświetlenie pełnego komunikatu
    wynik.textContent = `Kurs odbędzie się w ${miasto}. Koszt całkowity: ${kwotaCalkowita} zł. Płacisz ${liczbaRat} rat po ${rata} zł`;
}

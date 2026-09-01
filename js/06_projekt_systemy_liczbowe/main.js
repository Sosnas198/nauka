// POŁĄCZONY WZORZEC (Moduły 01–03)
// -----------------------------------------------------------------------------

function Przelicz() {
    // Moduł 01: [SEC-1] Pobranie wartości z pola i elementu wynikowego
    let liczbaDziesietna = document.getElementById('liczba').value;
    let wynikElement = document.getElementById('wynik');

    // Moduł 01: [SEC-2] Sprawdzenie poprawności wpisanej wartości
    if (liczbaDziesietna === "" || isNaN(liczbaDziesietna)) {
        wynikElement.innerHTML = "Proszę wpisać poprawną liczbę!";
        return;
    }

    // Moduł 01: [SEC-3] Przygotowanie liczby do konwersji
    let liczba = Math.floor(Math.abs(Number(liczbaDziesietna)));

    // Moduł 02: [SEC-1] Przypadek szczególny — liczba zero
    if (liczba === 0) {
        wynikElement.innerHTML = "0 <sub>(2)</sub>";
        return;
    }

    // Moduł 02: [SEC-2] Pętla algorytmu — dzielenie przez 2 i zbieranie reszt
    let binarny = "";
    while (liczba > 0) {
        binarny = (liczba % 2) + binarny;
        liczba = Math.floor(liczba / 2);
    }

    // Moduł 03: [SEC-1] Pętla grupująca cyfry co 4 znaki od prawej strony
    let binarnyGrupowany = "";
    for (let i = binarny.length; i > 0; i -= 4) {
        let start = Math.max(i - 4, 0);
        let grupa = binarny.substring(start, i);
        binarnyGrupowany = grupa + (binarnyGrupowany ? " " + binarnyGrupowany : "");
    }

    // Moduł 03: [SEC-2] Wyświetlenie wyniku z oznaczeniem systemu binarnego
    wynikElement.innerHTML = binarnyGrupowany + ' <sub>(2)</sub>';
}

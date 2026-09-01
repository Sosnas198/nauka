// POŁĄCZONY WZORZEC (Moduł 01 + Moduł 02) — strona index.html
// -----------------------------------------------------------------------------

function wybierzTrojkat() {
    // Moduł 01: [SEC-1] Zmiana dużego obrazu na trójkąt
    document.getElementById("duzyObraz").src = "1d.bmp";
}

function wybierzProstokat() {
    // Moduł 01: [SEC-2] Zmiana dużego obrazu na prostokąt
    document.getElementById("duzyObraz").src = "2d.bmp";
}

function obliczPole() {
    // Moduł 02: [SEC-1] Pobieranie danych z pól edycyjnych
    var bokA = Number(document.getElementById("a").value);
    var bokB = Number(document.getElementById("b").value);
    var srcObrazu = document.getElementById("duzyObraz").src;
    var wynik = 0;

    // Moduł 02: [SEC-2] Warunkowe obliczanie pola w zależności od stanu obrazu
    if (srcObrazu.includes("2d.bmp")) {
        wynik = bokA * bokB;
    } else {
        wynik = (bokA * bokB) / 2;
    }

    // Moduł 02: [SEC-3] Wyświetlanie wyniku w paragrafie
    document.getElementById("wynik").textContent = wynik;
}

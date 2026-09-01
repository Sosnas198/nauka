// POŁĄCZONY WZORZEC (Moduły 01–02)
// -----------------------------------------------------------------------------

function zamowienie() {
    // Moduł 01: [SEC-1] Pobranie wartości z pól formularza
    let ksztalt = document.getElementById('ksztalt').value;
    let r = document.getElementById('r').value;
    let g = document.getElementById('g').value;
    let b = document.getElementById('b').value;

    // Moduł 01: [SEC-2] Ustalenie treści zamówienia na podstawie kształtu
    let zamowienie;
    if(ksztalt == '1') {
        zamowienie = 'Twoje zamówienie to cukierek cytryna';
    }
    else if(ksztalt == '2') {
        zamowienie = 'Twoje zamówienie to cukierek liść';
    }
    else if(ksztalt == '3') {
        zamowienie = 'Twoje zamówienie to cukierek banan';
    }
    else {
        zamowienie = 'Twoje zamówienie to cukierek inny';
    }

    // Moduł 01: [SEC-3] Wypisanie treści zamówienia w akapicie
    document.getElementById('wynik').innerHTML = zamowienie;

    // Moduł 02: [SEC-1] Zbudowanie tekstu koloru w formacie rgb(...) i przypisanie go do stylu przycisku
    document.getElementById('kolor').style.backgroundColor = 'rgb('+r+','+g+','+b+')';
}

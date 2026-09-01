// UNIWERSALNY WZORZEC: Skrypt (część 1) — ustalenie treści zamówienia wg kształtu
// -----------------------------------------------------------------------------

// --- KROK 1: Pobranie wartości z pól formularza ---
// [ZOBACZ W README: SEC-1]
let ksztalt = document.getElementById('ksztalt').value;
let r = document.getElementById('r').value;
let g = document.getElementById('g').value;
let b = document.getElementById('b').value;

// --- KROK 2: Ustalenie treści zamówienia na podstawie kształtu ---
// [ZOBACZ W README: SEC-2]
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

// --- KROK 3: Wypisanie treści zamówienia w akapicie ---
// [ZOBACZ W README: SEC-3]
document.getElementById('wynik').innerHTML = zamowienie;

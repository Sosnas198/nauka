# Projekt JavaScript + DOM: fabryka cukierków (zamówienie + kolor przycisku)

**Słowa kluczowe:** dopasowanie liczby do nazwy (`if/else if/else`), wypisanie treści (`innerHTML`), wartości RGB z formularza, sklejanie formatu koloru (`'rgb(' + r + ',' + g + ',' + b + ')'`), zmiana stylu elementu (`style.backgroundColor`).

Projekt uczy, jak jedno kliknięcie przycisku może w ramach tej samej funkcji
realizować dwie zupełnie niezależne od siebie funkcjonalności: ustalenie
treści tekstowej na podstawie wybranej opcji oraz zmianę wyglądu innego
elementu na stronie na podstawie osobnych danych z formularza. Oba moduły
wykonują się jeden po drugim, bez żadnego warunku blokującego — w
przeciwieństwie do projektów z walidacją, gdzie błędne dane przerywały dalsze
kroki. Cała logika mieści się w jednej funkcji `zamowienie()`. Poniżej
znajdziesz **esencję każdego wzorca** — jeśli tylko chcesz sobie przypomnieć
jak coś działało, masz to tutaj. Pełne, powolne tłumaczenie "od zera" (z
podziałem na sekcje SEC-1, SEC-2...) znajduje się w README każdego
podfolderu.

## Struktura projektu

```text
08_projekt_fabryka_cukierkow/
├── 01_wybor_ksztaltu_cukierka/          -> if/else if/else + tekst zamówienia
├── 02_ustawienie_koloru_przycisku/      -> format rgb() + style.backgroundColor
├── index.html                            -> strona startowa
├── zamowienie.html                       -> formularz zamówienia + wynik
└── skrypt.js                             -> funkcja zamowienie() = moduły 1 + 2
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.js`
(czysta implementacja wzorca). `skrypt.js` łączy oba wzorce w jedną funkcję
`zamowienie()`, wywoływaną atrybutem `onclick` przycisku "Zamówienie" w
`zamowienie.html`. Plik `styl10.css` pochodzi z arkusza zadania — w HTML jest
tylko do niego link.

---

## Ściągawka wzorców

### 1. Wybór kształtu cukierka

```javascript
const ksztalt = document.getElementById("ksztalt").value;

let tekst;
if (ksztalt === "1") {
  tekst = "Zamawiasz cukierki w kształcie serca.";
} else if (ksztalt === "2") {
  tekst = "Zamawiasz cukierki w kształcie gwiazdki.";
} else {
  tekst = "Zamawiasz cukierki w kształcie kółka.";
}

document.getElementById("wynik").innerHTML = tekst;
```

`ksztalt` to numer wybranej opcji z listy wyboru — sam w sobie nic nie mówi
użytkownikowi, dlatego `if/else if/else` dopasowuje go do czytelnej nazwy
kształtu. Ostatnia gałąź `else` pełni rolę wartości domyślnej — obsługuje
każdy numer, który nie pasuje do wcześniejszych warunków. Gotowy tekst
trafia na stronę przez `innerHTML` elementu `<p id="wynik">`.

→ Pełne wytłumaczenie: [`01_wybor_ksztaltu_cukierka/README.md`](./01_wybor_ksztaltu_cukierka/README.md)

### 2. Ustawienie koloru przycisku

```javascript
const r = document.getElementById("r").value;
const g = document.getElementById("g").value;
const b = document.getElementById("b").value;

document.getElementById("kolor").style.backgroundColor =
  "rgb(" + r + "," + g + "," + b + ")";
```

Trzy pola formularza dają trzy składowe koloru (czerwoną, zieloną, niebieską).
Sklejenie ich operatorem `+` w formacie `"rgb(r,g,b)"` daje gotowy tekst,
który CSS rozumie jako wartość koloru — nie trzeba żadnej dodatkowej
konwersji. `style.backgroundColor` ustawia ten kolor bezpośrednio jako tło
przycisku `<button id="kolor">`, zmieniając jego wygląd natychmiast po
kliknięciu.

→ Pełne wytłumaczenie: [`02_ustawienie_koloru_przycisku/README.md`](./02_ustawienie_koloru_przycisku/README.md)

---

## Tabela referencyjna

| Plik / moduł                     | Kluczowa funkcja                                  | Do czego służy                                           |
| -------------------------------- | ------------------------------------------------- | -------------------------------------------------------- |
| `01_wybor_ksztaltu_cukierka`     | `if/else if/else`, `innerHTML`                    | Dopasowanie numeru kształtu do treści zamówienia         |
| `02_ustawienie_koloru_przycisku` | sklejanie `"rgb(r,g,b)"`, `style.backgroundColor` | Zmiana koloru tła przycisku wg wartości RGB z formularza |
| `skrypt.js`                      | funkcja `zamowienie()` = moduły 1 + 2             | Skrypt strony zamówienia                                 |

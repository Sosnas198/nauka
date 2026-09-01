# Projekt JavaScript + DOM: fryzjerstwo (promocyjna cena strzyżenia)

**Słowa kluczowe:** pobranie elementów (`getElementById`), `let` vs `const`, zaznaczony przycisk radio (`.checked`), łańcuch warunków (`if / else if`), odjęcie promocji od ceny bazowej, sklejanie tekstu operatorem `+`, wstawienie wyniku (`.innerHTML`).

Projekt uczy prostego wzorca "sprawdź który przycisk radio jest zaznaczony i
policz na tej podstawie wynik": cztery opcje długości włosów, każda z inną
ceną bazową, z której zawsze odejmowane jest 10 zł promocji. Cała logika
mieści się w jednej funkcji `odkryj()`, uruchamianej przyciskiem na stronie.
Poniżej znajdziesz **esencję każdego wzorca** — jeśli tylko chcesz sobie
przypomnieć jak coś działało, masz to tutaj. Pełne, powolne tłumaczenie "od
zera" (z podziałem na sekcje SEC-1, SEC-2...) znajduje się w README każdego
podfolderu.

## Struktura projektu

```text
07_projekt_fryzjerstwo/
├── 01_pobieranie_wybranej_opcji/       -> getElementById dla wyniku i przycisków radio
├── 02_obliczanie_ceny_promocyjnej/     -> .checked + if/else if + cena - 10
└── 03_wyswietlanie_wyniku/             -> innerHTML + sklejanie tekstu
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.js`
(czysta implementacja wzorca). W oryginalnym kodzie wszystkie trzy moduły są
fragmentami **jednej, wspólnej** funkcji `odkryj()`, uruchamianej przyciskiem
`<button onclick="odkryj()">Odkryj promocję</button>` na stronie
`fryzura.html` — rozdzielone tu dla przejrzystości nauki. Pełny, złożony razem
kod znajdziesz w sekcji "Wzorzec końcowy" poniżej.

---

## Ściągawka wzorców

### 1. Pobranie wybranej opcji

```javascript
let wynik = document.getElementById("wynik");
let cena = 0;
const krotkie = document.getElementById("krotkie");
const srednie = document.getElementById("srednie");
const poldlugie = document.getElementById("poldlugie");
const dlugie = document.getElementById("dlugie");
```

`wynik` i `cena` deklarowane są przez `let`, bo ich wartość zmieni się w
dalszej części funkcji. Cztery przyciski radio pobierane są przez `const`,
bo same uchwyty do elementów nigdy się nie zmieniają — zmienia się tylko ich
stan `.checked`. Wszystkie cztery pobierane są naraz, na samym początku
funkcji, zanim jeszcze wiadomo, który z nich jest zaznaczony.

→ Pełne wytłumaczenie: [`01_pobieranie_wybranej_opcji/README.md`](./01_pobieranie_wybranej_opcji/README.md)

### 2. Obliczenie ceny promocyjnej

```javascript
if (krotkie.checked) {
  cena = 25 - 10;
} else if (srednie.checked) {
  cena = 30 - 10;
} else if (poldlugie.checked) {
  cena = 40 - 10;
} else if (dlugie.checked) {
  cena = 50 - 10;
}
```

Łańcuch `if / else if` sprawdza po kolei właściwość `.checked` każdego
przycisku radio — tylko jeden z nich może być zaznaczony naraz, bo dzielą
wspólny atrybut `name` w HTML. Cena promocyjna to zawsze cena bazowa
pomniejszona o stałe `10` zł, niezależnie od wybranej długości włosów.

→ Pełne wytłumaczenie: [`02_obliczanie_ceny_promocyjnej/README.md`](./02_obliczanie_ceny_promocyjnej/README.md)

### 3. Wyświetlenie wyniku

```javascript
wynik.innerHTML = "<p>cena promocyjna: " + cena + "</p>";
```

Operator `+` skleja tekst z wartością zmiennej `cena` — JavaScript
automatycznie zamienia liczbę na tekst przy takim łączeniu. Gotowy fragment
HTML trafia do elementu wynikowego przez `.innerHTML`, wstawiając nowy
paragraf pod przyciskiem "Odkryj promocję".

→ Pełne wytłumaczenie: [`03_wyswietlanie_wyniku/README.md`](./03_wyswietlanie_wyniku/README.md)

---

## Tabela referencyjna

| Plik / moduł                     | Kluczowa funkcja                     | Do czego służy                                              |
| -------------------------------- | ------------------------------------ | ----------------------------------------------------------- |
| `01_pobieranie_wybranej_opcji`   | `getElementById()`, `let` vs `const` | Pobranie elementu wynikowego i przycisków radio             |
| `02_obliczanie_ceny_promocyjnej` | `.checked`, `if / else if`           | Sprawdzenie zaznaczonej opcji i wyliczenie ceny promocyjnej |
| `03_wyswietlanie_wyniku`         | `.innerHTML`, operator `+`           | Wstawienie sformatowanego wyniku na stronę                  |

> **Uwaga:** cena bazowa dla opcji "Krótkie" w skrypcie (`25`) różni się od
> wartości w tabeli cennika na stronie (`30`). To wartość wzięta wprost z
> oryginalnego kodu źródłowego — nie została zmieniona.

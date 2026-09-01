# Projekt JavaScript + DOM: kalkulator kosztów montażu paneli

**Słowa kluczowe:** odczyt liczb z formularza (`parseFloat`), zaznaczony wybór (`querySelector(':checked')`), walidacja wejścia (puste / zero / ujemne / brak wyboru), obliczenie pola prostokąta, stawka wg typu panelu (`if/else if`), szablon literału, wypisanie wyniku (`textContent`).

Projekt uczy klasycznego wzorca "kalkulatora": pobierz dane → sprawdź
poprawność → policz → wyświetl wynik — spotykanego bardzo często w różnych
aplikacjach webowych. Jeśli walidacja wykryje błędne dane, funkcja kończy
działanie od razu, a dalsze etapy (obliczenia i wyświetlenie) w ogóle się nie
wykonują. Cała logika mieści się w jednej funkcji `Oblicz()`. Poniżej
znajdziesz **esencję każdego wzorca** — jeśli tylko chcesz sobie przypomnieć
jak coś działało, masz to tutaj. Pełne, powolne tłumaczenie "od zera" (z
podziałem na sekcje SEC-1, SEC-2...) znajduje się w README każdego
podfolderu.

## Struktura projektu

```text
07_projekt_koszty_paneli/
├── 01_pobieranie_danych_i_walidacja/     -> parseFloat + querySelector(':checked') + walidacja
├── 02_obliczanie_pola_i_kosztu/          -> pole prostokąta + stawka wg typu panelu
├── 03_wyswietlanie_wyniku/               -> szablon literału + textContent
├── index.html                            -> strona startowa
├── oferta.html                           -> tabela 1 ze stawkami za m²
├── koszty.html                           -> kalkulator (formularz + wynik)
└── main.js                               -> funkcja Oblicz() = moduły 1 + 2 + 3
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.js`
(czysta implementacja wzorca). W oryginalnym kodzie źródłowym funkcja
`Oblicz()` znajduje się bezpośrednio wewnątrz znacznika `<script>` w treści
strony `koszty.html` i pozostaje tam bez zmian — `main.js` to referencyjna,
połączona wersja wszystkich trzech modułów. Plik `style.css` pochodzi z
arkusza zadania.

---

## Ściągawka wzorców

### 1. Pobranie danych i walidacja

```javascript
const szerokosc = parseFloat(document.getElementById("szerokosc").value);
const dlugosc = parseFloat(document.getElementById("dlugosc").value);
const wybranyPanel = document.querySelector('input[name="panel"]:checked');

if (!szerokosc || !dlugosc || szerokosc <= 0 || dlugosc <= 0 || !wybranyPanel) {
  return;
}
```

`parseFloat()` zamienia tekst wpisany w polach na liczbę zmiennoprzecinkową —
w przeciwieństwie do zwykłego `.value`, które zawsze zwraca tekst.
`querySelector(':checked')` znajduje ten jeden przycisk radiowy, który
użytkownik faktycznie zaznaczył, spośród wielu o tej samej nazwie. Warunek
walidacyjny sprawdza od razu kilka rzeczy naraz: czy pole nie jest puste
(`!szerokosc` jest prawdziwe też dla `NaN`), czy wartość nie jest ujemna ani
zerowa, oraz czy w ogóle wybrano typ panelu. Jeśli którykolwiek z tych
przypadków zajdzie, funkcja kończy się od razu przez `return` — bez
obliczania czegokolwiek.

→ Pełne wytłumaczenie: [`01_pobieranie_danych_i_walidacja/README.md`](./01_pobieranie_danych_i_walidacja/README.md)

### 2. Obliczenie pola i kosztu

```javascript
const pole = szerokosc * dlugosc;

let kosztZaM2;
if (wybranyPanel.value === "dab") {
  kosztZaM2 = 45;
} else if (wybranyPanel.value === "buk") {
  kosztZaM2 = 38;
} else {
  kosztZaM2 = 30;
}

const koszt = pole * kosztZaM2;
```

Pole powierzchni to zwykły iloczyn szerokości i długości pomieszczenia.
Stawka za metr kwadratowy zależy od typu panelu wybranego w formularzu —
`if/else if` sprawdza wartość zaznaczonego przycisku radiowego i przypisuje
odpowiednią stawkę z tabeli 1 z `oferta.html`. Koszt całkowity to iloczyn
pola i stawki jednostkowej.

→ Pełne wytłumaczenie: [`02_obliczanie_pola_i_kosztu/README.md`](./02_obliczanie_pola_i_kosztu/README.md)

### 3. Wyświetlenie wyniku

```javascript
document.getElementById("wynik").textContent =
  `Pole powierzchni: ${pole} m², koszt montażu: ${koszt} zł`;
```

Szablon literału (backticki i `${...}`) pozwala wstawić obliczone wartości
bezpośrednio w tekst, bez ręcznego sklejania stringów operatorem `+`. Gotowy
tekst trafia do elementu wyniku przez `textContent`.

→ Pełne wytłumaczenie: [`03_wyswietlanie_wyniku/README.md`](./03_wyswietlanie_wyniku/README.md)

---

## Tabela referencyjna

| Plik / moduł                       | Kluczowa funkcja                                               | Do czego służy                                           |
| ---------------------------------- | -------------------------------------------------------------- | -------------------------------------------------------- |
| `01_pobieranie_danych_i_walidacja` | `parseFloat`, `querySelector(':checked')`, warunek walidacyjny | Odczyt danych z formularza i sprawdzenie ich poprawności |
| `02_obliczanie_pola_i_kosztu`      | wzór na pole prostokąta, `if/else if`                          | Wyliczenie pola powierzchni i kosztu montażu             |
| `03_wyswietlanie_wyniku`           | szablon literału, `textContent`                                | Sformatowanie i wypisanie wyniku na stronie              |
| `main.js`                          | funkcja `Oblicz()` = moduły 1 + 2 + 3                          | Skrypt strony kalkulatora                                |

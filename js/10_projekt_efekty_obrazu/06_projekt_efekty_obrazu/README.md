# Projekt JavaScript + CSS: efekty na obrazach (filtr CSS sterowany z JS)

**Słowa kluczowe:** stan pola wyboru (`.checked`), dopisywanie do tekstu (`+=`), przycinanie białych znaków (`.trim()`), stały filtr (`style.filter = 'none'`, `grayscale(100%)`), wartość suwaka (`.value` z `<input type="range">`), szablon literału, właściwość CSS `filter` (`blur`, `sepia`, `invert`, `opacity`, `brightness`).

Projekt to cztery niezależne bloki, z których każdy pokazuje inny sposób
sterowania właściwością CSS `filter` za pomocą JavaScriptu: łączenie kilku
filtrów naraz na podstawie checkboxów, przełączanie między dwoma stałymi
stanami, oraz dwie płynne regulacje suwakiem o różnych zakresach wartości.
Mimo różnych efektów wizualnych wszystkie cztery funkcje opierają się na tym
samym schemacie: pobierz obraz → odczytaj sterowanie → zbuduj tekst filtra →
przypisz do `img.style.filter`. Całość jest zebrana w dwóch działających
plikach: `index.html` i `skrypt.js`. Poniżej znajdziesz **esencję każdego
wzorca** — jeśli tylko chcesz sobie przypomnieć jak coś działało, masz to
tutaj. Pełne, powolne tłumaczenie "od zera" (z podziałem na sekcje SEC-1,
SEC-2...) znajduje się w README każdego podfolderu.

## Struktura projektu

```text
06_projekt_efekty_obrazu/
├── 01_filtry_obrazu1/          -> łączenie filtrów (blur/sepia/invert) na checkboxach
├── 02_szarosc_obrazu2/         -> dwa stałe przełączniki (kolor / czarno-biały)
├── 03_przezroczystosc_obrazu3/ -> suwak 0-100 -> opacity()
├── 04_jasnosc_obrazu4/         -> suwak 0-250 -> brightness()
├── index.html                  -> pełna strona: cztery bloki razem
└── skrypt.js                   -> wszystkie cztery funkcje razem
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.js`
(czysta implementacja wzorca). `index.html` i `skrypt.js` łączą te wzorce w
działającą stronę — każdy blok działa niezależnie od pozostałych, na swoim
własnym obrazie.

> **Uwaga:** kod odwołuje się do plików `styl.css`, `pszczola.jpg`,
> `pomarancza.jpg`, `owoce.jpg` i `zolw.jpg`, których nie było w treści
> zadania — trzeba je samodzielnie dodać, żeby strona wyglądała i działała
> poprawnie.

---

## Ściągawka wzorców

### 1. Łączenie wielu filtrów naraz

```javascript
function zastosuj() {
  let filtr = "";

  if (document.getElementById("blur").checked) {
    filtr += "blur(5px) ";
  }
  if (document.getElementById("sepia").checked) {
    filtr += "sepia(100%) ";
  }
  if (document.getElementById("negatyw").checked) {
    filtr += "invert(100%) ";
  }

  document.querySelector("#blok1 img").style.filter = filtr.trim();
}
```

Trzy niezależne `if` (bez `else`) sprawdzają `.checked` każdego pola
osobno — użytkownik może zaznaczyć dowolną kombinację, więc każdy efekt
dopisuje się do tekstu filtra operatorem `+=`, a nie zastępuje poprzedni.
`.trim()` na końcu usuwa nadmiarową spację, gdyby żaden checkbox nie był
zaznaczony (wtedy filtr byłby pustym tekstem).

→ Pełne wytłumaczenie: [`01_filtry_obrazu1/README.md`](./01_filtry_obrazu1/README.md)

### 2. Dwa proste, stałe przełączniki

```javascript
function kolorowy() {
  document.querySelector("#blok2 img").style.filter = "none";
}

function czarnobialy() {
  document.querySelector("#blok2 img").style.filter = "grayscale(100%)";
}
```

Najprostszy z czterech wzorców — żadnych warunków, żadnego odczytu danych.
Każda funkcja odpowiada jednemu przyciskowi i ustawia zawsze tę samą, stałą
wartość filtra: `'none'` przywraca oryginalny obraz, `grayscale(100%)`
zamienia go w pełni na czarno-biały.

→ Pełne wytłumaczenie: [`02_szarosc_obrazu2/README.md`](./02_szarosc_obrazu2/README.md)

### 3. Suwak sterujący przezroczystością

```javascript
function przezroczystosc() {
  const wartosc = document.getElementById("suwak3").value;
  document.querySelector("#blok3 img").style.filter = `opacity(${wartosc}%)`;
}
```

`.value` suwaka (`<input type="range">`) zwraca aktualną pozycję jako tekst
w zakresie 0–100. Szablon literału (backticki + `${...}`) wstawia tę wartość
bezpośrednio do tekstu filtra `opacity(N%)` — im niższa wartość, tym
bardziej przezroczysty obraz. Funkcja wywoływana jest przy każdej zmianie
pozycji suwaka, więc efekt aktualizuje się płynnie w czasie rzeczywistym.

→ Pełne wytłumaczenie: [`03_przezroczystosc_obrazu3/README.md`](./03_przezroczystosc_obrazu3/README.md)

### 4. Suwak sterujący jasnością (inny zakres)

```javascript
function jasnosc() {
  const wartosc = document.getElementById("suwak4").value;
  document.querySelector("#blok4 img").style.filter = `brightness(${wartosc}%)`;
}
```

Ten sam schemat co przy przezroczystości, ale z suwakiem skonfigurowanym
inaczej: zakres 0–250 (zamiast 0–100) i bez ustawionej wartości domyślnej w
HTML. Wyższy dopuszczalny zakres pozwala nie tylko przyciemnić obraz, ale
też rozjaśnić go ponad jego normalny, wyjściowy poziom — `brightness(100%)`
to stan bez zmian, wartości powyżej rozjaśniają.

→ Pełne wytłumaczenie: [`04_jasnosc_obrazu4/README.md`](./04_jasnosc_obrazu4/README.md)

---

## Tabela referencyjna

| Plik / moduł                 | Kluczowa właściwość / filtr CSS       | Zastosowanie                                                   |
| ---------------------------- | ------------------------------------- | -------------------------------------------------------------- |
| `01_filtry_obrazu1`          | `.checked`, `+=`, `blur/sepia/invert` | Łączenie wielu filtrów naraz na podstawie checkboxów           |
| `02_szarosc_obrazu2`         | `'none'`, `grayscale(100%)`           | Dwa proste, stałe przełączniki stylu                           |
| `03_przezroczystosc_obrazu3` | `.value` suwaka, `opacity(N%)`        | Płynna regulacja przezroczystości suwakiem (0–100)             |
| `04_jasnosc_obrazu4`         | `.value` suwaka, `brightness(N%)`     | Płynna regulacja jasności suwakiem o szerszym zakresie (0–250) |

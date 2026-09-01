# Projekt JavaScript + DOM: kalkulator rat za kursy komputerowe

**Słowa kluczowe:** zaznaczone checkboxy (`.checked`), sumowanie warunkowe, liczba całkowita z pola (`parseInt`), wartość listy rozwijanej (`select.value`), walidacja liczby rat (`isNaN`), wcześniejsze zakończenie (`return`), dzielenie z zaokrągleniem (`toFixed(2)`), stopniowo pełniejszy komunikat wyniku.

Projekt uczy wzorca skryptu z **trzema możliwymi wyjściami**, w zależności od
tego, ile poprawnych danych podał użytkownik: brak wybranego kursu kończy
działanie od razu, niepoprawna liczba rat daje częściowy wynik (samo miasto i
koszt), a dopiero komplet poprawnych danych daje pełny wynik z wysokością
raty. Po drodze widać też różnicę między polami `checkbox` (niezależne,
wielokrotne zaznaczanie) a `radio` (wybór jednej opcji z grupy) — tu użyte są
te pierwsze. Cała logika mieści się w jednej funkcji `Oblicz()`. Poniżej
znajdziesz **esencję każdego wzorca** — jeśli tylko chcesz sobie przypomnieć
jak coś działało, masz to tutaj. Pełne, powolne tłumaczenie "od zera" (z
podziałem na sekcje SEC-1, SEC-2...) znajduje się w README każdego
podfolderu.

## Struktura projektu

```text
09_projekt_kursy_komputerowe/
├── 01_pobieranie_danych_i_kwota_calkowita/    -> .checked + suma zaznaczonych kursów
├── 02_walidacja_liczby_rat/                   -> isNaN + częściowy wynik
├── 03_obliczanie_raty_i_wyswietlanie/         -> dzielenie + pełny komunikat
├── index.html                                  -> strona startowa
├── raty.html                                   -> formularz kalkulatora + wynik
└── main.js                                     -> funkcja Oblicz() = moduły 1 + 2 + 3
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.js`
(czysta implementacja wzorca). W oryginalnym kodzie źródłowym funkcja
`Oblicz()` znajduje się bezpośrednio wewnątrz znacznika `<script>` w treści
strony `raty.html` i pozostaje tam bez zmian — `main.js` to referencyjna,
połączona wersja wszystkich trzech modułów. Plik `style.css` pochodzi z
arkusza zadania.

---

## Ściągawka wzorców

### 1. Pobranie danych i kwota całkowita

```javascript
let kwotaCalkowita = 0;

if (document.getElementById("kurs1").checked) {
  kwotaCalkowita += 300;
}
if (document.getElementById("kurs2").checked) {
  kwotaCalkowita += 450;
}

if (kwotaCalkowita === 0) {
  document.getElementById("wynik").textContent =
    "Wybierz przynajmniej jeden kurs.";
  return;
}
```

Każdy checkbox sprawdzany jest osobno przez `.checked` — w przeciwieństwie do
`radio`, gdzie tylko jedna opcja z grupy może być zaznaczona, tu użytkownik
może wybrać dowolną liczbę kursów naraz, a ich koszty się sumują. Jeśli
żaden checkbox nie jest zaznaczony, `kwotaCalkowita` zostaje na `0` — to
sygnał, że dalsze obliczenia nie mają sensu, więc funkcja od razu wypisuje
komunikat i kończy działanie przez `return`.

→ Pełne wytłumaczenie: [`01_pobieranie_danych_i_kwota_calkowita/README.md`](./01_pobieranie_danych_i_kwota_calkowita/README.md)

### 2. Walidacja liczby rat

```javascript
const liczbaRat = parseInt(document.getElementById("raty").value);

if (isNaN(liczbaRat) || liczbaRat < 1) {
  document.getElementById("wynik").textContent =
    `Miasto: ${miasto}, koszt kursu: ${kwotaCalkowita} zł.`;
  return;
}
```

`parseInt()` zamienia wpisaną wartość na liczbę całkowitą. `isNaN()` łapie
przypadek, gdy pole było puste albo zawierało tekst, a `liczbaRat < 1` łapie
liczby zerowe i ujemne — oba przypadki oznaczają, że nie da się policzyć
sensownej raty. Zamiast jednak przerwać działanie bez żadnej informacji,
skrypt wyświetla **częściowy** wynik — to, co już wiadomo na pewno (miasto,
koszt kursu) — i dopiero wtedy kończy funkcję przez `return`.

→ Pełne wytłumaczenie: [`02_walidacja_liczby_rat/README.md`](./02_walidacja_liczby_rat/README.md)

### 3. Obliczenie raty i pełne wyświetlenie

```javascript
const rata = (kwotaCalkowita / liczbaRat).toFixed(2);

document.getElementById("wynik").textContent =
  `Miasto: ${miasto}, koszt kursu: ${kwotaCalkowita} zł, liczba rat: ${liczbaRat}, wysokość raty: ${rata} zł.`;
```

Ten fragment wykonuje się tylko wtedy, gdy oba wcześniejsze etapy zakończyły
się bez wcześniejszego `return` — czyli mamy i wybrany kurs, i poprawną
liczbę rat. Wysokość pojedynczej raty to zwykłe dzielenie kwoty całkowitej
przez liczbę rat, a `.toFixed(2)` zaokrągla wynik do dwóch miejsc po
przecinku, tak jak przy kwotach pieniężnych. Ostateczny komunikat jest
najpełniejszy ze wszystkich trzech możliwych — zawiera komplet czterech
wartości.

→ Pełne wytłumaczenie: [`03_obliczanie_raty_i_wyswietlanie/README.md`](./03_obliczanie_raty_i_wyswietlanie/README.md)

---

## Tabela referencyjna

| Plik / moduł                             | Kluczowa funkcja                                | Do czego służy                                           |
| ---------------------------------------- | ----------------------------------------------- | -------------------------------------------------------- |
| `01_pobieranie_danych_i_kwota_calkowita` | `.checked`, sumowanie warunkowe, `select.value` | Odczyt zaznaczonych kursów i wyliczenie kwoty całkowitej |
| `02_walidacja_liczby_rat`                | `parseInt`, `isNaN`, wcześniejszy `return`      | Sprawdzenie poprawności liczby rat i częściowy wynik     |
| `03_obliczanie_raty_i_wyswietlanie`      | dzielenie, `toFixed(2)`, szablon literału       | Wyliczenie wysokości raty i wyświetlenie pełnego wyniku  |
| `main.js`                                | funkcja `Oblicz()` = moduły 1 + 2 + 3           | Skrypt strony kalkulatora                                |

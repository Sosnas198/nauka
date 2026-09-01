# Projekt JavaScript + Math: pozycyjne systemy liczbowe (zamiana na binarny)

**Słowa kluczowe:** walidacja wejścia (`isNaN`), zaokrąglenie i wartość bezwzględna (`Math.floor`, `Math.abs`), przypadek brzegowy zera, pętla dzieląca (`while`, `%`), grupowanie znaków od prawej (`substring`, `Math.max`), malejąca pętla `for`, indeks dolny (`<sub>`).

Projekt uczy, jak gotowy pseudokod algorytmu (kroki K1–K6 z treści zadania)
przekłada się krok po kroku na rzeczywisty kod JavaScript: od sprawdzenia, czy
wpisana wartość w ogóle jest liczbą, przez właściwy algorytm zamiany
dziesiętnej na binarną (dzielenie przez 2 i zbieranie reszt), aż po
pogrupowanie i wyświetlenie wyniku w formacie z arkusza. Cała logika mieści
się w jednej funkcji `Przelicz()`. Poniżej znajdziesz **esencję każdego
wzorca** — jeśli tylko chcesz sobie przypomnieć jak coś działało, masz to
tutaj. Pełne, powolne tłumaczenie "od zera" (z podziałem na sekcje SEC-1,
SEC-2...) znajduje się w README każdego podfolderu.

## Struktura projektu

```text
06_projekt_systemy_liczbowe/
├── 01_walidacja_i_przygotowanie_liczby/    -> isNaN + Math.floor(Math.abs(...))
├── 02_zamiana_na_binarny/                  -> przypadek zera + pętla dzieląca
├── 03_grupowanie_i_wyswietlanie_wyniku/    -> podział co 4 znaki + <sub>(2)</sub>
├── systemy-liczbowe.html                   -> strona z arkusza
└── main.js                                 -> funkcja Przelicz() = moduły 1 + 2 + 3
```

Każdy z modułów zawiera `README.md` (pełne wytłumaczenie) i `script.js`
(czysta implementacja wzorca). W oryginalnym kodzie źródłowym funkcja
`Przelicz()` znajduje się bezpośrednio wewnątrz znacznika `<script>` w treści
strony `systemy-liczbowe.html` i pozostaje tam bez zmian — `main.js` to
referencyjna, połączona wersja wszystkich trzech modułów. Każdy moduł albo
przekazuje przygotowane dane dalej, albo — przy błędnych danych czy liczbie
zero — kończy funkcję wcześniej przez `return`. Plik `styl.css` pochodzi z
arkusza zadania.

---

## Ściągawka wzorców

### 1. Walidacja i przygotowanie liczby

```javascript
const wejscie = document.getElementById("liczba").value;
const liczba = Number(wejscie);

if (isNaN(liczba)) {
  return;
}

const liczbaCalkowita = Math.floor(Math.abs(liczba));
```

`isNaN()` sprawdza, czy to, co wpisał użytkownik, w ogóle da się
zinterpretować jako liczbę — jeśli nie, funkcja kończy się od razu przez
`return`, zanim dojdzie do dalszych obliczeń. `Math.abs()` odcina znak
(radzi sobie z liczbami ujemnymi), a `Math.floor()` odcina część ułamkową
(radzi sobie z liczbami niecałkowitymi) — razem dają zawsze dodatnią liczbę
całkowitą, gotową do algorytmu zamiany.

→ Pełne wytłumaczenie: [`01_walidacja_i_przygotowanie_liczby/README.md`](./01_walidacja_i_przygotowanie_liczby/README.md)

### 2. Zamiana na system binarny

```javascript
if (liczbaCalkowita === 0) {
  return "0";
}

let wynik = "";
let n = liczbaCalkowita;

while (n > 0) {
  wynik = (n % 2) + wynik;
  n = Math.floor(n / 2);
}
```

Zero jest przypadkiem brzegowym obsłużonym osobno — pętla dzieląca nigdy by
go nie wygenerowała, bo warunek `n > 0` od razu byłby fałszywy. Sam algorytm
to klasyczne dzielenie przez 2: `n % 2` daje resztę (0 albo 1) — kolejną
cyfrę binarną — a doklejana jest ona **z przodu** wyniku (`wynik = reszta +
wynik`), bo reszty powstają w kolejności od najmłodszego bitu do
najstarszego. `Math.floor(n / 2)` dzieli liczbę przez 2 z odrzuceniem reszty,
przygotowując `n` na kolejny obrót pętli.

→ Pełne wytłumaczenie: [`02_zamiana_na_binarny/README.md`](./02_zamiana_na_binarny/README.md)

### 3. Grupowanie i wyświetlanie wyniku

```javascript
let pogrupowany = "";
for (let i = wynik.length; i > 0; i -= 4) {
  const start = Math.max(0, i - 4);
  pogrupowany = wynik.substring(start, i) + " " + pogrupowany;
}

wynikElement.innerHTML = pogrupowany.trim() + "<sub>(2)</sub>";
```

Pętla `for` idzie **od końca** ciągu binarnego w stronę początku, krok po 4
znaki, żeby grupować cyfry od prawej — dokładnie tak, jak zapisuje się liczby
binarne w formacie z arkusza. `Math.max(0, i - 4)` pilnuje, żeby ostatnia
(najbardziej z lewej) grupa nie próbowała wyjść poza początek ciągu, gdy
zostanie mniej niż 4 cyfry. `substring(start, i)` wycina kolejną grupę, a
`<sub>(2)</sub>` na końcu dopisuje w indeksie dolnym oznaczenie systemu
binarnego.

→ Pełne wytłumaczenie: [`03_grupowanie_i_wyswietlanie_wyniku/README.md`](./03_grupowanie_i_wyswietlanie_wyniku/README.md)

---

## Tabela referencyjna

| Plik / moduł                          | Kluczowa funkcja                                        | Do czego służy                                         |
| ------------------------------------- | ------------------------------------------------------- | ------------------------------------------------------ |
| `01_walidacja_i_przygotowanie_liczby` | `isNaN`, `Math.floor`, `Math.abs`, `Number`             | Sprawdzenie i przygotowanie liczby wejściowej          |
| `02_zamiana_na_binarny`               | przypadek zera, pętla `while`, `%`, `Math.floor(n / 2)` | Właściwy algorytm zamiany dziesiętnej na binarną       |
| `03_grupowanie_i_wyswietlanie_wyniku` | `substring`, `Math.max`, malejąca pętla `for`, `<sub>`  | Pogrupowanie cyfr i wyświetlenie sformatowanego wyniku |
| `main.js`                             | funkcja `Przelicz()` = moduły 1 + 2 + 3                 | Skrypt strony głównej                                  |

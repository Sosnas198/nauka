# Projekt JavaScript + DOM: karuzela zdjęć z zawijaniem indeksu (przewijanie w kółko, w obie strony)

**Słowa kluczowe:** licznik globalny (`let` vs `const`), inkrementacja/dekrementacja (`++` / `--`), mechanizm zawijania indeksu (`if` resetujący licznik), wspólna funkcja aktualizująca (zasada DRY), `querySelector("#id tag")`, konkatenacja liczby z tekstem (`liczba + ".jpg"`).

Projekt uczy klasycznego wzorca "karuzeli z zawijaniem": dwa przyciski
zmieniają wspólny licznik w górę lub w dół, a osobny warunek pilnuje, żeby
licznik nigdy nie wyszedł poza zakres dostępnych zdjęć — zamiast tego zawija
się na przeciwny koniec listy. Obie funkcje przycisków nie dotykają
bezpośrednio obrazka na stronie — tylko zmieniają licznik i zlecają
faktyczną aktualizację jednej, wspólnej funkcji (zasada DRY — _Don't Repeat
Yourself_). Całość jest zebrana w dwóch działających plikach: `index.html` i
`skrypt.js`. Poniżej znajdziesz **esencję każdego wzorca** — jeśli tylko
chcesz sobie przypomnieć jak coś działało, masz to tutaj.

## Struktura projektu

```text
08_projekt_galeria_karuzela/
├── index.html    -> strona: duże zdjęcie + przyciski < >
└── skrypt.js     -> licznik globalny + kolejne() + poprzednie() + aktualizacja()
```

> **Uwaga:** kod odwołuje się do pliku `styl.css` oraz zdjęć `1.jpg`–`7.jpg`,
> których nie było w treści zadania — trzeba je samodzielnie dodać, żeby
> strona wyglądała poprawnie. Na starcie wyświetlane jest zdjęcie `1.jpg`.

---

## Ściągawka wzorców

### 1. Zmienne globalne: aktualny numer i liczba wszystkich zdjęć

```javascript
let zdjecieIndex = 1;
const zdjecia = 7;
```

`zdjecieIndex` (`let`, bo wartość się zmienia) przechowuje numer aktualnie
wyświetlanego zdjęcia — start na `1`, zgodnie ze stanem początkowym strony.
`zdjecia` (`const`, bo nigdy się nie zmienia) to łączna liczba zdjęć w
galerii. Obie zmienne są zdefiniowane **na zewnątrz** funkcji (poziom
globalny pliku), dzięki czemu wszystkie trzy funkcje mogą je odczytywać i
modyfikować — gdyby były zadeklarowane wewnątrz jednej funkcji, pozostałe
nie miałyby do nich dostępu.

### 2. Przejście do następnego zdjęcia z zawijaniem

```javascript
function kolejne() {
  zdjecieIndex++;
  if (zdjecieIndex > zdjecia) {
    zdjecieIndex = 1;
  }
  aktualizacja();
}
```

`zdjecieIndex++` zwiększa licznik o 1. Warunek `if (zdjecieIndex > zdjecia)`
to sam mechanizm zawijania: jeśli licznik przekroczył liczbę wszystkich
zdjęć — czyli wyświetlane było ostatnie zdjęcie i próbujemy pójść "dalej" —
resetujemy go z powrotem do `1`, zamiast pozwolić mu rosnąć w nieskończoność
(co pokazywałoby nieistniejące zdjęcie, np. `8.jpg`). Na końcu funkcja
wywołuje `aktualizacja()`, która dopiero faktycznie zmienia obrazek na
stronie.

### 3. Przejście do poprzedniego zdjęcia z zawijaniem

```javascript
function poprzednie() {
  zdjecieIndex--;
  if (zdjecieIndex < 1) {
    zdjecieIndex = zdjecia;
  }
  aktualizacja();
}
```

Lustrzane odbicie `kolejne()`: `zdjecieIndex--` zmniejsza licznik o 1, a
warunek `if (zdjecieIndex < 1)` sprawdza, czy licznik spadł poniżej
pierwszego zdjęcia. Jeśli tak — użytkownik kliknął "wstecz" przy pierwszym
zdjęciu — licznik ustawiany jest na `zdjecia` (czyli `7`), zawijając galerię
na sam koniec listy.

### 4. Wspólna funkcja aktualizująca obrazek

```javascript
function aktualizacja() {
  const zdjecieElement = document.querySelector("#srodkowy img");
  zdjecieElement.src = zdjecieIndex + ".jpg";
}
```

`querySelector("#srodkowy img")` wyszukuje `<img>` wewnątrz elementu o
identyfikatorze `srodkowy` — czyli ten jeden, duży obrazek pośrodku strony, a
nie jedną z miniatur. `zdjecieIndex + ".jpg"` to konkatenacja liczby i
tekstu — operator `+` automatycznie zamienia liczbę na tekst i skleja je
razem (np. `4` staje się `"4.jpg"`). Ponieważ ta logika siedzi w jednej,
osobnej funkcji, obie funkcje `kolejne()` i `poprzednie()` korzystają z niej
zamiast powtarzać ten sam kod dwa razy.

---

## Tabela referencyjna

| Pojęcie / operator                            | Co robi                                                                                 |
| --------------------------------------------- | --------------------------------------------------------------------------------------- |
| `let` vs `const`                              | `let` — wartość może się zmieniać; `const` — nie może być ponownie przypisana           |
| `zmienna++` / `zmienna--`                     | Skrócony zapis zwiększenia / zmniejszenia zmiennej o 1                                  |
| Mechanizm zawijania (`if` resetujący licznik) | Sprawdza wyjście licznika poza zakres i ustawia go na przeciwnym końcu (efekt pętli)    |
| `querySelector("#id tag")`                    | Wyszukuje element danego typu wewnątrz elementu o podanym identyfikatorze               |
| `liczba + ".jpg"` (konkatenacja)              | Łączenie liczby i tekstu operatorem `+` — liczba jest automatycznie zamieniana na tekst |
| Zasada DRY (_Don't Repeat Yourself_)          | Wspólna logika (aktualizacja obrazka) wydzielona do jednej funkcji zamiast powielana    |

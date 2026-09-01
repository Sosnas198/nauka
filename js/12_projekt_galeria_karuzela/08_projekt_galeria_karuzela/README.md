# Kompletny przewodnik: Karuzela zdjęć z zawijaniem indeksu (przewijanie w kółko, w obie strony)

Ten przewodnik tłumaczy **od A do Z**, jak działa skrypt galerii zdjęć, w którym przyciski `<` i `>` przełączają aktywne zdjęcie, a po dojściu do ostatniego lub pierwszego zdjęcia licznik "zawija się" na drugi koniec listy.

---

## 📁 Zawartość projektu

```text
08_projekt_galeria_karuzela/
│
├── README.md         ← ten plik, teoria krok po kroku
├── index.html         ← pełny, oryginalny plik HTML
└── skrypt.js           ← pełny, oryginalny plik JS
```

> ⚠️ **Uwaga:** Kod odwołuje się do plików `styl.css` oraz zdjęć `1.jpg` – `7.jpg`, których nie było w treści zadania — musisz sam dodać je do folderu, aby strona wyglądała poprawnie.

---

## 🎯 Cel skryptu

W bloku środkowym strony wyświetlane jest zawsze jedno, "aktywne" zdjęcie (`<img src="1.jpg">` na początku). Przycisk `>` ma pokazać **następne** zdjęcie w kolejności numerycznej (np. z `1.jpg` na `2.jpg`), a przycisk `<` — **poprzednie**. Gdy licznik dojdzie do końca listy (zdjęcie `7.jpg`) i użytkownik kliknie `>`, galeria ma "zawinąć się" z powrotem do `1.jpg` — i analogicznie w drugą stronę.

> **Główna idea:**
> **ZMIEŃ LICZNIK → SPRAWDŹ, CZY WYSZEDŁ POZA ZAKRES → JEŚLI TAK, ZAWIŃ GO NA DRUGI KONIEC → ZAKTUALIZUJ OBRAZEK NA STRONIE**

---

## SEC-1: Zmienne przechowujące aktualny numer zdjęcia i liczbę wszystkich zdjęć

```javascript
let zdjecieIndex = 1;
const zdjecia = 7;
```

### Jak to działa?

- **`let zdjecieIndex = 1;`** — tworzymy zmienną `zdjecieIndex`, która **zawsze** przechowuje numer aktualnie wyświetlanego zdjęcia. Zaczynamy od `1`, bo strona ładuje się z widocznym zdjęciem `1.jpg`. Użyto słowa kluczowego **`let`** (a nie `const`), ponieważ wartość tej zmiennej **będzie się zmieniać** za każdym kliknięciem przycisku.
- **`const zdjecia = 7;`** — to stała przechowująca **łączną liczbę zdjęć** w galerii (tutaj: 7, zgodnie z miniaturami `1.jpg` – `7.jpg` widocznymi w HTML). Użyto **`const`**, ponieważ ta wartość **nigdy się nie zmienia** w trakcie działania skryptu — galeria zawsze ma dokładnie 7 zdjęć.
- Te dwie zmienne są zdefiniowane **na zewnątrz** wszystkich funkcji (na tzw. poziomie globalnym pliku), dzięki czemu wszystkie trzy funkcje (`kolejne()`, `poprzednie()`, `aktualizacja()`) mogą je odczytywać i modyfikować — gdyby były zadeklarowane wewnątrz jednej funkcji, pozostałe funkcje nie miałyby do nich dostępu.

---

## SEC-2: Funkcja `kolejne()` — przejście do następnego zdjęcia z zawijaniem

```javascript
function kolejne() {
    zdjecieIndex++;
    if (zdjecieIndex > zdjecia) {
        zdjecieIndex = 1;
    }
    aktualizacja();
}
```

### Jak to działa?

- **`zdjecieIndex++;`** — operator **`++`** oznacza *"zwiększ tę zmienną o 1"* (to skrót od `zdjecieIndex = zdjecieIndex + 1`). Jeśli przed kliknięciem `zdjecieIndex` wynosiło np. `3`, po tej linijce będzie wynosić `4`.
- **`if (zdjecieIndex > zdjecia) { zdjecieIndex = 1; }`** — to jest właśnie mechanizm **"zawijania"** (ang. *wrapping*), o którym mowa w treści zadania. Sprawdzamy, czy licznik **przekroczył** liczbę wszystkich zdjęć (czyli `7`). Jeśli tak — oznacza to, że wyświetlane było ostatnie zdjęcie (`7.jpg`) i próbujemy przejść "dalej", więc **resetujemy licznik z powrotem do `1`**, zamiast pozwolić mu rosnąć w nieskończoność (co pokazywałoby nieistniejące zdjęcia, np. `8.jpg`).
- **`aktualizacja();`** — na końcu funkcji wywołujemy osobną funkcję `aktualizacja()` (patrz SEC-4), która faktycznie **zmienia obrazek widoczny na stronie** na podstawie aktualnej wartości `zdjecieIndex`. Same funkcje `kolejne()` i `poprzednie()` **nie dotykają** bezpośrednio elementu `<img>` — tylko zmieniają licznik, a "brudną robotę" (aktualizację ekranu) zlecają wspólnej, osobnej funkcji.

---

## SEC-3: Funkcja `poprzednie()` — przejście do poprzedniego zdjęcia z zawijaniem

```javascript
function poprzednie() {
    zdjecieIndex--;
    if (zdjecieIndex < 1) {
        zdjecieIndex = zdjecia;
    }
    aktualizacja();
}
```

### Jak to działa?

- **`zdjecieIndex--;`** — operator **`--`** oznacza *"zmniejsz tę zmienną o 1"* (skrót od `zdjecieIndex = zdjecieIndex - 1`).
- **`if (zdjecieIndex < 1) { zdjecieIndex = zdjecia; }`** — to lustrzane odbicie mechanizmu z funkcji `kolejne()`. Sprawdzamy, czy licznik **spadł poniżej** `1` (czyli licznik próbuje zejść "przed" pierwsze zdjęcie). Jeśli tak, oznacza to, że wyświetlane było pierwsze zdjęcie (`1.jpg`) i użytkownik kliknął "wstecz", więc **ustawiamy licznik na wartość `zdjecia`** (czyli `7`) — galeria "zawija się" na sam koniec listy.
- **`aktualizacja();`** — dokładnie tak samo jak w `kolejne()`, na końcu wywołujemy wspólną funkcję aktualizującą obrazek na ekranie.

---

## SEC-4: Funkcja `aktualizacja()` — wspólna funkcja zmieniająca obrazek na stronie

```javascript
function aktualizacja() {
    const zdjecieElement = document.querySelector("#srodkowy img");
    zdjecieElement.src = zdjecieIndex + ".jpg";
}
```

### Jak to działa?

- **`document.querySelector("#srodkowy img")`** — wyszukuje znacznik `<img>` znajdujący się wewnątrz elementu o identyfikatorze `srodkowy` (czyli tego głównego, dużego obrazka pośrodku strony — a nie jednej z siedmiu miniatur na dole).
- **`zdjecieElement.src = zdjecieIndex + ".jpg";`** — ustawiamy atrybut `src` tego obrazka na nowy tekst, zbudowany przez **połączenie** (konkatenację) aktualnej wartości licznika `zdjecieIndex` z tekstem `".jpg"`. Operator **`+`** między liczbą a tekstem w JavaScript automatycznie zamienia liczbę na tekst i skleja je razem — np. jeśli `zdjecieIndex` wynosi `4`, wynikiem będzie tekst `"4.jpg"`.
- Dzięki temu, że ta logika (znalezienie obrazka + ustawienie jego `src`) znajduje się w **jednej, osobnej funkcji**, obie funkcje `kolejne()` i `poprzednie()` mogą z niej korzystać, zamiast powtarzać ten sam kod dwa razy. To dobra praktyka programistyczna zwana **DRY** (*Don't Repeat Yourself* — "nie powtarzaj się").

---

## 🧩 Cały mechanizm krok po kroku (na przykładzie kliknięcia `>` przy ostatnim zdjęciu)

```text
1. zdjecieIndex = 7 (wyświetlane jest 7.jpg)
              ↓
2. Użytkownik klika przycisk ">"
              ↓
3. Wywołanie: kolejne()
              ↓
4. zdjecieIndex++  →  zdjecieIndex = 8
              ↓
5. if (zdjecieIndex > zdjecia)  →  8 > 7  →  PRAWDA
              ↓
6. zdjecieIndex = 1  (zawinięcie na początek)
              ↓
7. aktualizacja()
              ↓
8. document.querySelector("#srodkowy img").src = "1.jpg"
              ↓
9. Na stronie widoczne jest teraz zdjęcie 1.jpg
```

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Operator**       | **Co oznacza / Co robi?**                                                                        |
| ------------------------------- | ---------------------------------------------------------------------------------------------------|
| `let` vs `const`                  | `let` deklaruje zmienną, której wartość **może się zmieniać**; `const` deklaruje stałą, która **nie może** być ponownie przypisana. |
| `zmienna++` / `zmienna--`          | Skrócony zapis zwiększenia/zmniejszenia zmiennej o 1.                                                |
| Mechanizm "zawijania" (`if` resetujący licznik) | Sprawdzenie, czy licznik wyszedł poza dozwolony zakres, i ustawienie go z powrotem na przeciwny koniec zakresu — tworzy efekt "pętli" (karuzeli). |
| `querySelector("#id tag")`         | Wyszukuje element danego typu (np. `img`) znajdujący się wewnątrz elementu o podanym identyfikatorze. |
| `liczba + ".jpg"` (konkatenacja)   | Łączenie liczby i tekstu operatorem `+` — JavaScript automatycznie zamienia liczbę na tekst.          |
| Zasada DRY (*Don't Repeat Yourself*) | Wydzielenie wspólnej, powtarzającej się logiki (tu: aktualizacja obrazka) do jednej, osobnej funkcji, zamiast powielania kodu. |

# Bardzo szczegółowe opracowanie materiału: Instrukcja warunkowa `switch` w JavaScript

Materiały przedstawiają zasadę działania instrukcji `switch` w języku JavaScript, rolę słowa kluczowego `break`, zjawisko _fall-through_ oraz porównanie zastosowań instrukcji `switch` i `if`.

## 1. Jak działa `switch` pod maską?

Instrukcja `switch` działa jak **automatyczna centrala telefoniczna**. Zamiast sprawdzać każdy warunek sekwencyjnie krok po kroku (tak jak robi to ciąg instrukcji `if ... else if`), `switch` analizuje wartość zmiennej podanej w nawiasie `switch(zmienna)` i natychmiast przeskakuje do właściwej gałęzi `case`.

### Przykładowa składnia:

**JavaScript**

```javascript
switch (numer) {
  case 1:
    cena = waga * 5;
    break;
  default:
    cena = 0;
}
```

### Elementy składowe instrukcji `switch`:

- **`switch(numer)`** – wskazuje zmienną (w tym przypadku `numer`), której wartość będzie porównywana.
- **`case 1:`** – oznacza warunek ścisłego porównania: **"Czy `numer === 1`?"**. Jeżeli tak, komputer zaczyna wykonywać kod umieszczony pod tym przypadkiem.
- **`default:`** – odpowiednik instrukcji `else`. Stanowi koło ratunkowe – kod w bloku `default` wykona się wtedy, gdy wartość zmiennej nie dopasowała się do żadnego z wcześniejszych przypadków `case` (np. użytkownik podał numer `5` albo wpisał tekst).

## 2. Rola słowa kluczowego `break` oraz zjawisko "fall-through"

Słowo kluczowe **`break`** (z ang. _przerwij_) jest najważniejszą instrukcją sterującą wewnątrz bloku `switch`. Wydaje ono komputerowi polecenie: **"Zakończ wykonywanie kodu, wyjdź z bloku `switch` i nie sprawdzaj ani nie wykonuj niczego poniżej"**.

### Co się dzieje, gdy zapomnisz o `break`? (Efekt "Fall-through")

Jeśli pominiesz słowo `break` na końcu danej gałęzi `case`, w JavaScript zajdzie tzw. **efekt "fall-through"** (wpadanie w kolejne klocki). Przeglądarka po wykonaniu kodu z dopasowanego `case` będzie kontynuować ślepe wykonywanie instrukcji z następnych bloków `case 2`, `case 3` i `default`, ignorując to, czy ich warunki są spełnione.

#### Przykład braku `break`:

**JavaScript**

```javascript
switch (numer) {
  case 1:
    cena = waga * 5; // Jeśli numer === 1, to wyliczy się cena podstawowa
  case 2:
    cena = waga * 10; // BEZ break skrypt przejdzie tutaj i NADPIŚE cenę!
  default:
    cena = 0; // Na końcu nadpisze cenę na 0!
}
```

> **Konsekwencja:** Gdyby `numer` wynosił `1`, bez użycia `break` komputer przeszedłby przez wszystkie kolejne bloki aż do `default`, ustalając ostateczną wartość `cena` na `0`. Dlatego stosowanie `break` po każdym przypadku `case` jest kluczowe dla poprawnego działania skryptu.

## 3. Porównanie: `if` vs `switch` – Kiedy co wybierać?

Rozstrzygnięcie, którą instrukcję sterującą należy zastosować w kodzie, zależy od struktury sprawdzanych warunków:

### A. Kiedy wybrać `switch`?

- Gdy porównujesz **jedną konkretną zmienną** z wieloma pojedynczymi, stałymi wartościami (np. czy `numer` równa się `1`, `2`, `3` lub czy `kolor` to `"czerwony"`, `"zielony"`).
- Kod staje się wtedy znacznie czytelniejszy, czystszy i łatwiejszy w rozbudowie o kolejne przypadki (`case`).

### B. Kiedy wybrać `if`?

- Gdy musisz sprawdzić **złożone warunki logiczne, przedziały liczbowe lub relacje większości/mniejszości**.
- **Przykład:** Sprawdzenie, czy waga mieści się w przedziale od 10 do 50 (`if (waga > 10 && waga < 50)`). Tego typu warunków przedziałowych nie da się łatwo zapisać w klasycznej strukturze `switch`.

## Podsumowanie zestawieniowe

```text
+--------------------------+-------------------------------------+-------------------------------------+
| Cecha                    | Instrukcja switch                   | Instrukcja if ... else              |
+--------------------------+-------------------------------------+-------------------------------------+
| Typ sprawdzanych danych  | Pojedyncze, konkretne wartości     | Przedziały, nierówności, złożone    |
|                          | (np. x === 5, x === "tak")          | warunki (np. x > 10 && y < 20)      |
| Sposób działania         | Przeskok bezpośrednio do case       | Sprawdzanie kolejno od góry do dołu |
| Wymagane słowo sterujące | break (zapobiega fall-through)     | Brak (bloki ograniczają klamry {})  |
| Sekcja domyślna          | default:                            | else { ... }                        |
+--------------------------+-------------------------------------+-----------------------
```

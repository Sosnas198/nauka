# Kompletny przewodnik: Sprawdzanie zaznaczonego przycisku radio i obliczanie ceny promocyjnej

Ta ściąga wytłumaczy Ci **od A do Z**, jak JavaScript sprawdza, którą długość włosów zaznaczył użytkownik, oraz jak na tej podstawie wylicza cenę promocyjną (niższą o 10 zł od ceny standardowej).

---

## SEC-1: Sprawdzenie pierwszej opcji (`if (krotkie.checked)`)

```javascript
if (krotkie.checked) {
    cena = 25 - 10;
}
```

### Jak to działa?

- **`krotkie`** – to zmienna z modułu 01, przechowująca przycisk radio o `id="krotkie"`.
- **`.checked`** – to właściwość (informacja) każdego przycisku typu radio (i checkbox), mówiąca, czy jest on **aktualnie zaznaczony**. Zwraca `true` (zaznaczony) albo `false` (niezaznaczony).
- **`if (krotkie.checked)`** – oznacza więc: *"jeśli przycisk 'Krótkie' jest zaznaczony"*. Zwróć uwagę, że w HTML przycisk ten ma dodatkowo atrybut `checked`, więc jest domyślnie zaznaczony od razu po wejściu na stronę (zanim użytkownik cokolwiek kliknie).
- **`cena = 25 - 10;`** – jeśli warunek jest prawdziwy, do wcześniej utworzonej zmiennej `cena` (z modułu 01, tam ustawionej na `0`) przypisujemy nową wartość: `25 - 10 = 15`. Liczba `25` to (zgodnie z kodem) cena standardowa dla krótkich włosów, a odjęcie `10` to właśnie ta obiecana w zadaniu **promocja o 10 zł taniej**.
- Zwróć uwagę, że nie piszemy `let cena = ...` ponownie — to by stworzyło **nową**, osobną zmienną. Tutaj tylko **przypisujemy nową wartość** do zmiennej `cena`, która już istnieje (została zadeklarowana w module 01 przez `let cena = 0;`).

---

## SEC-2: Sprawdzenie pozostałych opcji (`else if`)

```javascript
else if (srednie.checked) {
    cena = 30 - 10;
}
else if (poldlugie.checked) {
    cena = 40 - 10;
}
else if (dlugie.checked) {
    cena = 50 - 10;
}
```

### Jak to działa?

- **`else if (...)`** – to kolejne "piętra" tego samego warunku `if` z SEC-1. Działają one na zasadzie: *"a jeśli poprzedni warunek nie był prawdziwy, sprawdź ten"*. JavaScript sprawdza je **po kolei, od góry**, i wykonuje **tylko pierwszy pasujący** blok — reszta jest wtedy pomijana.
- Ponieważ wszystkie cztery przyciski radio należą do tej samej grupy (wspólny `name="wlosy"`), **tylko jeden z nich może być zaznaczony naraz** — więc dokładnie jeden z tych czterech warunków (`krotkie.checked`, `srednie.checked`, `poldlugie.checked`, `dlugie.checked`) będzie prawdziwy, a pozostałe trzy fałszywe.
- Każdy kolejny blok działa analogicznie do SEC-1, tylko dla innej długości włosów i innej ceny bazowej:
  - `srednie.checked` → `cena = 30 - 10` (czyli `20`)
  - `poldlugie.checked` → `cena = 40 - 10` (czyli `30`)
  - `dlugie.checked` → `cena = 50 - 10` (czyli `40`)
- Po przejściu przez cały ten łańcuch `if / else if`, zmienna `cena` zawiera już dokładnie tę wartość, która odpowiada wybranej przez użytkownika opcji — gotową do wyświetlenia w module 03.

> **Ważna uwaga:** Odjęcie `- 10` jest zapisane bezpośrednio w każdej linijce (np. `25 - 10`), zamiast jako osobny krok na końcu. To trochę mniej "uniwersalne" rozwiązanie (gdyby promocja się zmieniła, trzeba by poprawić cztery linijki zamiast jednej), ale jest w pełni zgodne z wymaganiem zadania: *"cena promocyjna jest o 10 zł niższa od ceny strzyżenia"* — dla każdej z czterech opcji osobno.

---

# Podsumowanie przepływu danych

```text
SEC-1: if (krotkie.checked) { cena = 25 - 10; }
       — Sprawdzenie pierwszej opcji i przypisanie ceny promocyjnej
                 ↓
SEC-2: else if (srednie.checked) { cena = 30 - 10; }
       else if (poldlugie.checked) { cena = 40 - 10; }
       else if (dlugie.checked) { cena = 50 - 10; }
       — Sprawdzenie pozostałych trzech opcji, po kolei
                 ↓
       cena — gotowa wartość ceny promocyjnej, odpowiadająca zaznaczonej opcji
       (dalej: moduł 03 — wyświetlenie wyniku na stronie)
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Metoda**    | **Co oznacza / Co robi?**                                                                |
| ---------------------------- | ------------------------------------------------------------------------------------------- |
| **`.checked`**                | Właściwość przycisku radio/checkbox — `true`, jeśli jest zaznaczony.                         |
| **`if / else if`**            | Łańcuch warunków sprawdzanych po kolei — wykonuje się tylko pierwszy pasujący blok.           |
| **przypisanie do istniejącej zmiennej** | `cena = ...` (bez `let`) zmienia wartość zmiennej już zadeklarowanej wcześniej.     |

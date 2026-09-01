# Kompleksowy kurs JavaScript & DOM: Fryzjerstwo — promocyjna cena strzyżenia

Witaj w projekcie **07_projekt_fryzjerstwo**!

Ten przewodnik prowadzi Cię **krok po kroku** przez proces budowania skryptu, który:

1. pobiera element wynikowy oraz wszystkie cztery przyciski radio (długości włosów),
2. sprawdza, którą opcję zaznaczył użytkownik,
3. oblicza cenę promocyjną (o 10 zł niższą od ceny standardowej),
4. wyświetla wynik w paragrafie pod przyciskiem, zgodnie z wymaganym wzorem.

Cały projekt został podzielony na **3 spójne moduły**.

> **Główna idea:**
> **POBIERZ ELEMENTY → SPRAWDŹ WYBÓR I OBLICZ CENĘ → WYŚWIETL WYNIK**

---

# 📁 Architektura i struktura projektu

```text
07_projekt_fryzjerstwo/
│
├── 01_pobieranie_wybranej_opcji/
│   ├── README.md
│   └── script.js
│
├── 02_obliczanie_ceny_promocyjnej/
│   ├── README.md
│   └── script.js
│
├── 03_wyswietlanie_wyniku/
│   ├── README.md
│   └── script.js
│
└── README.md
    └── Główny przewodnik projektu
```

> **Ważna uwaga:** W oryginalnym kodzie wszystkie trzy moduły to fragmenty **jednej, wspólnej** funkcji `odkryj()`, uruchamianej przyciskiem `<button onclick="odkryj()">Odkryj promocję</button>` na stronie `fryzura.html`. Podzielono ją na osobne pliki dla przejrzystości nauki — każdy `script.js` zaczyna się od `function odkryj() { ... }`, żeby dało się go otworzyć bez błędu składni, ale moduły 02 i 03 są w rzeczywistości **kontynuacją** tej samej funkcji. Pełny, złożony razem kod znajdziesz w sekcji "Wzorzec końcowy" na dole tego README.

---

# 🔗 Jak to się ma do wymagań zadania?

- **"Uruchamia się po wciśnięciu przycisku na stronie fryzura.html"** → cała funkcja `odkryj()`, wywoływana przez `onclick="odkryj()"`
- **"Na podstawie wybranego przycisku radio wyświetla promocyjną cenę"** → moduł `01_pobieranie_wybranej_opcji` (pobranie przycisków) + moduł `02_obliczanie_ceny_promocyjnej` (sprawdzenie `.checked`)
- **"Cena promocyjna jest o 10 zł niższa od ceny strzyżenia"** → moduł `02_obliczanie_ceny_promocyjnej` (odjęcie `- 10` dla każdej opcji)
- **"Wynik wyświetla się w akapicie pod przyciskiem wg wzoru «cena promocyjna: »"** → moduł `03_wyswietlanie_wyniku`

---

# 🔄 Przepływ logiki

```text
┌───────────────────────────────────────────┐
│  01_pobieranie_wybranej_opcji              │
│  wynik = getElementById("wynik")           │
│  cena = 0                                  │
│  krotkie, srednie, poldlugie, dlugie       │
│      = getElementById(...)                 │
└──────────────────┬─────────────────────────┘
                   ▼
┌───────────────────────────────────────────┐
│  02_obliczanie_ceny_promocyjnej            │
│  if (krotkie.checked) cena = 25 - 10       │
│  else if (srednie.checked) cena = 30 - 10  │
│  else if (poldlugie.checked) cena = 40-10  │
│  else if (dlugie.checked) cena = 50 - 10   │
└──────────────────┬─────────────────────────┘
                   ▼
┌───────────────────────────────────────────┐
│  03_wyswietlanie_wyniku                    │
│  wynik.innerHTML =                         │
│    "<p>cena promocyjna: " + cena + "</p>"  │
└──────────────────┬─────────────────────────┘
                   ▼
┌───────────────────────────────────────────┐
│              WIDOK STRONY                 │
│   💇 np. "cena promocyjna: 15" pod          │
│      przyciskiem "Odkryj promocję"         │
└────────────────────────────────────────────┘
```

---

# 📚 Jak uczyć się z tego projektu?

## Moduł 1 — `01_pobieranie_wybranej_opcji`
**Cel:** Przygotowanie "uchwytów" do elementu wynikowego i wszystkich przycisków radio.
**Czego się nauczysz:**
- **[SEC-1]** `document.getElementById()`, różnica między `let` a `const`
- **[SEC-2]** Pobranie grupy przycisków radio połączonych wspólnym `name`

## Moduł 2 — `02_obliczanie_ceny_promocyjnej`
**Cel:** Sprawdzenie, który przycisk jest zaznaczony, i wyliczenie ceny promocyjnej.
**Czego się nauczysz:**
- **[SEC-1]** Właściwość `.checked` i pierwszy warunek `if`
- **[SEC-2]** Łańcuch `else if` sprawdzający pozostałe opcje po kolei

## Moduł 3 — `03_wyswietlanie_wyniku`
**Cel:** Wstawienie wyniku do paragrafu na stronie.
**Czego się nauczysz:** `.innerHTML` i sklejanie tekstu ze zmienną operatorem `+`.

---

# 🧩 Cały mechanizm krok po kroku

```text
1. Użytkownik zaznacza długość włosów i klika "Odkryj promocję"
              ↓
2. wynik = getElementById("wynik"); cena = 0
              ↓
3. krotkie, srednie, poldlugie, dlugie = getElementById(...)
              ↓
4. if (krotkie.checked) cena = 25 - 10
   else if (srednie.checked) cena = 30 - 10
   else if (poldlugie.checked) cena = 40 - 10
   else if (dlugie.checked) cena = 50 - 10
              ↓
5. wynik.innerHTML = "<p>cena promocyjna: " + cena + "</p>"
              ↓
6. 💇 wynik widoczny na stronie pod przyciskiem
```

---

# 🧠 Podsumowanie i wzorce do zapamiętania

| Moduł / Pojęcie                       | Kluczowa funkcja / właściwość     | Zastosowanie                                            |
| ------------------------------------------ | --------------------------------------- | -------------------------------------------------------------- |
| `01_pobieranie_wybranej_opcji`              | `document.getElementById()`             | Pobranie elementu wynikowego i przycisków radio                 |
| `let` vs `const`                            | Deklaracja zmiennych                    | `let` dla wartości, które się zmienią; `const` dla stałych uchwytów |
| `02_obliczanie_ceny_promocyjnej`            | `.checked`                              | Sprawdzenie, który przycisk radio jest zaznaczony                |
| `if / else if`                              | Łańcuch warunków                        | Wybór odpowiedniej ceny bazowej wg zaznaczonej opcji              |
| `03_wyswietlanie_wyniku`                    | `.innerHTML`                            | Wstawienie wyniku jako fragmentu HTML na stronę                  |
| operator `+`                                | Sklejanie tekstu i liczby               | Zbudowanie gotowego zdania z wynikiem                              |

---

# 🎯 Wzorzec końcowy do zapamiętania (kod złożony w całość)

```javascript
function odkryj() {
    let wynik = document.getElementById("wynik");
    let cena = 0;
    const krotkie = document.getElementById('krotkie');
    const srednie = document.getElementById('srednie');
    const poldlugie = document.getElementById('poldlugie');
    const dlugie = document.getElementById('dlugie');
    if (krotkie.checked) {
        cena = 25 - 10;
    }
    else if (srednie.checked) {
        cena = 30 - 10;
    }
    else if (poldlugie.checked) {
        cena = 40 - 10;
    }
    else if (dlugie.checked) {
        cena = 50 - 10;
    }
    wynik.innerHTML = "<p>cena promocyjna: " + cena + "</p>";
}
```

---

# 🚀 Najważniejsza logika

```text
POBIERZ ELEMENTY
   ↓
SPRAWDŹ ZAZNACZONĄ OPCJĘ (if / else if + .checked)
   ↓
OBLICZ CENĘ (cena bazowa - 10)
   ↓
WYŚWIETL WYNIK (innerHTML)
```

Czyli:

> **`getElementById()` → `.checked` w łańcuchu `if/else if` → `cena_bazowa - 10` → `innerHTML = "<p>cena promocyjna: " + cena + "</p>"`**

To jest cały podstawowy przepływ od **zaznaczenia opcji przez użytkownika** do **wyświetlenia wyliczonej ceny promocyjnej na stronie**.

> **Uwaga:** Zwróć uwagę, że cena bazowa dla "Krótkich" włosów w skrypcie (`25`) różni się od wartości w tabeli cennika na stronie (`30`). To wartość wzięta wprost z przesłanego, gotowego kodu — nie została przeze mnie zmieniona.

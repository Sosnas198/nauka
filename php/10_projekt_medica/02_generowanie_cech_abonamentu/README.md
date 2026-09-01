> **Krok 2 z 2** | [W Kroku 1](../01_wyswietlanie_pakietow/README.md) wypisałeś nazwy i opisy. Teraz **Skrypt 2**: cechy pakietów 1, 2 i 3 przez tabelę łączącą i listę `<ul>`.

---

# Kompletny przewodnik: Skrypt 2 — `JOIN` cech i elementy `<li>`

Ta ściąga wytłumaczy Ci **od A do Z** relację abonament–cecha, zapytanie z dwoma `JOIN` oraz **trzy kopie** tego samego SQL z innym `id`.

---

## SEC-1: Tabela łącząca `szczegolyabonamentu`

- Jeden abonament ma **wiele** cech.
- Jedna cecha (np. „wizyty domowe”) może być w **wielu** pakietach.

Pary kluczy siedzą w **`szczegolyabonamentu`**: `Abonamenty_id` i `Cechy_id` (takie nazwy kolumn są w zapytaniu z arkusza). Tekst cechy jest w tabeli **`cechy`**.

Bez `JOIN` masz tylko numery, nie treść do `<li>`.

---

## SEC-2: Zapytanie złączenia (wzorzec z arkusza)

```sql
SELECT nazwa, cecha
FROM abonamenty
JOIN szczegolyabonamentu ON abonamenty.id = Abonamenty_id
JOIN cechy ON cechy.id = Cechy_id
WHERE abonamenty.id = 1;
```

- Pierwszy `JOIN` — które cechy ma ten abonament.
- Drugi `JOIN` — jak się ta cecha nazywa (`cecha`).
- **`WHERE abonamenty.id = X`** — **X** to 1, 2 albo 3 (trzy sekcje HTML).

Na stronie potrzebujesz do listy tylko **`$row["cecha"]`**. Kolumna `nazwa` (pakietu) jest w SELECT z arkusza, ale w `<li>` jej nie wypisujesz — nagłówek sekcji (`<h2>Standardowy</h2>`) jest na sztywno w HTML.

Wiele cech → **`while`**.

---

## SEC-3: Trzy sekcje — `id = 1`, `id = 2`, `id = 3`

| Sekcja HTML     | Pakiet (z kontrolki) | Warunek SQL            |
| --------------- | -------------------- | ---------------------- |
| `#pierwszy`     | Standardowy          | `abonamenty.id = 1`    |
| `#drugi`        | Premium              | `abonamenty.id = 2`    |
| `#trzeci`       | Dziecko              | `abonamenty.id = 3`    |

To **trzy osobne** bloki PHP. Nie robisz jednej pętli po abonamentach — układ strony ma trzy gotowe `<ul>`.

W każdym bloku zmieniasz tylko cyfrę w `WHERE`. Reszta zapytania jest identyczna.

---

## SEC-4: Elementy listy wypunktowanej

`<ul>` i `<h2>` są w HTML. PHP wstawia wyłącznie:

```php
while ($row = $result->fetch_assoc()) {
    echo "<li>" . $row["cecha"] . "</li>";
}
```

Nie otwierasz drugiego `<ul>` w skrypcie. To lista **wypunktowana** (`ul`), nie numerowana (`ol`).

---

# Podsumowanie przepływu danych

```text
JOIN abonamenty → szczegolyabonamentu → cechy
WHERE abonamenty.id = 1 | 2 | 3
                 ↓
while fetch_assoc
                 ↓
<li>cecha</li>   wewnątrz gotowego <ul>
```

---

# Ściągawka

| **Pojęcie**                    | **Co robi?**                                  |
| ------------------------------ | --------------------------------------------- |
| **`szczegolyabonamentu`**      | Tabela łącząca pakiet z cechą.                |
| **`Abonamenty_id` / `Cechy_id`** | Kolumny powiązań z arkusza.                 |
| **`WHERE abonamenty.id = 1`**  | Standardowy; `2` Premium; `3` Dziecko.        |
| **`<li>`**                     | Jedna cecha w liście wypunktowanej.           |

---

### Gratulacje!

Masz pełny cykl Medica: opisy wszystkich pakietów oraz cechy trzech abonamentów ze złączenia.

🏠 **[Wróć do głównego spisu treści](../README.md)**

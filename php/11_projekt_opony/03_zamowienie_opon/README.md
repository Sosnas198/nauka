> **Krok 3 z 3** | [W Kroku 2](../02_opona_dnia/README.md) pokazałeś stałą oponę dnia. Teraz **Skrypt 3**: jedno **losowe** zamówienie, `JOIN` po `nr_kat` i wartość `ilość * cena`.

---

# Kompletny przewodnik: Skrypt 3 — `JOIN USING`, `RAND()` i wartość zamówienia

Ta ściąga wytłumaczy Ci **od A do Z** złączenie `zamowienie` z `opony`, losowanie jednego wiersza oraz mnożenie w PHP.

---

## SEC-1: Zapytanie — `USING (nr_kat)` i `ORDER BY RAND() LIMIT 1`

```sql
SELECT id_zam, ilosc, model, cena
FROM zamowienie
JOIN opony USING (nr_kat)
ORDER BY RAND()
LIMIT 1;
```

- **`JOIN … USING (nr_kat)`** — obie tabele mają kolumnę o **tej samej nazwie** `nr_kat`. Skrót zamiast `ON zamowienie.nr_kat = opony.nr_kat`.
- **`ilosc`** — z `zamowienie`; **`model`** i **`cena`** — z `opony`.
- **`ORDER BY RAND() LIMIT 1`** — przy każdym załadowaniu (także po `Refresh: 10`) inne zamówienie.

Jeden wiersz → jedno `fetch_assoc()`.

---

## SEC-2: Wartość zamówienia — `ilosc * cena`

```php
$wartosc_zamowienia = $row["ilosc"] * $row["cena"];
```

Mnożenie w **PHP** (jak `cena * waga` na bazarze). Nie używasz tu `AVG`.

---

## SEC-3: Podsumowanie w nagłówkach `<h2>`

Kontrolka:

```php
echo "<h2>Zamówienie nr " . $row["id_zam"] . ": " . $row["ilosc"] . " sztuki modelu " . $row["model"] . "</h2>";
echo "<h2>Wartość zamówienia: " . $wartosc_zamowienia . " zł</h2>";
```

Jednostka wartości: **`zł`**. Stały nagłówek HTML: `<h2>Najnowsze zamówienie</h2>` — skrypt dopisuje dwa kolejne `h2`.

---

# Podsumowanie przepływu danych

```text
zamowienie JOIN opony USING (nr_kat)
ORDER BY RAND() LIMIT 1
                 ↓
wartosc = ilosc * cena
                 ↓
<h2>Zamówienie nr … : … sztuki modelu …</h2>
<h2>Wartość zamówienia: … zł</h2>
```

---

# Ściągawka

| **Pojęcie**              | **Co robi?**                                 |
| ------------------------ | -------------------------------------------- |
| **`USING (nr_kat)`**     | JOIN po wspólnej kolumnie.                   |
| **`RAND() LIMIT 1`**     | Jedno losowe zamówienie.                     |
| **`ilosc * cena`**       | Wartość do drugiego `<h2>`.                  |
| **`Refresh: 10`**        | Co 10 s nowe losowanie (ten sam skrypt).     |

---

### Gratulacje!

Masz pełny cykl sklepu: lista sezonów, opona dnia i losowe zamówienie z odświeżaniem strony.

🏠 **[Wróć do głównego spisu treści](../README.md)**

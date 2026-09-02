Przeanalizujmy cały ten proces krok po kroku na konkretnym zapytaniu, które używa niemal wszystkich klauzul naraz.

Wyobraź sobie tabelę **`zamowienia`**:

| **id** | **klient** | **kategoria** | **kwota** | **status** |
| ------ | ---------- | ------------- | --------- | ---------- |
| 1      | Ania       | Elektronika   | 100 zł    | wysłane    |
| 2      | Tomek      | Odzież        | 50 zł     | wysłane    |
| 3      | Ania       | Elektronika   | 200 zł    | anulowane  |
| 4      | Tomek      | Elektronika   | 150 zł    | wysłane    |
| 5      | Ania       | Elektronika   | 300 zł    | wysłane    |
| 6      | Bartek     | Odzież        | 500 zł    | wysłane    |

Chcemy znaleźć klientów, którzy na **wysłane** zamówienia z kategorii **Elektronika** wydali **łącznie ponad 200 zł**. Wynik chcemy posortować od najmniejszej kwoty.

Oto zapytanie SQL, które wpisujesz do bazy:

SQL

```sql
SELECT klient, SUM(kwota) AS suma_wydatkow
FROM zamowienia
WHERE kategoria = 'Elektronika' AND status = 'wysłane'
GROUP BY klient
HAVING SUM(kwota) > 200
ORDER BY suma_wydatkow ASC;
```

### Jak baza danych przetwarza to zapytanie (krok po kroku):

**Krok 1:** **`FROM zamowienia`**

Baza otwiera tabelę `zamowienia` i ładuje do pamięci roboczej wszystkie 6 wierszy.

**Krok 2:** **`WHERE kategoria = 'Elektronika' AND status = 'wysłane'`**

Baza sprawdzaj każdy wiersz osobno i odrzuca te, które nie spełniają warunków:

- Wiersz 2 (Tomek, Odzież) — **odrzucamy** (zła kategoria).
- Wiersz 3 (Ania, Elektronika, anulowane) — **odrzucamy** (zły status).
- Wiersz 6 (Bartek, Odzież) — **odrzucamy** (zła kategoria).

Do dalszej pracy przechodzą tylko 3 wiersze:

- Wiersz 1: Ania | Elektronika | 100 zł | wysłane
- Wiersz 4: Tomek | Elektronika | 150 zł | wysłane
- Wiersz 5: Ania | Elektronika | 300 zł | wysłane

**Krok 3:** **`GROUP BY klient`**

Baza bierze te 3 przefiltrowane wiersze i rozdziela je do „szufladek” według wartości w kolumnie `klient`:

- **Pudełko „Ania”:** Wiersz 1 (100 zł), Wiersz 5 (300 zł)
- **Pudełko „Tomek”:** Wiersz 4 (150 zł)

**Krok 4:** **`HAVING SUM(kwota) > 200`**

Baza wylicza sumę dla każdego pudełka i odrzuca grupy, które nie osiągają wartości 200:

- Pudełko Ania: `100 + 300 = 400 zł` (spełnia warunek)
- Pudełko Tomek: `150 zł` (nie spełnia warunku `150 > 200` — **grupa Tomka odpada**).

W tym momencie w pamięci pozostaje już tylko grupa **Ania**.

**Krok 5:** **`SELECT klient, SUM(kwota) AS suma_wydatkow`**

Baza formuje ostateczny wygląd tabeli wynikowej:

1. Bierze nazwę grupy (`Ania`).
2. Wylicza ostatecznie sumę (`400`).
3. Nadaje kolumnie wyliczeniowej alias/etykietę **`suma_wydatkow`**.

**Krok 6:** **`ORDER BY suma_wydatkow ASC`**

Baza sortuje wyniki. Ponieważ ten krok wykonuje się **po** `SELECT`, baza zna już alias `suma_wydatkow` i potrafi według niego posortować dane.

### Pułapki wynikające z tej kolejności:

1. **Dlaczego** **`WHERE suma_wydatkow > 200`** **nie zadziała?**

   Ponieważ `WHERE` wykonuje się w **Kroku 2**, a alias `suma_wydatkow` powstaje dopiero w **Kroku 5**. Baza w Kroku 2 jeszcze nie wie, co to jest `suma_wydatkow`.

2. **Dlaczego** **`WHERE SUM(kwota) > 200`** **też wyrzuci błąd?**

   W Kroku 2 baza patrzy na _pojedyncze wiersze_ (np. patrzy na Wiersz 1 i widzi 100 zł). Suma jeszcze nie istnieje, bo wiersze nie zostały rozdzielone do pudełek (`GROUP BY` dzieje się dopiero w Kroku 3).

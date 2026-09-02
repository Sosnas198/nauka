Różnica sprowadza się do **momentu, w którym baza danych odrzuca wiersze**: `WHERE` filtruje dane **przed** ich pogrupowaniem, a `HAVING` filtruje wyniki **po** wyliczeniu agregacji.

Wyobraź sobie tę samą tabelę zamówień:

| **id** | **klient** | **kategoria** | **kwota** |
| ------ | ---------- | ------------- | --------- |
| 1      | Ania       | Elektronika   | 100 zł    |
| 2      | Tomek      | Odzież        | 50 zł     |
| 3      | Ania       | Elektronika   | 200 zł    |
| 4      | Tomek      | Elektronika   | 150 zł    |
| 5      | Ania       | Odzież        | 30 zł     |

**1.** **`WHERE`** **(Filtrowanie pojedynczych wierszy)**

Działa na surowych danych w bazie, zanim zostaną podzielone na grupy. Nie ma dostępu do funkcji agregujących (`SUM`, `AVG`, `COUNT`).

Pytasz bazę: _„Podsumuj wydatki klientów, ale bierz pod uwagę tylko zakupy z kategorii Elektronika”_.

```sql id="x3p7qa"
SELECT klient, SUM(kwota) AS suma_elektronika
FROM zamowienia
WHERE kategoria = 'Elektronika'
GROUP BY klient;

```

**Jak baza to wykonuje:**

1. Odrzuca wiersze 2 i 5 (`kategoria = 'Odzież'`).
2. Grupuje pozostałe wiersze po klientach.
3. Oblicza sumę dla każdego klienta.

- **Wynik:**
  - Ania | 300 zł (100 + 200)
  - Tomek | 150 zł

**2.** **`HAVING`** **(Filtrowanie gotowych grup)**

Działa na zagregowanych wynikach, po wykonaniu `GROUP BY`. Można w nim używać funkcji agregujących.

Pytasz bazę: _„Pokaż łączną kwotę wydatków dla każdego klienta, ale wyświetl tylko tych, którzy łącznie wydali więcej niż 200 zł”_.

```sql id="m8v2lk"
SELECT klient, SUM(kwota) AS laczne_wydatki
FROM zamowienia
GROUP BY klient
HAVING SUM(kwota) > 200;

```

**Jak baza to wykonuje:**

1. Grupuje **wszystkie** wiersze po klientach.
2. Liczy sumę dla każdego klienta (Ania: 330 zł, Tomek: 200 zł).
3. Odrzuca grupę Tomka, bo `200` nie jest większe niż `200`.

- **Wynik:**
  - Ania | 330 zł

**3. Połączenie** **`WHERE`** **i** **`HAVING`** **w jednym zapytaniu**

Możesz użyć obu klauzul jednocześnie. najpierw odrzucasz niepotrzebne pojedyncze wiersze (`WHERE`), potem grupujesz i wyliczasz sumy, a na końcu odrzucasz grupy spełniające warunek (`HAVING`).

Pytasz bazę: _„Oblicz wydatki na Elektronikę dla każdego klienta, ale pokaż tylko tych, których suma wydatków na tę kategorię przekracza 200 zł”_.

```sql id="q5n1rz"
SELECT klient, SUM(kwota) AS suma_elektroniki
FROM zamowienia
WHERE kategoria = 'Elektronika'
GROUP BY klient
HAVING SUM(kwota) > 200;

```

- **Krok 1 (\*\***`WHERE`\***\*):** Odpadają zakupy odzieży (wiersz 2 i 5).
- **Krok 2 (\*\***`GROUP BY`\*\* **+** **`SUM`\*\***):\*\* Ania ma 300 zł, Tomek ma 150 zł.
- **Krok 3 (\*\***`HAVING`\***\*):** Odpada Tomek (150 zł jest mniejsze niż 200 zł).
- **Wynik:** Ania | 300 zł

**Podsumowanie**

| **Cecha**                                                      | **WHERE**                 | **HAVING**        |
| -------------------------------------------------------------- | ------------------------- | ----------------- |
| **Kiedy działa?**                                              | Przed grupowaniem         | Po grupowaniu     |
| **Na czym działa?**                                            | Na pojedynczych wierszach | Na całych grupach |
| **Czy obsługuje** **`SUM()`\*\***,\*\* **`COUNT()`** **itp.?** |                           |                   |

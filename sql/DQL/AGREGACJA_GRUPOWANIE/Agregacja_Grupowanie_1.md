Zwykłe zapytanie wyciąga pojedyncze wiersze w takiej postaci, w jakiej leżą w bazie, podczas gdy **agregacja i grupowanie** ściskają wiele wierszy w podsumowania (np. wyliczają średnią, sumę czy liczbę elementów).

Wyobraź sobie tabelę ze sklepem internetowym:

| **id** | **klient** | **kategoria** | **kwota** |
| ------ | ---------- | ------------- | --------- |
| 1      | Ania       | Elektronika   | 100 zł    |
| 2      | Tomek      | Odzież        | 50 zł     |
| 3      | Ania       | Elektronika   | 200 zł    |
| 4      | Tomek      | Elektronika   | 150 zł    |

**1. Zwykłe zapytanie (bez agregacji)**

Pytasz bazę: _„Pokaż mi wszystkie zakupy Ani”_.

```sql
SELECT klient, kwota FROM zamowienia WHERE klient = 'Ania';

```

- **Wynik:** Dwa osobne wiersze (100 zł i 200 zł). Baza niczego nie liczy, po prostu przepisuje dane.

**2. Agregacja (bez grupowania)**

Agregacja to użycie funkcji matematycznej (`SUM`, `AVG`, `COUNT`, `MAX`, `MIN`), która bierze kolumnę danych i zwija ją do **jednej liczby**.

Pytasz bazę: _„Ile wyniosł łączny obrót całego sklepu?”_.

```sql
SELECT SUM(kwota) FROM zamowienia;

```

- **Wynik:** Jedna liczba: `500 zł`. Znikają poszczególne wiersze, dostajesz jeden podsumowujący wynik.

**3. Grupowanie (\*\***`GROUP BY`\***\*) + Agregacja**

Grupowanie układa dane w „pudełka” według wybranej cechy (np. według klienta lub kategorii), a następnie aplikuje funkcję agregującą **osobno do każdego pudełka**.

Pytasz bazę: _„Ile łącznie wydał KAŻDY klient z osobna?”_.

```sql
SELECT klient, SUM(kwota) FROM zamowienia GROUP BY klient;

```

**Jak baza to przetwarza krok po kroku:**

1. Tworzy „pudełko Ania” (wiersze 1 i 3) oraz „pudełko Tomek” (wiersze 2 i 4).
2. Wewnątrz pudełka Ania sumuje: `100 + 200 = 300`.
3. Wewnątrz pudełka Tomek sumuje: `50 + 150 = 200`.

- **Wynik:**
  - Ania | 300 zł
  - Tomek | 200 zł

**Złota zasada, której łatwo zapomnieć:**

Gdy używasz `GROUP BY`, w klauzuli `SELECT` możesz umieścić tylko:

- Kolumny, po których grupujesz (np. `klient`).
- Funkcje agregujące (np. `SUM(kwota)`, `COUNT(*)`).

Nie możesz wpisać zwykłej kolumny bez agregacji (np. `SELECT klient, kategoria, SUM(kwota) ... GROUP BY klient`), bo baza nie wiedziałaby, którą kategorię wyświetlić dla Ani, jeśli kupiła rzeczy z kilku różnych kategorii.

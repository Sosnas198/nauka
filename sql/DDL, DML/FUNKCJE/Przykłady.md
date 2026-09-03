# 📝 Przykłady: Funkcje Matematyczne i Daty/Czasu w SQL

## 🔢 Matematyczne

```sql
SELECT ABS(-15);              -- 15
SELECT ABS(15);                -- 15
SELECT ABS(-3.7);              -- 3.7

SELECT SQRT(49);               -- 7
SELECT SQRT(2);                 -- 1.4142135623730951

SELECT POWER(3, 2);            -- 9
SELECT POWER(5, 3);            -- 125
SELECT POWER(2, 10);           -- 1024

SELECT MOD(17, 5);             -- 2
SELECT MOD(20, 4);             -- 0
SELECT MOD(7, 2);              -- 1  (sprawdzenie, czy 7 jest nieparzyste)

SELECT ROUND(19.995, 2);       -- 20.00
SELECT ROUND(4.499, 1);        -- 4.5
SELECT ROUND(123.456, 0);      -- 123

SELECT FLOOR(9.99);            -- 9
SELECT FLOOR(-2.1);            -- -3
SELECT CEIL(9.01);             -- 10
SELECT CEIL(-2.9);             -- -2

SELECT RAND();                 -- np. 0.318452...

-- losowa liczba całkowita 1-6 (rzut kostką)
SELECT FLOOR(RAND() * 6) + 1;

-- losowa liczba całkowita 50-100
SELECT FLOOR(RAND() * (100 - 50 + 1)) + 50;

-- procent zniżki: cena po obniżce o 20%
SELECT ROUND(150 * 0.8, 2);    -- 120.00

-- pole koła o promieniu 4 (przybliżenie, PI ≈ 3.14159)
SELECT ROUND(3.14159 * POWER(4, 2), 2);  -- 50.27
```

---

## 📅 Daty i czas

```sql
SELECT CURRENT_DATE();         -- 2026-09-03
SELECT CURRENT_TIME();         -- np. 16:45:12
SELECT NOW();                  -- 2026-09-03 16:45:12

SELECT YEAR('2010-06-15');     -- 2010
SELECT MONTH('2010-06-15');    -- 6
SELECT DAY('2010-06-15');      -- 15
SELECT YEAR(NOW());            -- 2026

SELECT DATEDIFF('2026-12-31', '2026-09-03');  -- 119
SELECT DATEDIFF(CURRENT_DATE(), '2010-06-15'); -- ile dni minęło od 2010-06-15

SELECT DATE_ADD('2026-09-03', INTERVAL 30 DAY);   -- 2026-10-03
SELECT DATE_ADD('2026-09-03', INTERVAL 1 YEAR);   -- 2027-09-03
SELECT DATE_ADD(NOW(), INTERVAL 2 MONTH);          -- 2026-11-03 16:45:12

-- ile lat ma osoba urodzona 2010-06-15 (przybliżenie przez dni/365)
SELECT FLOOR(DATEDIFF(CURRENT_DATE(), '2010-06-15') / 365);

-- termin płatności: 14 dni od dziś
SELECT DATE_ADD(CURRENT_DATE(), INTERVAL 14 DAY);
```

---

## 🧩 Przykłady na tabelach (`Uczniowie`, `Towary`)

```sql
-- zaokrąglona cena towarów po przecenie o 15%
SELECT nazwa, ROUND(cena * 0.85, 2) AS cena_po_przecenie
FROM Towary;

-- towary z ceną zaokrągloną w górę do pełnych złotych
SELECT nazwa, CEIL(cena) AS cena_zaokraglona
FROM Towary;

-- wiek ucznia na podstawie daty urodzenia (kolumna DataUrodzenia)
SELECT Imie, Nazwisko, FLOOR(DATEDIFF(CURRENT_DATE(), DataUrodzenia) / 365) AS wiek
FROM Uczniowie;

-- uczniowie urodzeni po roku 2010
SELECT Imie, Nazwisko FROM Uczniowie
WHERE YEAR(DataUrodzenia) > 2010;

-- losowe wylosowanie jednego ucznia (np. do odpytania)
SELECT * FROM Uczniowie
ORDER BY RAND()
LIMIT 1;

-- ile dni zostało do zaplanowanego egzaminu (2026-12-01)
SELECT DATEDIFF('2026-12-01', CURRENT_DATE()) AS dni_do_egzaminu;
```

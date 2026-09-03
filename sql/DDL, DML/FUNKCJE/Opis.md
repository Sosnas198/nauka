# 🧮 Kurs SQL: Funkcje Wbudowane (Matematyczne i Daty/Czasu)

## 💡 Czym jest "funkcja" w SQL?

Funkcja to gotowe **narzędzie**, które bierze jakąś wartość na wejściu, coś z nią robi, i zwraca wynik. Nie musisz sam(a) liczyć pierwiastka kwadratowego czy sprawdzać dzisiejszej daty – wołasz gotową funkcję, a baza robi to za Ciebie.

Funkcji używa się zwykle wewnątrz `SELECT`:

```sql
SELECT NAZWA_FUNKCJI(argument);
```

To najprostszy sposób, żeby "na sucho" sprawdzić, co dana funkcja zwraca, zanim użyjesz jej w prawdziwym zapytaniu na tabeli.

---

## A. 🔢 Funkcje matematyczne

### `ABS(x)` — wartość bezwzględna

```sql
SELECT ABS(-6);  -- 6
```

**Co to robi:** zamienia liczbę ujemną na dodatnią, a dodatnią zostawia bez zmian. Innymi słowy – zwraca "odległość od zera".

**Po co:** przydaje się np. gdy liczysz różnicę dwóch wartości, a nie wiesz z góry, która jest większa (`ABS(a - b)` zawsze da Ci dodatni wynik różnicy).

### `SQRT(x)` — pierwiastek kwadratowy

```sql
SELECT SQRT(25);  -- 5
```

**Co to robi:** oblicza pierwiastek kwadratowy z liczby.

### `POWER(x, y)` — potęgowanie

```sql
SELECT POWER(2, 3);  -- 8
```

**Co to robi:** podnosi `x` do potęgi `y` (tutaj: 2 do potęgi 3, czyli 2×2×2).

### `MOD(x, y)` — reszta z dzielenia

```sql
SELECT MOD(10, 3);  -- 1
```

**Co to robi:** zwraca resztę z dzielenia `x` przez `y` (10 podzielone przez 3 to 3 i reszta 1).

**Po co:** bardzo przydatne, gdy chcesz sprawdzić np. czy liczba jest parzysta (`MOD(x, 2) = 0`) albo co pewien odstęp coś zrobić (np. co 5. wiersz).

### `ROUND(x, d)` — zaokrąglanie do `d` miejsc po przecinku

```sql
SELECT ROUND(3.1415, 2);  -- 3.14
```

**Co to robi:** zaokrągla liczbę `x` tak, żeby zostało dokładnie `d` cyfr po przecinku – zwykłe zaokrąglanie matematyczne (w górę od 5).

### `FLOOR(x)` i `CEIL(x)` — zaokrąglanie w dół / w górę

```sql
SELECT FLOOR(8.75);  -- 8
SELECT CEIL(8.75);   -- 9
```

**Co to robi:**

- `FLOOR` ("podłoga") zawsze ścina część po przecinku i schodzi do najbliższej **mniejszej** liczby całkowitej.
- `CEIL` ("sufit") zawsze zaokrągla w górę, do najbliższej **większej** liczby całkowitej.

> ⚠️ **Różnica względem `ROUND`:** `ROUND` zaokrągla "matematycznie" (w zależności od cyfry po przecinku raz w dół, raz w górę), a `FLOOR`/`CEIL` zawsze idą w jedną, konkretną stronę – niezależnie od tego, jaka cyfra jest po przecinku.

### `RAND()` — losowa liczba

```sql
SELECT RAND();  -- np. 0.7231548...
```

**Co to robi:** losuje liczbę zmiennoprzecinkową z przedziału od `0.0` (włącznie) do `1.0` (bez `1.0`). Sama w sobie mało użyteczna – jej moc odkrywasz dopiero w połączeniu z innymi funkcjami.

#### 🎲 Jak wylosować liczbę całkowitą z konkretnego zakresu?

Chcemy np. wylosować liczbę całkowitą od `1` do `10`:

```sql
SELECT FLOOR(RAND() * 10) + 1;
```

**Rozłóżmy to na kroki, żeby zrozumieć dlaczego to działa:**

1. `RAND()` losuje ułamek z przedziału `[0.0, 1.0)`.
2. Mnożymy przez `10` → dostajemy ułamek z przedziału `[0.0, 10.0)`.
3. `FLOOR(...)` ścina część po przecinku → zostaje liczba całkowita z przedziału `[0, 9]`.
4. Dodajemy `+1` → przesuwamy cały zakres o jeden w górę, więc finalnie dostajemy liczbę całkowitą z przedziału `[1, 10]`.

**Ogólny wzór**, jeśli chcesz wylosować liczbę całkowitą z dowolnego zakresu od `min` do `max`:

```sql
SELECT FLOOR(RAND() * (max - min + 1)) + min;
```

`(max - min + 1)` to po prostu **liczba wszystkich możliwych wartości** w zakresie (np. dla zakresu 1–10 jest to `10 - 1 + 1 = 10` wartości) – dokładnie tyle, przez ile trzeba pomnożyć losowy ułamek, żeby "rozciągnąć" go na cały potrzebny zakres.

---

## B. 📅 Funkcje daty i czasu

### `CURRENT_DATE()` — dzisiejsza data

```sql
SELECT CURRENT_DATE();  -- np. 2026-09-03
```

**Co to robi:** zwraca aktualną datę (bez godziny), pobraną z zegara serwera bazy danych, w formacie `RRRR-MM-DD`.

### `CURRENT_TIME()` — bieżąca godzina

```sql
SELECT CURRENT_TIME();  -- np. 14:30:00
```

**Co to robi:** zwraca samą godzinę (bez daty), w formacie `GG:MM:SS`.

### `NOW()` — pełna data i czas

```sql
SELECT NOW();  -- np. 2026-09-03 14:30:00
```

**Co to robi:** to połączenie obu powyższych naraz – zwraca datę i godzinę w jednym.

**Po co się to przydaje:** najczęściej do **znaczników czasu** (ang. _timestamp_) – np. kiedy dokładnie ktoś złożył zamówienie, kiedy dodano wpis do bazy. Zamiast wpisywać datę ręcznie, wstawiasz `NOW()` przy zapisie i baza sama "ostempluje" wiersz aktualnym momentem.

### Wyciąganie fragmentu daty — `YEAR()`, `MONTH()`, `DAY()`

Czasem nie potrzebujesz całej daty, tylko jej fragmentu – np. samego roku.

```sql
SELECT YEAR('2026-09-03');   -- 2026
SELECT MONTH('2026-09-03');  -- 9
SELECT DAY('2026-09-03');    -- 3
```

**Co to robi:** każda z tych funkcji "wyciąga" jeden konkretny element z pełnej daty.

**Po co:** przydaje się np. przy grupowaniu danych po roku/miesiącu (np. "ile zamówień było w każdym miesiącu"), bez tego trzeba by ręcznie rozbijać tekst daty.

### Różnica między dwiema datami — `DATEDIFF(data1, data2)`

```sql
SELECT DATEDIFF('2026-09-10', '2026-09-03');  -- 7
```

**Co to robi:** liczy, ile **dni** dzieli dwie daty (zawsze `data1 - data2`, wynik może być ujemny jeśli `data1` jest wcześniejsza).

**Po co:** np. żeby policzyć, ile dni zostało do egzaminu, albo ile dni minęło od rejestracji ucznia.

### Dodawanie do daty — `DATE_ADD(data, INTERVAL n jednostka)`

```sql
SELECT DATE_ADD('2026-09-03', INTERVAL 7 DAY);   -- 2026-09-10
SELECT DATE_ADD('2026-09-03', INTERVAL 1 MONTH); -- 2026-10-03
```

**Co to robi:** dodaje do podanej daty określony odstęp czasu (dni, miesiące, lata itd. – podajesz to jako `INTERVAL`).

**Po co:** np. żeby policzyć termin płatności ("7 dni od dzisiaj") albo datę ważności czegoś, bez ręcznego liczenia dni w kalendarzu (a to bywa zdradliwe – różna liczba dni w miesiącach, lata przestępne itd. – funkcja robi to poprawnie za Ciebie).

---

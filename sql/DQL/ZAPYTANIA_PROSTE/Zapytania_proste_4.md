# 🚗 Kompletny Podręcznik SQL: Baza danych „AUTOSALON”

W tym module nauczysz się:

1. Pracy z operatorem dopasowywania tekstowego **`LIKE`** oraz znakami wieloznacznymi (`%`, `_`).
2. Wykorzystywania warunków zbiorczych **`IN`** oraz zakresowych **`BETWEEN`**.
3. Stosowania wbudowanej **funkcji warunkowej** **`IF()`** do transformacji danych wyjściowych w locie.
4. Pracy na funkcjach dat i czasu (`CURDATE()`, `YEAR()`) w celu obliczania wartości logicznych i dynamicznego aktualizowania wierszy (`UPDATE`).
5. Kopiowania struktury tabeli oraz masowej migracji rekordów według złożonych warunków.

## 1. Struktura tabeli i ładowanie danych

Tabela `samochody` przechowuje informacje o pojazdach w salonie. Zwróć uwagę na kolumnę `KupionyWKraju` – przyjmuje wartości `1` (krajowy), `0` (zagraniczny) lub `NULL` (brak danych).

SQL

```sql
CREATE TABLE samochody (
  Id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
  Marka VARCHAR(30) NOT NULL,
  Model VARCHAR(30) NOT NULL,
  Kolor VARCHAR(40) NOT NULL,
  Rocznik YEAR NOT NULL,
  Wiek TINYINT UNSIGNED DEFAULT NULL,
  Przebieg INT UNSIGNED DEFAULT NULL,
  Rejestracja VARCHAR(10) DEFAULT NULL,
  KupionyWKraju TINYINT(1) DEFAULT NULL
);
```

## 2. Zapytania filtrujące i wyszukujące (`SELECT`)

### Zadanie A: Zakresy liczb i dat (`BETWEEN`)

Wyświetl samochody z roczników 1990–2000, posortowane od najstarszych.

SQL

```sql
SELECT * FROM SAMOCHODY
WHERE Rocznik BETWEEN 1990 AND 2000
ORDER BY Rocznik ASC;
```

> **🧠 Przelicznik amatora:** `BETWEEN a AND b` w SQL jest włączający (odpowiada przedziałowi $[a, b]$). Oznacza to, że samochody z rocznika 1990 i 2000 również znajdą się w wynikach.

### Zadanie B: Wyszukiwanie tekstu za pomocą `LIKE` i znaku `%`

Wyświetl samochody, których tablica rejestracyjna zaczyna się od `PO` lub `PZ`.

SQL

```sql
SELECT * FROM SAMOCHODY
WHERE Rejestracja LIKE 'PO%'
   OR Rejestracja LIKE 'PZ%';
```

- **`%`** **(procent):** Zastępuje **dowolną liczbę znaków** (zero, jeden lub więcej). Np. `'PO%'` pasuje do `PO 9089T` oraz `POZ 89712`.

### Zadanie C: Precyzyjne dopasowanie długości za pomocą `_`

Wyświetl samochody, których rejestracja składa się z dokładnie 9 znaków.

SQL

```sql
SELECT * FROM SAMOCHODY
WHERE Rejestracja LIKE '_________' ;
```

- **`_`** **(podkreślenie):** Zastępuje **dokładnie jeden, konkretny znak**. Użycie 9 znaków `_` przefiltruje tylko te numery rejestracyjne, które zawierają dokładnie 9 znaków (włączając spacje).

### Zadanie D: Filtrowanie po liście wartości (`IN`)

Wyświetl samochody marek FIAT, VW, HONDA.

SQL

```sql
SELECT * FROM SAMOCHODY
WHERE Marka IN ('FIAT', 'VW', 'HONDA');
```

> **Uwaga na dane w bazie!** Jeśli w bazie danej marka to `'VOLKSWAGEN'` zamiast `'VW'`, to zapis `'VW'` zwróci puste wyniki dla tych aut. Zawsze sprawdzaj, jak dane są zapisane w tabeli źródłowej!

### Zadanie E: Sprawdzanie wartości niepustych (`IS NOT NULL`)

Wyświetl samochody, których wiek jest znany (różny od NULL) i posortuj od najstarszych do najmłodszych.

SQL

```sql
SELECT * FROM SAMOCHODY
WHERE Wiek IS NOT NULL
ORDER BY Wiek DESC;
```

### Zadanie F: Logiczna funkcja warunkowa `IF()`

Wypisz markę, model, rejestrację oraz czytelną informację o pochodzeniu auta na podstawie pola `KupionyWKraju`.

SQL

```sql
SELECT
    Marka,
    Model,
    Rejestracja,
    IF(KupionyWKraju = 1, 'zakupiony w kraju', 'przywieziony z zagranicy') AS Pochodzenie
FROM SAMOCHODY;
```

- **Składnia** **`IF(warunek, wartość_gdy_prawda, wartość_gdy_fałsz)`\*\***:\*\* Pozwala na dynamiczne podmienianie wartości logicznych na zrozumiały dla człowieka tekst.

### Zadanie G: Łączenie tekstów i wycinanie fragmentów (`CONCAT` & `LEFT`)

Wypisz markę i model jako jedno pole `Samochod` oraz pierwsze 2 litery rejestracji jako `poczatek_rejestracji`.

SQL

```sql
SELECT
    CONCAT(Marka, ' ', Model) AS Samochod,
    LEFT(Rejestracja, 2) AS poczatek_rejestracji
FROM SAMOCHODY;
```

- **`LEFT(napis, N)`\*\***:\*\* Wycina pierwsze $N$ znaków od lewej strony podanego ciągu tekstowego.

## 3. Aktualizacja danych i operacje na datach (`UPDATE`)

Zaktualizuj pole `Wiek` w rekordach, w których wartość wynosi `NULL`, obliczając różnicę między bieżącym rokiem a rocznikiem samochodu.

SQL

```sql
UPDATE SAMOCHODY
SET Wiek = YEAR(CURDATE()) - Rocznik
WHERE Wiek IS NULL;
```

### 🧠 Jak to działa?

1. **`CURDATE()`** pobiera z systemu aktualną datę (np. `2026-09-02`).
2. **`YEAR(CURDATE())`** wyciąga z niej sam rok (np. `2026`).
3. Różnica `YEAR(CURDATE()) - Rocznik` automatycznie oblicza aktualny wiek pojazdu w latach.

## 4. Kopiowanie struktur i migracja danych

### Krok 1: Tworzenie kopii tabeli (`LIKE`)

Utwórz nową, pustą tabelę `SAMOCHODYNAZLOM` o takiej samej strukturze jak `SAMOCHODY`.

SQL

```sql
CREATE TABLE SAMOCHODYNAZLOM LIKE SAMOCHODY;
```

> Zastosowanie `LIKE` kopiuje dokładną strukturę – w tym typy kolumn, klucze główne, atrybuty `AUTO_INCREMENT` oraz opcje domyślne, ale nie kopiuje samych danych!

### Krok 2: Masowy transfer danych spełniających kryteria

Przenieś do nowej tabeli pojazdy, które mają więcej niż 12 lat **LUB** ich przebieg przekracza 200 000 km.

SQL

```sql
INSERT INTO SAMOCHODYNAZLOM
SELECT * FROM SAMOCHODY
WHERE Wiek > 12 OR Przebieg > 200000;
```

## 📊 Szybka ściągawka z funkcji tekstowych i operacji logicznych

| **Funkcja / Operator** | **Opis** | **Przykład** |
| ---------------------- | -------- | ------------ |
| **`LIKE 'PO%'`**       |          |              |

Dopasowuje tekst zaczynający się od "PO"

|     |
| --- |

`Rejestracja LIKE 'PO%'`

| **`LIKE '___'`** |     |
| ---------------- | --- |

Dopasowuje tekst o długości dokładnie 3 znaków

|     |
| --- |

`Rejestracja LIKE '_________'`

| **`IN ('a', 'b')`** |     |
| ------------------- | --- |

Sprawdza, czy wartość znajduje się na liście

|     |
| --- |

`Marka IN ('FIAT', 'HONDA')`

| **`IF(warunek, t, f)`** |     |
| ----------------------- | --- |

Zwraca `t` jeśli warunek jest spełniony, w przeciwnym razie `f`

|     |
| --- |

`IF(KupionyWKraju = 1, 'TAK', 'NIE')`

| **`LEFT(tekst, n)`** |     |
| -------------------- | --- |

Zwraca pierwsze $n$ znaków od lewej strony

|     |
| --- |

`LEFT(Rejestracja, 2)`

| **`YEAR(data)`** |     |
| ---------------- | --- |

Wyciąga sam rok z podanej daty

|     |
| --- |

`YEAR(CURDATE())`

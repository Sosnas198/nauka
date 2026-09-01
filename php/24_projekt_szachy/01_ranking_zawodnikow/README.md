# Kompletny przewodnik: Filtrowanie rankingu zawodników i ręczne numerowanie wierszy tabeli

Ten przewodnik tłumaczy **od A do Z**, jak Skrypt #1 pobiera z bazy danych najlepszych szachistów koła (tych z odpowiednio wysokim rankingiem), sortuje ich malejąco i wyświetla w tabeli z numeracją pozycji liczoną przez sam skrypt.

---

## 🎯 Cel skryptu

Pobrać z tabeli `zawodnicy` wszystkich zawodników, których `ranking` przekracza `2787`, posortować ich malejąco po rankingu, i wyświetlić jako wiersze tabeli — z kolumną "Pozycja" numerowaną ręcznie przez skrypt, począwszy od 1.

> ℹ️ **Uwaga:** Ten skrypt korzysta ze zmiennej `$conn`, czyli połączenia z bazą danych. Połączenie to jest tworzone raz, na samej górze głównego pliku projektu (`$conn = new mysqli(hostname: "localhost", ..., database: "szachy");`) i jest współdzielone przez oba skrypty w tym projekcie.

---

## SEC-1: Pobranie zawodników spełniających warunek rankingu (`WHERE` + `ORDER BY`)

```php
$sql = "SELECT pseudonim, tytul, ranking, klasa FROM zawodnicy WHERE ranking > 2787 ORDER BY ranking DESC;";
$result = $conn->query($sql);
```

### Jak to działa?

- **`SELECT pseudonim, tytul, ranking, klasa FROM zawodnicy`** — pobieramy cztery kolumny (`pseudonim`, `tytul`, `ranking`, `klasa`) z tabeli `zawodnicy`.
- **`WHERE ranking > 2787`** — to klauzula **filtrująca**. Do wyniku trafiają **tylko** te wiersze, w których wartość kolumny `ranking` jest **większa niż** `2787`. Innymi słowy: pokazujemy tylko elitę koła szachowego — zawodników z odpowiednio wysokim rankingiem, pomijając resztę.
- **`ORDER BY ranking DESC`** — sortuje pozostałych (przefiltrowanych) zawodników **malejąco** po rankingu — czyli zawodnik z najwyższym rankingiem znajdzie się na samej górze tabeli, na pierwszej pozycji.
- **`$conn->query($sql)`** — wysyła zapytanie do bazy danych, a wynik trafia do `$result`.

---

## SEC-2: Wypisanie wyników z ręcznie liczoną pozycją (`$i`)

```php
$i = 1;
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . $i . "</td>";
    echo "<td>" . $row["pseudonim"] . "</td>";
    echo "<td>" . $row["tytul"] . "</td>";
    echo "<td>" . $row["ranking"] . "</td>";
    echo "<td>" . $row["klasa"] . "</td>";
    echo "</tr>";
    $i++;
}
```

### Jak to działa?

- **`$i = 1;`** — przed pętlą tworzymy licznik `$i` (skrót od *iterator*) i ustawiamy go na `1`. Ta zmienna **nie pochodzi z bazy danych** — jest w całości obliczana przez sam skrypt PHP, dokładnie zgodnie z wymaganiem zadania: *"obliczony przez skrypt kolejny numer wiersza, począwszy od 1"*.
- **`while ($row = $result->fetch_assoc())`** — pętla pobierająca kolejno każdego zawodnika (wiersz wyniku) jako tablicę asocjacyjną.
- **`echo "<td>" . $i . "</td>";`** — pierwsza kolumna tabeli ("Pozycja") to wartość licznika `$i` — w pierwszym przebiegu `1`, w drugim `2`, itd. Ponieważ dane są już posortowane malejąco po rankingu (SEC-1), pozycja `1` zawsze trafi do zawodnika z **najwyższym** rankingiem spośród przefiltrowanych.
- Kolejne komórki wypisują dane pobrane z bazy: pseudonim, tytuł, ranking, klasa.
- **`$i++;`** — zwiększamy licznik o 1 po każdym przebiegu pętli, żeby kolejny zawodnik dostał kolejny numer pozycji.

---

## SEC-3: Dodatkowy pusty wiersz na końcu tabeli

```php
echo "<tr>";
echo "</tr>";
```

### Jak to działa?

- Po zakończeniu pętli `while`, skrypt wypisuje jeszcze jeden, **całkowicie pusty** wiersz tabeli (bez żadnych komórek `<td>` w środku). W praktyce taki wiersz jest niewidoczny wizualnie (nie ma w nim żadnej treści), ale technicznie jest częścią struktury tabeli HTML — np. może służyć jako mały odstęp/separator przed elementami znajdującymi się dalej w kodzie (formularzem losowania), w zależności od stylów CSS zastosowanych do tabeli.

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Funkcja**       | **Co oznacza / Co robi?**                                                                        |
| ---------------------------- | ---------------------------------------------------------------------------------------------------|
| `WHERE kolumna > wartość`     | Klauzula SQL filtrująca wyniki — zwraca tylko wiersze, w których wartość kolumny przekracza podaną liczbę. |
| `ORDER BY kolumna DESC`       | Sortuje wynik malejąco (od największej wartości do najmniejszej).                                    |
| `$i = 1; ... $i++;`           | Ręcznie tworzony i zwiększany licznik — używany, gdy numer wiersza/pozycji ma pochodzić ze skryptu, a nie z bazy danych. |
| `fetch_assoc()`                | Pobiera jeden wiersz wyniku jako tablicę z kluczami-nazwami kolumn (np. `$row["pseudonim"]`).         |

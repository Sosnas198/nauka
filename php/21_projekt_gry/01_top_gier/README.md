# Kompletny przewodnik: Wyświetlanie rankingu TOP 5 gier (sortowanie i limit wyników)

Ten przewodnik tłumaczy **od A do Z**, jak Skrypt #1 pobiera z bazy danych **pięć najlepiej ocenionych gier** i wyświetla je w postaci listy punktowanej.

---

## 🎯 Cel skryptu

Pobrać z tabeli `gry` pięć rekordów z **najwyższą liczbą punktów**, posortowanych od największej do najmniejszej, i wypisać je jako listę `<ul><li>...</li></ul>`.

> ℹ️ **Uwaga:** Ten skrypt korzysta ze zmiennej `$conn`, czyli połączenia z bazą danych. Połączenie to jest tworzone **raz, na samej górze** głównego pliku projektu (`$conn = new mysqli('localhost', 'root', '', 'gry');`) i jest **wspólne** dla wszystkich czterech skryptów w tym projekcie.

---

## SEC-1: Pobranie 5 najlepszych gier z bazy danych (`ORDER BY` + `LIMIT`)

```php
$sql = "SELECT nazwa, punkty FROM gry ORDER BY punkty DESC LIMIT 5;";
$result = $conn->query($sql);
```

### Jak to działa?

- **`SELECT nazwa, punkty FROM gry`** — pobieramy z tabeli `gry` tylko dwie kolumny: `nazwa` (nazwa gry) i `punkty` (liczba punktów w rankingu). Nie pobieramy całej tabeli (np. opisu, ceny), bo do tego widoku one nie są potrzebne.
- **`ORDER BY punkty DESC`** — to sortowanie wyników. Słowo `DESC` oznacza *descending* (malejąco) — czyli najpierw gra z **największą** liczbą punktów, potem coraz mniejsze.
- **`LIMIT 5`** — ogranicza liczbę zwróconych wierszy do **maksymalnie pięciu**. Nawet jeśli w tabeli jest 500 gier, otrzymamy tylko pierwsze 5 po posortowaniu.
- **`$conn->query($sql)`** — wysyła to zapytanie do bazy danych. Wynik (zbiór wierszy) trafia do zmiennej `$result`.

---

## SEC-2: Sprawdzenie, czy w ogóle są jakieś wyniki (`num_rows`)

```php
if ($result->num_rows > 0) {
    // ... (patrz SEC-3)
}
else {
    echo "0 results";
}
```

### Jak to działa?

- **`$result->num_rows`** — to właściwość obiektu wyniku zapytania, mówiąca, **ile wierszy** zostało zwróconych przez zapytanie SQL.
- **`if ($result->num_rows > 0)`** — sprawdzamy, czy zapytanie faktycznie coś zwróciło. Jeśli tabela `gry` byłaby pusta, `num_rows` wynosiłoby `0`.
- Jeśli wyników **jest** przynajmniej jeden — przechodzimy do wypisania listy (SEC-3).
- Jeśli wyników **nie ma** — wypisujemy prosty tekst `"0 results"` zamiast pustej, "sierocej" listy `<ul></ul>`.

---

## SEC-3: Wypisanie wyników jako listy (`while` + `fetch_assoc`)

```php
echo "<ul>";
while($row = $result->fetch_assoc()) {
    echo "<li>" . $row["nazwa"] . " <span class='pkt'>" . $row["punkty"] . "</span></li>";
}
echo "</ul>";
```

### Jak to działa?

- **`echo "<ul>";`** — wypisujemy znacznik otwierający listę nieuporządkowaną.
- **`while($row = $result->fetch_assoc())`** — pętla, która za każdym przebiegiem pobiera **jeden wiersz** wyniku i zapisuje go w `$row`. Metoda `fetch_assoc()` (w odróżnieniu od `fetch_array()`) zwraca wiersz jako **tablicę asocjacyjną**, czyli z kluczami będącymi nazwami kolumn (`$row["nazwa"]`, `$row["punkty"]`) zamiast liczbowych indeksów (`$row[0]`, `$row[1]`) — dzięki temu kod jest czytelniejszy.
- **`$row["nazwa"]`** — nazwa danej gry z bieżącego wiersza.
- **`<span class='pkt'>" . $row["punkty"] . "</span>`** — liczba punktów jest owinięta w znacznik `<span>` z klasą CSS `pkt`. To właśnie ten fragment odpowiada za dodatkowe formatowanie stylem (np. inny kolor czy pogrubienie punktów), o którym mowa w treści zadania — sam wygląd (kolor, czcionka) definiuje się w osobnym pliku `styl.css`, a PHP tylko "opakowuje" liczbę w odpowiedni znacznik.
- **`echo "</ul>";`** — na końcu zamykamy listę.
- Pętla powtarza się dokładnie tyle razy, ile wierszy zwróciło zapytanie (czyli maksymalnie 5, zgodnie z `LIMIT 5` z SEC-1).

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Funkcja**       | **Co oznacza / Co robi?**                                                             |
| ---------------------------- | -------------------------------------------------------------------------------------- |
| `ORDER BY kolumna DESC`       | Sortuje wyniki zapytania malejąco (od największej wartości do najmniejszej).           |
| `LIMIT N`                     | Ogranicza liczbę zwróconych wierszy do maksymalnie `N`.                                 |
| `$result->num_rows`           | Liczba wierszy zwróconych przez zapytanie — pozwala sprawdzić, czy wynik nie jest pusty.|
| `fetch_assoc()`                | Pobiera jeden wiersz wyniku jako tablicę z kluczami-nazwami kolumn (np. `$row["nazwa"]`).|
| `<span class='...'>`          | Znacznik HTML używany do "owinięcia" fragmentu tekstu w celu nadania mu stylu CSS.      |

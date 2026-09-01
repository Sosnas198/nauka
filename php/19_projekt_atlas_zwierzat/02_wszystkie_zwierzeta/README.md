> **Krok 2 z 2** | [Krok 1](../01_wyswietlanie_gromady/README.md) pokazał zwierzęta jednej gromady. Teraz **Skrypt 2**: pełna lista wszystkich zwierząt w bazie.

---

# Kompletny przewodnik: Skrypt 2 — pełna lista zwierząt z nazwą gromady

---

## Wprowadzenie — o co chodzi w tej części zadania?

O ile Skrypt 1 pokazywał zwierzęta **tylko jednej**, wybranej przez użytkownika gromady, o tyle ten skrypt działa zupełnie inaczej: wykonuje się **zawsze**, niezależnie od tego, czy formularz został wysłany, i pokazuje **wszystkie** zwierzęta znajdujące się w bazie danych — bez żadnego filtrowania. To sekcja "Wszystkie zwierzęta w bazie", widoczna po prawej stronie strony przez cały czas.

Zwróć uwagę na ważną różnicę względem Skryptu 1: tam zapytanie miało warunek `AND gromady.id = $gromada`, ograniczający wynik do jednej gromady. Tutaj tego warunku po prostu nie ma — dzięki temu zapytanie zwraca komplet danych ze złączonych tabel `zwierzeta` i `gromady`.

---

## SEC-1: Zapytanie 2 — wszystkie zwierzęta z nazwą gromady

```php
$sql = "SELECT zwierzeta.id, zwierzeta.gatunek, gromady.nazwa FROM zwierzeta, gromady WHERE zwierzeta.Gromady_id = gromady.id;";
$result = $conn->query(query: $sql);
```

- **`SELECT zwierzeta.id, zwierzeta.gatunek, gromady.nazwa`** — tym razem pobieramy trzy konkretne kolumny: identyfikator zwierzęcia (z tabeli `zwierzeta`), nazwę gatunku (też z tabeli `zwierzeta`) oraz nazwę gromady (ale tym razem z tabeli `gromady`, kolumna `nazwa` — czyli np. "Ssaki", a nie sam numer gromady). Zwróć uwagę, że poprzedzamy nazwę każdej kolumny nazwą tabeli, z której pochodzi (np. `zwierzeta.id`) — to konieczne, gdy pracujemy jednocześnie na dwóch tabelach, żeby SQL wiedział dokładnie, o którą kolumnę nam chodzi (szczególnie że obie tabele mogłyby teoretycznie mieć kolumnę o tej samej nazwie, np. `id`).
- **`FROM zwierzeta, gromady WHERE zwierzeta.Gromady_id = gromady.id`** — dokładnie ten sam mechanizm łączenia dwóch tabel, co w Skrypcie 1 (SEC-3) — łączymy każde zwierzę z jego gromadą po dopasowaniu `Gromady_id` do `id`. Różnica polega na tym, że **nie ma tu** dodatkowego warunku ograniczającego do jednej gromady — zapytanie zwróci więc komplet wszystkich zwierząt znajdujących się w bazie, każde razem z nazwą jego gromady.
- **`$conn->query(query: $sql)`** — wysłanie zapytania do bazy, dokładnie w ten sam sposób jak w Skrypcie 1.

---

## SEC-2: Wypisanie rekordów w formacie „id. gatunek nazwa_gromady”

Arkusz: w kolejnych wierszach wypisywane są rekordy w formacie „<id>. <gatunek> <nazwa_gromady>”.

```php
while($row = $result -> fetch_array()) {
    echo $row[0].". ".$row[1]." ".$row[2]."<br>";
}
```

- Tak samo jak w Skrypcie 1, `fetch_array()` pobiera po jednym wierszu wyniku na raz, w pętli `while`, aż do wyczerpania wszystkich zwróconych rekordów.
- Tym razem jednak do poszczególnych wartości odwołujemy się **nie** po nazwie kolumny (jak `$row["gatunek"]` w Skrypcie 1), tylko po **numerze indeksu**: `$row[0]` to pierwsza kolumna z zapytania (`zwierzeta.id`), `$row[1]` to druga (`zwierzeta.gatunek`), a `$row[2]` to trzecia (`gromady.nazwa`). Kolejność numerów odpowiada dokładnie kolejności kolumn wymienionych w `SELECT` w SEC-1 — to bardzo ważne, bo gdyby ktoś zmienił kolejność kolumn w zapytaniu, trzeba by też zmienić numery indeksów w tej pętli.
- Format wypisywanego tekstu również jest inny niż w Skrypcie 1: najpierw identyfikator zwierzęcia, potem kropka ze spacją, potem gatunek, spacja, i na końcu nazwa gromady — dokładnie tak, jak wymaga tego arkusz („<id>. <gatunek> <nazwa_gromady>”), a na końcu, tak jak wcześniej, znacznik `<br>` przenoszący do nowej linii.

Ten fragment kodu jest umieszczony w sekcji `<div id="prawy">` strony i wykonuje się przy **każdym** wczytaniu strony — niezależnie od tego, czy użytkownik cokolwiek wpisał w formularzu z lewej strony, czy nie.

---

🏠 **[Spis treści](../README.md)**

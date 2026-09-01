# Kompletny przewodnik: Filtrowanie i wyświetlanie wyników w tabeli HTML na podstawie wyboru z listy

Ten przewodnik tłumaczy **od A do Z**, jak Skrypt #2 pobiera wybrany przez użytkownika rodzaj wypieku, wyszukuje wszystkie pasujące produkty w bazie danych i wyświetla je jako wiersze tabeli HTML.

---

## 🎯 Cel skryptu

Po wysłaniu formularza z wybranym rodzajem wypieku, pobrać z tabeli `wyroby` **wszystkie produkty tego rodzaju** i wyświetlić je jako kolejne wiersze (`<tr>`) w tabeli, z danymi w odpowiednich komórkach (`<td>`). Dopóki formularz nie zostanie wysłany, tabela ma pokazywać **tylko nagłówek**, bez żadnych wierszy z danymi.

> ℹ️ **Uwaga:** Ten skrypt korzysta ze zmiennej `$conn` (połączenia z bazą danych), tworzonej raz na początku głównego pliku projektu.

---

## SEC-1: Sprawdzenie, czy formularz został wysłany (`isset`)

```php
if(isset($_POST["rodzaj"])) {
    // ... (patrz SEC-2, SEC-3)
}
```

### Jak to działa?

- **`isset($_POST["rodzaj"])`** — sprawdza, czy w danych formularza istnieje pole `rodzaj` (czyli wartość wybrana z listy rozwijanej `<select name="rodzaj">` z Skryptu #1). To pole trafia do `$_POST` **dopiero po** kliknięciu przycisku "Wybierz" i wysłaniu formularza.
- **To właśnie ten warunek odpowiada za wymaganie z treści zadania**: *"w stanie początkowym, gdy nie wybrano opcji listy rozwijanej, w tabeli nie są wyświetlane wiersze z danymi"*. Jeśli formularz jeszcze nie został wysłany (np. użytkownik dopiero co otworzył stronę), `$_POST["rodzaj"]` nie istnieje, więc cały kod wewnątrz tego `if` **w ogóle się nie wykonuje** — tabela wyświetla wyłącznie wiersz nagłówkowy (`<th>`) zdefiniowany na stałe w głównym pliku HTML, bez żadnych wierszy z danymi.

---

## SEC-2: Pobranie wybranego rodzaju i wysłanie zapytania SQL

```php
$rodzaj = $_POST['rodzaj'];
$sql = "SELECT Rodzaj, Nazwa, Gramatura, Cena FROM wyroby WHERE Rodzaj = '$rodzaj';";
$result = $conn->query($sql);
```

### Jak to działa?

- **`$rodzaj = $_POST['rodzaj'];`** — zapisujemy w zmiennej `$rodzaj` wartość, którą użytkownik wybrał z listy rozwijanej (np. `"chleb"` albo `"bułka"`).
- **`SELECT Rodzaj, Nazwa, Gramatura, Cena FROM wyroby WHERE Rodzaj = '$rodzaj';`** — to zapytanie SQL pobiera cztery kolumny (`Rodzaj`, `Nazwa`, `Gramatura`, `Cena`) ze wszystkich wierszy tabeli `wyroby`, ale **tylko tych**, w których kolumna `Rodzaj` jest **równa** wartości wybranej przez użytkownika. To właśnie klauzula **`WHERE Rodzaj = '$rodzaj'`** filtruje wyniki — bez niej dostalibyśmy wszystkie produkty ze wszystkich rodzajów naraz.
- **`$conn->query($sql)`** — wysyła to zapytanie do bazy danych, a pasujące wiersze trafiają do `$result`.

---

## SEC-3: Wypisanie każdego wyniku jako wiersza tabeli (`while` + `fetch_assoc`)

```php
while($row = $result->fetch_assoc()) {
    echo "<tr>";
        echo "<td>" . $row["Rodzaj"] . "</td>";
        echo "<td>" . $row["Nazwa"] . "</td>";
        echo "<td>" . $row["Gramatura"] . "</td>";
        echo "<td>" . $row["Cena"] . "</td>";
    echo "</tr>";
}
```

### Jak to działa?

- **`while($row = $result->fetch_assoc())`** — pętla pobierająca kolejno każdy pasujący produkt (wiersz wyniku) jako tablicę asocjacyjną.
- **`echo "<tr>";`** — dla każdego produktu otwieramy nowy wiersz tabeli HTML.
- **`<td>" . $row["Rodzaj"] . "</td>`** — każda kolumna z bazy danych trafia do osobnej komórki tabeli (`<td>`), dokładnie w kolejności zgodnej z nagłówkami tabeli zdefiniowanymi w głównym pliku (`Rodzaj`, `Nazwa`, `Gramatura`, `Cena`).
- **`echo "</tr>";`** — zamykamy wiersz.
- Pętla powtarza się dla **każdego** produktu danego rodzaju znalezionego w bazie — jeśli wybrany rodzaj ma np. 5 różnych produktów (różne nazwy/gramatury), tabela wyświetli 5 wierszy z danymi.

---

## 🧩 Cały mechanizm krok po kroku

```text
1. Strona ładuje się po raz pierwszy
              ↓
2. isset($_POST["rodzaj"]) → FAŁSZ (formularz jeszcze nie wysłany)
              ↓
3. Tabela pokazuje tylko wiersz nagłówkowy, bez danych
              ↓
4. Użytkownik wybiera rodzaj z listy i klika "Wybierz"
              ↓
5. isset($_POST["rodzaj"]) → PRAWDA
              ↓
6. $rodzaj = $_POST['rodzaj']
              ↓
7. SELECT ... WHERE Rodzaj = '$rodzaj'
              ↓
8. Pętla while + fetch_assoc() → wiersze <tr><td>...</td></tr>
              ↓
9. Tabela pokazuje nagłówek + wszystkie pasujące produkty
```

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Funkcja**       | **Co oznacza / Co robi?**                                                                    |
| ---------------------------- | ------------------------------------------------------------------------------------------------ |
| `isset($_POST["pole"])`       | Sprawdza, czy formularz w ogóle został wysłany (czy dane pole istnieje w żądaniu POST).           |
| `WHERE kolumna = '$zmienna'`  | Klauzula SQL filtrująca wyniki — zwraca tylko wiersze spełniające podany warunek.                 |
| `fetch_assoc()`                | Pobiera jeden wiersz wyniku jako tablicę z kluczami-nazwami kolumn (np. `$row["Nazwa"]`).          |
| `<tr>` / `<td>`                | Znaczniki HTML: `<tr>` to wiersz tabeli, `<td>` to pojedyncza komórka danych w tym wierszu.        |

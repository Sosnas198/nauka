> **Krok 3 z 3** | [W Kroku 1](../01_lista_szczyty_get/README.md) linki wysłały `id` metodą GET. [W Kroku 2](../02_galeria_miniatur/README.md) dodałeś galerię. Teraz **Skrypt 3** na `szczyty.php`: odczyt ID, `JOIN` z tabelą `opis` i karta szczytu.

---

# Kompletny przewodnik: Skrypt 3 — GET, `JOIN` i szczegóły jednego szczytu

Ta ściąga wytłumaczy Ci **od A do Z** odczyt parametru z `index.php`, zapytanie 3 z filtrem ID oraz układ: duże zdjęcie, nagłówki, wysokość, pasmo i opis.

---

## SEC-1: Odczyt `id` przesłanego z `index.php` (`$_GET`)

Link z Skryptu 1 wygląda tak: `szczyty.php?id=5`.

PHP wkłada parę z adresu do superglobalnej tablicy **`$_GET`**.

```php
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    // dalsze zapytanie używa $id
}
```

- **`isset($_GET['id'])`** — czy w URL w ogóle jest parametr `id`? Bez tego warunek `$_GET['id']` przy wejściu na samo `szczyty.php` zgłosi brak klucza.
- **`$id = $_GET['id']`** — ta wartość trafia do `WHERE` (arkusz: *sprawdzane jest id wysłane z pliku index.php metodą GET*).

Arkusz **nie** każe tu ustawiać domyślnego ID (w przeciwieństwie do projektu `przepisy`). Brak GET → nie uruchamiasz Skryptu 3. Galeria (Skrypt 2) i tak działa.

---

## SEC-2: Zapytanie 3 zmodyfikowane o ID — `JOIN` z tabelą `opis`

Opis szczytu siedzi w **osobnej** tabeli `opis`, powiązanej kluczem (w kontrolce: `opis.szczyty_id` = `szczyty.id`).

Pełne nazwy tabel, bez aliasów:

```sql
SELECT szczyty.plik, szczyty.nazwa, szczyty.wysokosc, szczyty.pasmo, opis.opis
FROM szczyty
JOIN opis ON szczyty.id = opis.szczyty_id
WHERE szczyty.id = $id;
```

- **`JOIN opis ON …`** — dokleja wiersz opisu do wiersza szczytu.
- **`WHERE szczyty.id = $id`** — **modyfikacja z arkusza**: tylko kliknięty szczyt.

To zapytanie zwraca **co najwyżej jeden** wiersz (jeden szczyt + jego opis).

---

## SEC-3: Jedno `fetch_assoc()` — bez pętli `while`

Szukamy po unikalnym ID, więc:

```php
$result = $conn->query($query);
$row = $result->fetch_assoc();
```

Pętla `while` jest do **wielu** rekordów (lista, galeria). Tutaj jeden rekord = jedno wywołanie.

---

## SEC-4: Co wyświetlić? (obraz `.duze`, `h2`, wysokość i pasmo, opis)

Arkusz wymaga:

1. **Obraz** — `src` z pola pliku, `alt` o treści **`szczyt`** **albo** nazwa szczytu, klasa **`duze`**.
2. **Nagłówek drugiego stopnia `<h2>`** z nazwą szczytu.
3. **`<h3>` lub `<p>`** z wysokością i pasmem górskim.
4. **Paragraf `<p>`** z opisem z połączonej tabeli `opis`.

Kontrolka (zgodna z arkuszem — `alt` = nazwa, wysokość i pasmo w paragrafach):

```php
echo "<img src='" . $row['plik'] . "' alt='" . $row['nazwa'] . "' class='duze'>";
echo "<h2>" . $row['nazwa'] . "</h2>";
echo "<p>Wysokość: " . $row['wysokosc'] . " m n.p.m.</p>";
echo "<p>Pasmo górskie: " . $row['pasmo'] . "</p>";
echo "<p>" . $row['opis'] . "</p>";
```

Równie poprawne według arkusza: `alt="szczyt"` oraz jeden `<h3>` zamiast dwóch `<p>` przy wysokości i paśmie.

| Element            | Klasa / znacznik | Źródło danych        |
| ------------------ | ---------------- | -------------------- |
| Duże zdjęcie       | `class="duze"`   | `$row['plik']`       |
| Nazwa              | `<h2>`           | `$row['nazwa']`      |
| Wysokość, pasmo    | `<p>` lub `<h3>` | `$row['wysokosc']`, `$row['pasmo']` |
| Opis               | `<p>`            | `$row['opis']`       |

Nie używaj tu klasy `miniatury` — to Skrypt 2.

---

# Podsumowanie przepływu danych

```text
index.php → szczyty.php?id=5
                 ↓
isset($_GET['id']) → $id
                 ↓
SELECT … JOIN opis … WHERE szczyty.id = $id
                 ↓
$row = fetch_assoc()   (raz)
                 ↓
<img class="duze">  <h2>  wysokość / pasmo  <p>opis</p>
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie**              | **Co robi?**                                              |
| ------------------------ | --------------------------------------------------------- |
| **`$_GET['id']`**        | ID wysłane z listy na `index.php`.                        |
| **`isset()`**            | Czy parametr w ogóle przyszedł.                           |
| **`JOIN opis`**          | Pobiera opis z drugiej tabeli.                            |
| **`WHERE szczyty.id`**   | Filtr Skryptu 3.                                          |
| **`class="duze"`**       | Duży obraz na karcie szczytu.                             |
| **`<h2>`**               | Nazwa szczytu (nagłówek 2. stopnia).                      |
| **`$row['opis']`**       | Tekst z tabeli `opis`.                                    |

---

### Gratulacje!

Masz pełny cykl Korony Gór: lista z GET, galeria na obu stronach, karta szczytu ze złączeniem tabel.

🏠 **[Wróć do głównego spisu treści](../README.md)**

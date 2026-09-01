> **Krok 2 z 3** | [W Kroku 1](../01_lista_szczyty_get/README.md) zbudowaliśmy listę odnośników. Teraz **Skrypt 2**: te same 10 miniatur na `index.php` **i** na `szczyty.php`.

---

# Kompletny przewodnik: Skrypt 2 — galeria miniatur (`LIMIT 10`, klasa `miniatury`)

Ta ściąga wytłumaczy Ci **od A do Z** zapytanie 2, pętlę po rekordach oraz budowę znacznika `<img>` z pliku i nazwy szczytu.

---

## SEC-1: Zapytanie 2 — `nazwa`, `plik`, `LIMIT 10`

Arkusz podaje zapytanie 2 wprost:

```sql
SELECT nazwa, plik FROM szczyty LIMIT 10;
```

- **`nazwa`** — pójdzie do atrybutu **`alt`**.
- **`plik`** — pójdzie do atrybutu **`src`** (nazwa pliku graficznego z bazy, np. `rysy.jpg`).
- **`LIMIT 10`** — baza zwraca **co najwyżej 10** wierszy. To nie jest pętla PHP `for (i = 1; i <= 10)` — limit ustala SQL.

```php
$query = "SELECT nazwa, plik FROM szczyty LIMIT 10;";
$result = $conn->query($query);
```

---

## SEC-2: Pętla `while` — jeden obraz na rekord

Wyników jest wiele (do 10), więc znowu pętla, nie pojedyncze `fetch_assoc()`.

```php
while ($row = $result->fetch_assoc()) {
    // jeden <img> na jeden szczyt
}
```

Każdy obieg to jeden wiersz: para `nazwa` + `plik`.

---

## SEC-3: `src` z pliku, `alt` z nazwy, klasa `miniatury`

Arkusz:

- źródłem obrazu jest **nazwa pliku** zwrócona zapytaniem,
- tekstem alternatywnym jest **nazwa szczytu**,
- każdy obraz ma klasę **`miniatury`**.

```php
echo "<img src='" . $row['plik'] . "' alt='" . $row['nazwa'] . "' class='miniatury'>";
```

Albo interpolacja z kontrolki:

```php
echo "<img src='{$row['plik']}' alt='{$row['nazwa']}' class='miniatury'>";
```

| Atrybut HTML     | Kolumna z bazy   | Po co                                      |
| ---------------- | ---------------- | ------------------------------------------ |
| **`src`**        | `$row['plik']`   | Który plik wczytać.                        |
| **`alt`**        | `$row['nazwa']`  | Tekst, gdy grafika się nie wczyta.         |
| **`class`**      | stała `miniatury`| Styl z `styl.css` (małe zdjęcia w sekcji). |

Klasa **`miniatury`** jest wymagana. Na stronie szczegółów duże zdjęcie ma inną klasę (`duze`) — nie myl ich.

---

## SEC-4: Ten sam skrypt na obu stronach

Arkusz: Skrypt 2 działa na **`index.php` oraz `szczyty.php`**.

W praktyce wklejasz **identyczny** blok PHP do `<section>` na obu plikach:

- ta sama treść zapytania,
- ta sama pętla,
- te same atrybuty obrazów.

Galeria **nie** zależy od `$_GET['id']`. Działa zawsze, także gdy ktoś wejdzie na `szczyty.php` bez parametru.

Każdy plik i tak ma własne `$conn` — Skrypt 2 używa połączenia otwartego na górze **tej** strony.

---

# Podsumowanie przepływu danych

```text
SELECT nazwa, plik FROM szczyty LIMIT 10
                 ↓
while fetch_assoc()
                 ↓
<img src="plik" alt="nazwa" class="miniatury">
                 ↓
identyczny kod w index.php i szczyty.php
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie**           | **Co robi?**                                           |
| --------------------- | ------------------------------------------------------ |
| **`LIMIT 10`**        | Ograniczenie liczby wierszy po stronie SQL.            |
| **`$row['plik']`**    | Wartość atrybutu `src`.                                |
| **`$row['nazwa']`**   | Wartość atrybutu `alt`.                                |
| **`class="miniatury"`** | Klasa CSS wymagana w arkuszu.                        |
| **Dwie strony**       | Ten sam Skrypt 2 w `index.php` i `szczyty.php`.        |

---

### Co dalej?

Po kliknięciu w nazwę z listy otwiera się `szczyty.php`. Tam **Skrypt 3** pokaże szczegóły jednego szczytu.

👉 **[Przejdź do Kroku 3: Szczegóły szczytu i JOIN](../03_szczegoly_szczytu_join/README.md)**

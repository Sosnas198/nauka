> **Krok 3 z 3** | [W Kroku 2](../02_rozwijana_lista_select/README.md) lista rozwijana wysyła `id` w POST. Teraz **Skrypt 3**: objawy wybranej choroby przez tabelę łączącą `choroby_objawy`.

---

# Kompletny przewodnik: Skrypt 3 — POST, `isset()`, JOIN N:M i `<span>` ze spacjami

Ta ściąga wytłumaczy Ci **od A do Z**, kiedy w ogóle uruchamiać skrypt, jak odczytać wybraną chorobę z formularza oraz jak wypisać wiele objawów w znacznikach `<span>`.

---

## SEC-1: Skrypt tylko po wysłaniu formularza (`isset` + POST)

Arkusz: Skrypt 3 wykonuje się **tylko wtedy, gdy formularz wysłał dane (metoda POST)**.

Przycisk ma `name="sprawdz"`. Po kliknięciu w `$_POST` pojawia się ten klucz.

```php
if (isset($_POST["sprawdz"])) {
    $choroba_id = $_POST["choroba"];
    // zapytanie i pętla
}
```

- **`isset($_POST["sprawdz"])`** — czy w ogóle kliknięto „Sprawdź”? Przy pierwszym wejściu na stronę (GET) tablica POST jest pusta: **nie** odpytujesz objawów.
- **`$_POST["choroba"]`** — `value` wybranej opcji, czyli **`id`** choroby (Skrypt 2).

To jest **bezpieczniejsze** niż od razu sięganie po `$_POST["choroba"]` bez `isset`: unikasz ostrzeżenia *Undefined array key* przy zwykłym odświeżeniu strony.

Odczytujesz POST **po** nazwie pola (`choroba`), nie po etykiecie przycisku w języku polskim.

---

## SEC-2: Tabela łącząca `choroby_objawy` (relacja N:M)

- Jedna choroba ma **wiele** objawów.
- Jeden objaw (np. gorączka) może dotyczyć **wielu** chorób.

Pary siedzą w tabeli **`choroby_objawy`** (klucze `id_choroby`, `id_objawy`). Nazwy objawów są w tabeli **`objawy`**.

Bez `JOIN` masz tylko numery, nie teksty do wyświetlenia.

---

## SEC-3: Zapytanie 3 zmodyfikowane o ID z formularza

Arkusz (aliasy `o` i `co`):

```sql
SELECT o.nazwa
FROM objawy o
JOIN choroby_objawy co ON o.id = co.id_objawy
WHERE co.id_choroby = '$choroba_id';
```

- **`objawy o`** — tabela objawów, skrót `o`.
- **`choroby_objawy co`** — tabela łącząca, skrót `co`.
- **`ON o.id = co.id_objawy`** — połącz nazwę objawu z wierszem powiązania.
- **`WHERE co.id_choroby = '$choroba_id'`** — **modyfikacja z arkusza**: tylko objawy wybranej choroby.

Równoważnie bez aliasów (czytelniej, ten sam wynik):

```sql
SELECT objawy.nazwa
FROM objawy
JOIN choroby_objawy ON objawy.id = choroby_objawy.id_objawy
WHERE choroby_objawy.id_choroby = '$choroba_id';
```

Na egzaminie zostaw wersję z arkusza (aliasy), jeśli tak podano zapytanie 3.

Wyników jest **wiele** — pętla `while`, nie pojedyncze `fetch_assoc()` jak przy `AVG`.

Kolumna w `$row` nazywa się **`nazwa`** (z `SELECT o.nazwa`), nie `o.nazwa`.

---

## SEC-4: Każdy objaw w `<span>` ze spacjami

Arkusz: każdy objaw w znaczniku **`<span>`**, **przed i po** objawie spacja: `` `<span>nazwa</span> ` ``

```php
while ($row = $result->fetch_assoc()) {
    echo "<span>" . $row["nazwa"] . "</span> ";
}
```

- Treść w środku `<span>` to nazwa objawu.
- **Spacja po `</span>`** rozdziela kolejne objawy w jednej linii (jak w kontrolce).
- Nie używasz tu `<li>` ani `<option>` — inny znacznik niż w Skryptach 1 i 2.

Blok wyniku w HTML to zwykle `<div id="wynik">` — skrypt tylko dopisuje spany.

---

# Podsumowanie przepływu danych

```text
Klik „Sprawdź”
                 ↓
isset($_POST["sprawdz"]) → TAK
                 ↓
$choroba_id = $_POST["choroba"]
                 ↓
JOIN objawy + choroby_objawy
WHERE id_choroby = $choroba_id
                 ↓
while fetch_assoc()
                 ↓
<span>nazwa</span>␠
```

Bez POST: Skrypt 3 się **nie** wykonuje. Skrypty 1 i 2 działają zawsze.

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie**                    | **Co robi?**                                         |
| ------------------------------ | ---------------------------------------------------- |
| **`method="post"`**            | Wysyłka formularza bez parametrów w URL.             |
| **`isset($_POST["sprawdz"])`** | Strażnik: skrypt tylko po kliknięciu przycisku.      |
| **`$_POST["choroba"]`**        | ID wybrane w `<select>`.                             |
| **`choroby_objawy`**           | Tabela łącząca choroby z objawami (N:M).             |
| **`JOIN`**                     | Pobiera nazwy objawów, nie tylko numery.             |
| **`<span>…</span> `**          | Objaw + spacja zgodnie z arkuszem.                   |

---

### Gratulacje!

Masz pełny cykl strony: lista zakaźnych, select ze wszystkimi chorobami oraz objawy po POST.

🏠 **[Wróć do głównego spisu treści](../README.md)**

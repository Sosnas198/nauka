# Kompletny przewodnik: Wyszukiwanie i wyświetlanie opisu gry po ID (zapytania przygotowane)

Ten przewodnik tłumaczy **od A do Z**, jak Skrypt #3 obsługuje formularz w stopce strony — użytkownik wpisuje numer `id` gry, a skrypt wyszukuje ją w bazie i wyświetla jej nazwę, punkty, cenę oraz skrócony opis.

---

## 🎯 Cel skryptu

Po wysłaniu formularza z polem `inputopis`, pobrać z bazy danych **jeden konkretny wiersz** (grę o podanym `id`) i wyświetlić jego szczegóły w nagłówku i paragrafie.

> ℹ️ **Uwaga:** Ten skrypt korzysta ze zmiennej `$conn` (połączenia z bazą danych), tworzonej raz na początku głównego pliku projektu.

---

## SEC-1: Sprawdzenie, czy formularz został wysłany (`isset`)

```php
if (isset($_POST['pokazopis'])) {
    // ... (patrz SEC-2, SEC-3)
}
```

### Jak to działa?

- **`isset($_POST['pokazopis'])`** — sprawdza, czy w danych formularza istnieje pole o nazwie `pokazopis`. To nazwa **przycisku** submitującego formularz (`<button type="submit" name="pokazopis">`). PHP rejestruje w `$_POST` nazwę tego przycisku **tylko wtedy**, gdy to właśnie on został kliknięty. Dzięki temu ten fragment kodu uruchamia się wyłącznie po kliknięciu "Pokaż opis", a nie np. po wejściu na stronę czy po wysłaniu innego formularza (np. "DODAJ" z sekcji prawej).

---

## SEC-2: Odczytanie i podstawowa walidacja wpisanego ID

```php
$id = $_POST['inputopis'];
if ($id !== false && $id !== null) {
    // ... (patrz SEC-3)
} else {
    echo "<p>Podaj poprawne ID.</p>";
}
```

### Jak to działa?

- **`$id = $_POST['inputopis'];`** — pobieramy wartość wpisaną przez użytkownika w polu tekstowym `inputopis` i zapisujemy w zmiennej `$id`.
- **`if ($id !== false && $id !== null)`** — operator `!==` to porównanie **ścisłe** ("różne od", uwzględniające również typ danych, nie tylko wartość). Ten warunek sprawdza, czy `$id` nie jest ani `false`, ani `null` — czyli czy w ogóle udało się odczytać jakąś wartość z formularza.
- Jeśli walidacja przejdzie pomyślnie — przechodzimy do wyszukania gry w bazie (SEC-3).
- Jeśli nie — wypisujemy komunikat `<p>Podaj poprawne ID.</p>`.

---

## SEC-3: Bezpieczne wyszukanie gry w bazie danych (zapytanie przygotowane — `prepare`)

```php
$stmt = $conn->prepare("SELECT nazwa, LEFT(opis, 100) AS opis, punkty, cena FROM gry WHERE id = ?");
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
```

### Jak to działa?

- **`$conn->prepare("...")`** — to tzw. **zapytanie przygotowane** (*prepared statement*). Zamiast wklejać wartość `$id` bezpośrednio do tekstu zapytania SQL (co byłoby niebezpieczne — mogłoby umożliwić atak zwany SQL Injection), w zapytaniu umieszczamy znak zapytania `?` jako "puste miejsce" na przyszłą wartość.
- **`LEFT(opis, 100) AS opis`** — to funkcja SQL, która **obcina** tekst z kolumny `opis` do pierwszych 100 znaków (żeby na stronie nie wyświetlać bardzo długiego opisu w całości), a wynik nazywa z powrotem `opis` dzięki `AS opis` (tzw. alias).
- **`$stmt->bind_param("i", $id);`** — ta linijka **podstawia** prawdziwą wartość `$id` w miejsce znaku `?` z zapytania. Litera `"i"` informuje PHP, że podstawiana wartość ma być traktowana jako liczba całkowita (*integer*) — to dodatkowe zabezpieczenie, bo nawet gdyby ktoś wpisał w polu tekst zamiast liczby, zostanie on zinterpretowany jako liczba (lub błąd).
- **`$stmt->execute();`** — faktycznie wykonuje tak przygotowane i uzupełnione zapytanie na serwerze bazy danych.
- **`$stmt->get_result();`** — pobiera wynik zapytania (podobnie jak `$conn->query()` w innych skryptach) i zapisuje go w `$result`, żeby można było go dalej przetworzyć (np. przez `fetch_assoc()`).

---

## SEC-4: Wyświetlenie znalezionej gry albo komunikatu o braku wyniku

```php
if ($row = $result->fetch_assoc()) {
    echo "<h2>" . htmlspecialchars($row["nazwa"]) . ", " . (int)$row["punkty"] . " punktów, " . htmlspecialchars($row["cena"]) . " zł</h2>";
    echo "<p>" . htmlspecialchars($row["opis"]) . "</p>";
} else {
    echo "<p>Nie znaleziono gry.</p>";
}
$stmt->close();
```

### Jak to działa?

- **`if ($row = $result->fetch_assoc())`** — próbujemy pobrać jeden wiersz wyniku. Jeśli gra o podanym `id` **istnieje** w bazie, `$row` będzie zawierać dane i warunek `if` będzie prawdziwy. Jeśli gra **nie istnieje**, `fetch_assoc()` zwróci `null` (czyli "fałsz" w warunku), więc wykona się blok `else`.
- **`htmlspecialchars($row["nazwa"])`** — funkcja `htmlspecialchars()` zamienia w tekście znaki specjalne HTML (np. `<`, `>`, `"`) na ich bezpieczne odpowiedniki (np. `&lt;`). Zabezpiecza to stronę przed wstrzyknięciem złośliwego kodu HTML/JavaScript, gdyby ktoś w bazie danych miał nazwę gry zawierającą takie znaki.
- **`(int)$row["punkty"]`** — rzutowanie na liczbę całkowitą (`int`). Upewnia się, że liczba punktów zostanie wypisana jako "czysta" liczba, a nie np. jako tekst z dodatkowymi białymi znakami.
- Cały nagłówek `<h2>` wypisuje: **nazwę gry, liczbę punktów i cenę** — dokładnie w formacie wymaganym w treści zadania.
- Paragraf `<p>` wypisuje skrócony (do 100 znaków, patrz SEC-3) opis gry.
- **`$stmt->close();`** — zamyka przygotowane zapytanie (`$stmt`), zwalniając zasoby serwera. To osobna operacja od zamknięcia całego połączenia `$conn->close()` (które następuje dopiero na samym końcu głównego pliku, po wykonaniu wszystkich skryptów).

---

## 🧠 Ściągawka z najważniejszych pojęć

| **Pojęcie / Funkcja**       | **Co oznacza / Co robi?**                                                                     |
| ---------------------------- | ----------------------------------------------------------------------------------------------- |
| `$conn->prepare("... ? ...")` | Tworzy zapytanie SQL ze "slotem" (`?`) na przyszłą wartość — bezpieczniejsze niż wklejanie wartości wprost do tekstu zapytania. |
| `bind_param("i", $zmienna)`   | Podstawia wartość zmiennej w miejsce `?`. Litera `"i"` oznacza typ liczba całkowita (*integer*).  |
| `execute()`                   | Wykonuje przygotowane wcześniej zapytanie na serwerze bazy danych.                                |
| `get_result()`                | Pobiera wynik zapytania wykonanego przez `prepare()` + `execute()`.                               |
| `LEFT(kolumna, N)`             | Funkcja SQL obcinająca tekst do pierwszych `N` znaków.                                            |
| `AS nazwa`                    | Nadaje wynikowi zapytania SQL alias (nazwę), pod którą można się do niego odwołać w PHP.          |
| `htmlspecialchars()`           | Zamienia znaki specjalne HTML na bezpieczne odpowiedniki — chroni przed wstrzyknięciem kodu.       |
| `!==`                          | Ścisłe porównanie "różne od" — sprawdza zarówno wartość, jak i typ danych.                        |
| `$stmt->close()`               | Zamyka przygotowane zapytanie (osobno od zamknięcia całego połączenia z bazą).                    |

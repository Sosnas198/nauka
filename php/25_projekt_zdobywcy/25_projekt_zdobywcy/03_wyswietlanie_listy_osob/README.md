# Kompletny przewodnik: Pobieranie wierszy z bazy danych i wyświetlanie ich w tabeli HTML

Ta ściąga wytłumaczy Ci **od A do Z**, jak PHP pyta bazę danych o listę zapisanych osób, jak "przechodzi" przez zwrócone wiersze jeden po drugim oraz jak z nich buduje wiersze tabeli HTML.

---

## SEC-1: Wysłanie zapytania `SELECT` do bazy danych

Zanim cokolwiek wyświetlimy, musimy poprosić bazę danych o dane — czyli wysłać zapytanie typu `SELECT` (czyli "wybierz/pobierz mi dane").

```php
$sql = "SELECT nazwisko, imie, funkcja, email FROM osoby;";
$result = $conn -> query($sql);
```

### Jak to działa?

- **`SELECT nazwisko, imie, funkcja, email`** – mówimy bazie danych, które dokładnie kolumny nas interesują (nie pobieramy np. kolumny `id`, bo w tym miejscu nie jest nam potrzebna do wyświetlenia).
- **`FROM osoby`** – wskazujemy, z której tabeli mają pochodzić dane — tutaj z tabeli `osoby` (tej samej, do której w module `02_dodawanie_osoby_z_formularza` wstawialiśmy nowe wiersze).
- **`$conn -> query($sql)`** – tak jak poprzednio, korzystamy z gotowego połączenia `$conn` i wysyłamy przez nie nasze zapytanie SQL do serwera.
- **`$result`** – tym razem ta zmienna jest bardzo ważna! W przypadku zapytania `SELECT`, `$result` nie jest puste — zawiera w sobie **całą tabelę wyników**, którą baza danych zwróciła (czyli wszystkie wiersze pasujące do zapytania). Możemy teraz "przeglądać" tę tabelę wiersz po wierszu.

> **Uwaga:** `->` to tzw. operator strzałki, używany do "wywoływania" metod (czynności) lub pobierania właściwości z obiektu (tutaj: z obiektu `$conn`). Zapis `$conn -> query($sql)` czytamy: "na obiekcie `$conn` wykonaj czynność `query`, przekazując jej `$sql`".

---

## SEC-2: Przechodzenie przez zwrócone wiersze w pętli (`while` + `fetch_assoc()`)

Baza danych mogła zwrócić 1 wiersz, 10 wierszy albo wcale żadnego — nie wiemy tego z góry. Dlatego używamy pętli `while`, która będzie się powtarzać dokładnie tyle razy, ile wierszy zwróciła baza danych.

```php
while ($row = $result -> fetch_assoc()) {
    $nazwisko = $row["nazwisko"];
    $imie = $row["imie"];
    $funkcja = $row["funkcja"];
    $email = $row["email"];
    // ...
}
```

### Jak to działa? Krok po kroku

- **`$result -> fetch_assoc()`** – ta metoda za każdym wywołaniem "wyciąga" **jeden, kolejny** wiersz z wyników zapytania (z `$result`) i zwraca go w postaci tzw. tablicy asocjacyjnej, czyli zbioru par "nazwa kolumny → wartość" (np. `["nazwisko" => "Kowalski", "imie" => "Jan", ...]`). Gdy wiersze się skończą, `fetch_assoc()` zwraca `false`.
- **`$row = $result -> fetch_assoc()`** – zapisujemy pobrany wiersz do zmiennej `$row`. Jednocześnie ten sam zapis jest warunkiem pętli `while`.
- **`while (...)`** – pętla `while` sprawdza warunek w nawiasie i **dopóki jest on prawdziwy** (czyli dopóki `fetch_assoc()` zwraca kolejny, prawdziwy wiersz, a nie `false`), wykonuje kod w środku nawiasów klamrowych `{ }`. Gdy wiersze się skończą (`fetch_assoc()` zwróci `false`), pętla automatycznie się zatrzymuje.
- **`$row["nazwisko"]`** – skoro `$row` to tablica asocjacyjna, to żeby pobrać z niej konkretną wartość, podajemy w nawiasach kwadratowych nazwę kolumny (dokładnie taką, jaka była w zapytaniu `SELECT` z SEC-1). Analogicznie dla `imie`, `funkcja` i `email`.
- Zapisujemy każdą z tych wartości do osobnej, "wygodniejszej" zmiennej — dokładnie po to, żeby łatwiej się nimi posłużyć w kolejnym kroku (SEC-3).

> **Ważne:** Ta pętla wykona się od nowa dla **każdej osoby zapisanej w bazie**. Jeśli w tabeli `osoby` są np. 3 rekordy, pętla wykona się 3 razy — za każdym razem z innymi danymi w `$row`.

---

## SEC-3: Budowanie wiersza tabeli HTML za pomocą `echo`

Mając już dane pojedynczej osoby w zmiennych, musimy je "wypisać" na stronę w postaci wiersza tabeli HTML (`<tr>` = table row, `<th>`/`<td>` = komórka tabeli).

```php
echo "<tr>";
    echo "<th>$nazwisko</th>";
    echo "<th>$imie</th>";
    echo "<th>$funkcja</th>";
    echo "<th>$email</th>";
echo "</tr>";
```

### Jak to działa?

- **`echo`** – to podstawowe polecenie PHP służące do "wypisania" czegokolwiek na stronę (dokładnie w tym miejscu kodu, w którym się znajduje).
- **`echo "<tr>";`** – wypisuje na stronę zwykły tekst `<tr>`, czyli znacznik HTML otwierający nowy wiersz tabeli. PHP traktuje to jako zwykły ciąg znaków — to przeglądarka, odbierając gotową stronę, zinterpretuje ten tekst jako HTML.
- **`echo "<th>$nazwisko</th>";`** – tutaj dzieje się coś ważnego: wewnątrz cudzysłowów podwójnych `" "` PHP automatycznie podmienia `$nazwisko` na **aktualną wartość** tej zmiennej (np. na `Kowalski`). Ten mechanizm nazywa się *interpolacją zmiennych w stringu*. Dzięki temu na stronie pojawi się np. `<th>Kowalski</th>`.
- Dokładnie tak samo działa to dla `$imie`, `$funkcja` i `$email` — każda wartość trafia do osobnej komórki `<th>`.
- **`echo "</tr>";`** – zamyka wiersz tabeli.
- Cała ta sekwencja `echo` powtarza się **raz na każdy przebieg pętli `while`** z SEC-2 — czyli raz na każdą osobę z bazy danych. Dzięki temu tabela na stronie wypełnia się tyloma wierszami, ile osób jest zapisanych w tabeli `osoby`.

> **Skąd wiadomo, że to trafi akurat do `<tbody>` tabeli?** Bo dokładnie w tym miejscu (wewnątrz znacznika `<tbody>...</tbody>` w pliku HTML) został wstawiony ten blok kodu PHP. PHP "wstrzykuje" swój wynik dokładnie tam, gdzie w pliku fizycznie się znajduje.

---

# Podsumowanie przepływu danych

```text
SEC-1: $sql = "SELECT ... FROM osoby"
       $result = $conn -> query($sql)
       — Wysłanie zapytania i otrzymanie całego zestawu wyników
                 ↓
SEC-2: while ($row = $result -> fetch_assoc())
       — Pobieranie po jednym wierszu z wyników, aż się skończą
                 ↓
SEC-3: echo "<tr>...</tr>"
       — Wypisanie danych pojedynczej osoby jako wiersza tabeli HTML
                 ↓
       Powtórka SEC-2 → SEC-3 dla każdej kolejnej osoby w bazie
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**       | **Co oznacza / Co robi?**                                                                 |
| ------------------------------ | -------------------------------------------------------------------------------------------- |
| **`SELECT ... FROM ...`**      | Polecenie SQL pobierające dane (wiersze) z konkretnej tabeli w bazie danych.                |
| **`$conn -> query($sql)`**     | Wysyła zapytanie SQL do bazy i zwraca wynik (dla `SELECT` — cały zestaw wierszy).            |
| **`fetch_assoc()`**            | Pobiera jeden, kolejny wiersz wyników jako tablicę "nazwa kolumny → wartość".                |
| **pętla `while`**              | Powtarza kod w środku, dopóki warunek jest prawdziwy — tu: dopóki są jeszcze jakieś wiersze. |
| **interpolacja zmiennych**     | Automatyczna podmiana `$zmienna` na jej wartość wewnątrz cudzysłowów podwójnych `" "`.       |
| **`echo`**                     | Wypisuje podany tekst (tutaj: fragment kodu HTML) na stronę.                                 |

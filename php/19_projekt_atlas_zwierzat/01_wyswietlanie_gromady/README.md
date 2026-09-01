> **Krok 1 z 2** | Start projektu. Teraz **Skrypt 1**: nagłówek gromady i lista zwierząt danej gromady.

---

# Kompletny przewodnik: Skrypt 1 — nagłówek gromady i zapytanie z `WHERE`

---

## Wprowadzenie — o co chodzi w tej części zadania?

Ten skrypt reaguje na wybór użytkownika w formularzu — użytkownik wpisuje liczbę od 1 do 5 (odpowiadającą jednej z pięciu gromad zwierząt: ryby, płazy, gady, ptaki, ssaki), a strona ma pokazać dwie rzeczy: po pierwsze nazwę wybranej gromady jako nagłówek, po drugie listę wszystkich gatunków zwierząt należących do tej gromady, razem z miejscem ich występowania.

To dobry przykład skryptu, w którym mamy do czynienia z **dwoma niezależnymi zadaniami** wykonywanymi jedno po drugim na podstawie tej samej danej wejściowej (`$_POST["gromada"]`): najpierw proste tłumaczenie liczby na nazwę (bez użycia bazy danych), a potem właściwe zapytanie do bazy, które korzysta z tej samej liczby jako warunku filtrującego wyniki.

---

## SEC-1: Sprawdzenie, czy formularz został wysłany

```php
if(isset($_POST["gromada"])) {
    $gromada = $_POST["gromada"];
    ...
}
```

- **`isset($_POST["gromada"])`** — sprawdza, czy w tablicy `$_POST` (czyli w danych przesłanych metodą POST z formularza) w ogóle istnieje klucz `"gromada"`. Dzięki temu warunkowi cały kod wewnątrz `if` wykona się **tylko** wtedy, gdy formularz faktycznie został wysłany — przy pierwszym wejściu na stronę (zanim użytkownik cokolwiek wpisze i kliknie „Wyświetl”) `$_POST` byłby pusty, więc ta sekcja strony pozostałaby po prostu niewypełniona, bez błędów PHP o nieistniejącym indeksie.
- **`$gromada = $_POST["gromada"]`** — zapisujemy przesłaną wartość (numer gromady wpisany przez użytkownika w polu `<input type="number" name="gromada">`) do zmiennej `$gromada`, żeby wygodnie się do niej odwoływać w dalszej części kodu.

---

## SEC-2: Wypisanie nazwy gromady w nagłówku `<h2>`

Arkusz: w zależności od wartości pola, w nagłówku drugiego stopnia wypisywana jest odpowiednia nazwa gromady: 1 – „RYBY”, 2 – „PŁAZY”, 3 – „GADY”, 4 – „PTAKI”, 5 – „SSAKI”.

```php
if($gromada == 1) {
    echo "<h2>RYBY</h2>";
}
else if ($gromada == 2) {
    echo "<h2>PŁAZY</h2>";
}
else if ($gromada == 3) {
    echo "<h2>GADY</h2>";
}
else if ($gromada == 4) {
    echo "<h2>PTAKI</h2>";
}
else if ($gromada == 5) {
    echo "<h2>SSAKI</h2>";
}
```

To jest po prostu seria warunków `if / else if`, które po kolei sprawdzają wartość `$gromada` i wypisują odpowiadający jej tekst wewnątrz znacznika `<h2>`. Warto zwrócić uwagę na dwie rzeczy:

- Porównanie odbywa się operatorem `==` (porównanie "luźne"), a nie `===` (porównanie "ścisłe"). Dzięki temu porównanie zadziała poprawnie, nawet jeśli `$gromada` będzie tekstem `"1"` (bo dane z formularza HTML zawsze przychodzą jako tekst), a nie liczbą całkowitą `1` — PHP samo "dogada się" z tą różnicą typów przy porównaniu `==`.
- Kolejne warunki są sprawdzane **po kolei**, od góry do dołu — gdy jeden z nich okaże się prawdziwy, reszta (`else if`) w ogóle nie jest już sprawdzana. Jeżeli użytkownik wpisze wartość spoza zakresu 1–5 (np. 0 albo 9), żaden z warunków nie będzie prawdziwy i żaden nagłówek `<h2>` się nie pojawi — ale zapytanie do bazy (SEC-3 poniżej) i tak zostanie wysłane, po prostu nie zwróci żadnych wierszy.

---

## SEC-3: Zapytanie 1 zmodyfikowane — zwierzęta z wybranej gromady

```php
$sql = "SELECT gatunek, wystepowanie FROM zwierzeta, gromady WHERE zwierzeta.Gromady_id = gromady.id AND gromady.id = $gromada;";
$result = $conn->query(query: $sql);
```

To zapytanie SQL korzysta z **dwóch** tabel jednocześnie — `zwierzeta` i `gromady`. Przeanalizujmy je krok po kroku:

- **`FROM zwierzeta, gromady`** — wskazujemy, że dane mają pochodzić jednocześnie z obu tych tabel. To starszy, "przecinkowy" sposób łączenia tabel w SQL (odpowiednik `JOIN`), spotykany często w materiałach szkolnych — działa on tak, że bez dodatkowego warunku SQL "skrzyżowałby" każdy wiersz jednej tabeli z każdym wierszem drugiej, dlatego kluczowy jest warunek w `WHERE`.
- **`WHERE zwierzeta.Gromady_id = gromady.id`** — to jest właśnie ten warunek łączący: mówi on bazie, żeby zestawiała ze sobą tylko te wiersze, w których identyfikator gromady w tabeli `zwierzeta` (`Gromady_id`) zgadza się z identyfikatorem konkretnej gromady w tabeli `gromady` (`id`). Bez tego warunku dostalibyśmy bezsensowne, przypadkowe kombinacje zwierząt z gromadami.
- **`AND gromady.id = $gromada`** — to jest dokładnie ta "modyfikacja zapytania 1" wspomniana w arkuszu: dodatkowy warunek ograniczający wynik tylko do jednej, konkretnej gromady — tej, którą użytkownik wpisał w formularzu. Zmienna `$gromada` jest tu wstawiona bezpośrednio do treści zapytania (tzw. interpolacja zmiennej w łańcuchu tekstowym w cudzysłowie podwójnym).
- **`$conn->query(query: $sql)`** — wysyłamy tak zbudowane zapytanie do bazy danych. Zapis `query: $sql` to tzw. argument nazwany (ang. *named argument*) — nowsza składnia PHP (od wersji 8.0), pozwalająca jawnie podać nazwę parametru funkcji (`query`), do którego przekazujemy wartość `$sql`. Działa dokładnie tak samo, jak zwykłe `$conn->query($sql)`, ale jest bardziej opisowa.

---

## SEC-4: Wypisanie wyników w formacie „gatunek, występowanie”

Arkusz: wartości zwrócone zapytaniem są wypisywane w osobnych wierszach, w formacie „<gatunek>, <występowanie>”.

```php
while($row = $result -> fetch_array()) {
    echo $row["gatunek"].", ".$row["wystepowanie"]."<br>";
}
```

- **`$result->fetch_array()`** — podobnie jak poznane wcześniej `fetch_assoc()`, ta metoda pobiera jeden wiersz wyniku zapytania na raz, ale zwraca go zarówno jako tablicę asocjacyjną (dostęp po nazwie kolumny, np. `$row["gatunek"]`), jak i jako tablicę indeksowaną liczbowo (dostęp po numerze kolumny, np. `$row[0]`) — stąd nazwa "array", w odróżnieniu od "assoc".
- W pętli `while` dla każdego zwróconego wiersza wypisujemy tekst w dokładnie takim formacie, jaki wymaga arkusz: najpierw nazwa gatunku, potem przecinek ze spacją, potem miejsce występowania, a na końcu znacznik `<br>`, żeby każdy wynik pojawił się w nowej linii.

---

👉 **[Krok 2: Wszystkie zwierzęta w bazie](../02_wszystkie_zwierzeta/README.md)**

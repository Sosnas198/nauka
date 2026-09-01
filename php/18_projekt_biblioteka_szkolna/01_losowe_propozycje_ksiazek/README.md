# Kompletny przewodnik: Skrypt 1 — losowe propozycje książek w tabeli (`ORDER BY RAND()`, `LIMIT`)

---

## Wprowadzenie — o co w ogóle chodzi w tym zadaniu?

Ten skrypt ma za zadanie wylosować kilka książek z bazy danych i pokazać je w tabeli HTML. Wyobraź sobie, że biblioteka szkolna ma tysiące pozycji w swoim katalogu, a strona główna ma codziennie pokazywać inny, losowy zestaw "polecanych" książek — tak, żeby odwiedzający nie widział zawsze tych samych pięciu tytułów. Właśnie to realizuje poniższy kod: łączy się z bazą, prosi ją o 5 losowych rekordów, a następnie "rozkłada" te dane na wiersze tabeli.

Warto zauważyć, że to zadanie jest prostsze od poprzednich projektów — nie ma tu żadnego formularza ani obsługi danych przesyłanych przez użytkownika (`$_POST`, `$_GET`). Jest tylko **jedno** zapytanie do bazy i wypisanie wyniku. Dzięki temu skrypt jest dobrą okazją, żeby dokładnie prześledzić, jak krok po kroku wygląda "klasyczny" cykl pracy z bazą danych w PHP: **połącz się → zapytaj → przetwórz wynik → zamknij połączenie.**

---

## SEC-1: Nawiązanie połączenia z bazą danych

```php
$polaczenie = new mysqli("localhost", "root", "", "biblioteka");
```

Zanim PHP będzie mogło cokolwiek pobrać z bazy danych, musi się z nią najpierw "przywitać" — czyli nawiązać połączenie. Robi to właśnie ta linijka.

Rozbijmy ją na czynniki pierwsze:
- **`new mysqli(...)`** — tworzymy nowy obiekt klasy `mysqli`, wbudowanej w PHP klasy służącej do komunikacji z bazami MySQL/MariaDB. Podejście "obiektowe" oznacza, że od teraz wszystkie operacje na bazie (zapytania, zamknięcie połączenia) będziemy wykonywać jako **metody** tego obiektu, np. `$polaczenie->query(...)`, a nie jako osobne funkcje.
- **`"localhost"`** — adres serwera bazy danych. `localhost` oznacza, że baza danych znajduje się na tym samym komputerze/serwerze, na którym uruchamiany jest skrypt PHP (typowa sytuacja podczas nauki i testowania lokalnie, np. w XAMPP).
- **`"root"`** — nazwa użytkownika bazy danych. `root` to domyślny, "superużytkownik" MySQL z pełnymi uprawnieniami — używany zwykle tylko lokalnie, nigdy na serwerze produkcyjnym.
- **`""`** — hasło użytkownika. Puste hasło oznacza, że konto `root` nie jest zabezpieczone hasłem (znowu — typowe dla środowiska lokalnego/szkolnego, nie do zaakceptowania na prawdziwym serwerze).
- **`"biblioteka"`** — nazwa konkretnej bazy danych, z którą się łączymy. Na jednym serwerze MySQL może istnieć wiele różnych baz (np. `biblioteka`, `sklep`, `szkola`), więc musimy wskazać, o którą nam chodzi.

Zmienna `$polaczenie` przechowuje od tej pory "uchwyt" do otwartego połączenia — będziemy jej używać w każdym kolejnym miejscu, gdzie chcemy porozmawiać z bazą.

---

## SEC-2: Zapytanie 4 — losowanie 5 książek

```php
$sql = "SELECT autor, tytul, kod FROM ksiazki ORDER BY RAND() LIMIT 5";
```

To jest serce całego skryptu — zapytanie SQL, które określa, **jakie dokładnie dane** chcemy dostać z bazy. Przeanalizujmy je fragment po fragmencie, tak jak czyta je serwer bazy danych:

- **`SELECT autor, tytul, kod`** — mówimy bazie: "interesują mnie tylko te trzy kolumny: autor, tytuł i kod". Gdybyśmy napisali `SELECT *`, dostalibyśmy wszystkie kolumny z tabeli (np. także cenę, liczbę egzemplarzy itd.), których w tym zadaniu w ogóle nie potrzebujemy — dlatego wypisujemy dokładnie te trzy nazwy.
- **`FROM ksiazki`** — dane mają pochodzić z tabeli o nazwie `ksiazki`.
- **`ORDER BY RAND()`** — to jest właśnie ten "trik" odpowiedzialny za losowość. Funkcja `RAND()` generuje dla każdego wiersza tabeli losową liczbę, a `ORDER BY` sortuje wszystkie wiersze według tych losowych liczb. Efekt jest taki, jakby ktoś przetasował całą talię kart przed każdym zapytaniem — kolejność wierszy za każdym razem będzie inna.
- **`LIMIT 5`** — z tak przetasowanej listy bierzemy tylko **pierwsze 5** wierszy. Ponieważ kolejność jest losowa, w praktyce oznacza to "wylosuj 5 dowolnych książek".

Ta linijka **nie wysyła jeszcze** zapytania do bazy — na razie jedynie zapisujemy treść zapytania (zwykły tekst) w zmiennej `$sql`, żeby użyć go w kolejnym kroku.

---

## SEC-3: Wykonanie zapytania i sprawdzenie wyniku

```php
if ($wynik = $polaczenie->query($sql)) {
    ...
}
```

Tutaj dopiero faktycznie **wysyłamy** przygotowane zapytanie do bazy, wywołując metodę `query()` na naszym obiekcie połączenia.

Warto zwrócić uwagę na budowę tego wyrażenia — jest to jednocześnie **przypisanie i warunek**:
- Najpierw wykonywane jest przypisanie `$wynik = $polaczenie->query($sql)` — czyli wynik zapytania (obiekt reprezentujący zwrócone wiersze) trafia do zmiennej `$wynik`.
- Cała ta operacja przypisania "zwraca" wartość, która następnie jest sprawdzana przez `if`. Jeśli zapytanie się powiodło, `query()` zwraca obiekt (traktowany jako `true`); jeśli coś poszło nie tak (np. literówka w nazwie tabeli), zwraca `false`, i kod wewnątrz `if` w ogóle się nie wykona.

Dzięki temu unikamy sytuacji, w której próbujemy odczytać dane z zapytania, które się nie powiodło — co skończyłoby się błędem PHP.

---

## SEC-4: Pętla po wynikach i wypisanie wierszy tabeli

Arkusz: "W każdym wierszu tabeli, w odpowiednich komórkach, wyświetlane są zwrócone zapytaniem kolejne wiersze z bazy."

```php
while ($rekord = $wynik->fetch_assoc()) {
    echo "<tr>";
    echo "<td>" . htmlspecialchars($rekord["autor"]) . "</td>";
    echo "<td>" . htmlspecialchars($rekord["tytul"]) . "</td>";
    echo "<td>" . htmlspecialchars($rekord["kod"]) . "</td>";
    echo "</tr>";
}
$wynik->free();
```

To jest fragment, który realnie "buduje" widoczną tabelę na stronie. Prześledźmy działanie krok po kroku:

- **`while ($rekord = $wynik->fetch_assoc())`** — metoda `fetch_assoc()` pobiera **jeden** wiersz wyniku zapytania na raz i zwraca go jako tablicę asocjacyjną, czyli tablicę, w której do wartości odwołujemy się po nazwie kolumny (np. `$rekord["autor"]`), a nie po numerze indeksu. Za każdym wywołaniem `fetch_assoc()` "przesuwamy się" o jeden wiersz dalej w zwróconym wyniku. Kiedy wiersze się skończą, funkcja zwraca `false`, co kończy pętlę `while`.
- Wewnątrz pętli dla **każdego** wylosowanego rekordu wypisujemy jeden kompletny wiersz tabeli HTML: otwierający tag `<tr>`, trzy komórki `<td>` (autor, tytuł, kod) i zamykający `</tr>`.
- **`htmlspecialchars(...)`** — funkcja zamieniająca znaki specjalne HTML (takie jak `<`, `>`, `&`, cudzysłowy) na ich bezpieczne odpowiedniki tekstowe. Dzięki temu, gdyby w bazie danych znalazł się np. tytuł zawierający znak `<`, przeglądarka nie potraktuje go jako początku tagu HTML, tylko wyświetli go jako zwykły tekst. To dobra praktyka bezpieczeństwa, stosowana zawsze, gdy wypisujemy dane pochodzące z bazy lub od użytkownika.
- **`$wynik->free()`** — po przetworzeniu wszystkich wierszy zwalniamy pamięć zajmowaną przez wynik zapytania. Nie jest to bezwzględnie konieczne przy tak małych zapytaniach jak to (5 wierszy), ale to dobry nawyk przy pracy z większymi zbiorami danych.

Efektem działania tej pętli jest dokładnie tyle wierszy `<tr>` w tabeli HTML, ile rekordów zwróciło zapytanie — czyli maksymalnie 5, zgodnie z `LIMIT 5` z zapytania.

---

## SEC-5: Zamknięcie połączenia z bazą

```php
$polaczenie->close();
```

Na sam koniec działania skryptu zamykamy połączenie z bazą danych metodą `close()`. To trochę jak odłożenie słuchawki po zakończonej rozmowie telefonicznej — informujemy serwer bazy danych, że nie będziemy już wysyłać kolejnych zapytań w ramach tego połączenia, dzięki czemu serwer może zwolnić zasoby zarezerwowane dla naszej sesji.

W tym konkretnym skrypcie zamknięcie połączenia następuje **zaraz po** wypisaniu tabeli, a nie na samym końcu całego pliku HTML — bo cała logika bazy danych (połączenie, zapytanie, wyświetlenie wyników) jest tutaj zamknięta w jednym, zwartym bloku PHP osadzonym wewnątrz tabeli.

---

🏠 **[Spis treści](../README.md)**

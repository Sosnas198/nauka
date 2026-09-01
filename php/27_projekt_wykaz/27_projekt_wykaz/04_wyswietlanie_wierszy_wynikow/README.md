# Kompletny przewodnik: Wypisanie znalezionych miast jako wierszy tabeli i zamknięcie tabeli

Ta ściąga wytłumaczy Ci **od A do Z**, jak PHP przechodzi przez wyniki zapytania (znalezione miasta) i wypisuje każde z nich jako osobny wiersz tabeli, a na końcu zamyka tabelę HTML.

---

## SEC-1: Przechodzenie przez znalezione miasta w pętli (`while` + `fetch_assoc()`)

```php
while ($row = $result->fetch_assoc()) {
    echo "<tr>";
        echo "<td>".$row['miasta_nazwa']."</td>";
        echo "<td>".$row['wojewodztwa_nazwa']."</td>";
    echo "</tr>";
}
```

### Jak to działa?

- **`$result`** – to zestaw wyników zwrócony przez zapytanie SQL z modułu `03_zapytanie_i_naglowek_tabeli` — czyli wszystkie miasta pasujące do wpisanej przez użytkownika frazy.
- **`$result->fetch_assoc()`** – za każdym wywołaniem "wyciąga" jeden, kolejny wiersz z wyników i zwraca go jako tablicę asocjacyjną (zbiór par "nazwa kolumny → wartość"). Gdy wiersze się skończą, zwraca `false`.
- **`while ($row = $result->fetch_assoc())`** – pętla wykonuje się od nowa dla **każdego znalezionego miasta**, dopóki `fetch_assoc()` zwraca kolejny wiersz. Gdy wyniki się skończą, pętla automatycznie się zatrzymuje.
- **`echo "<tr>";`** – otwiera nowy wiersz tabeli dla bieżącego miasta.
- **`echo "<td>".$row['miasta_nazwa']."</td>";`** – tutaj korzystamy z aliasu `miasta_nazwa`, który ustawiliśmy w zapytaniu SQL (`AS miasta_nazwa`) w module 03. Gdybyśmy w zapytaniu nie użyli aliasu, a jedynie samego `nazwa`, PHP nie wiedziałoby, czy chodzi o nazwę miasta, czy nazwę województwa (obie tabele mają kolumnę `nazwa`) — dzięki aliasowi mamy jednoznaczne klucze `$row['miasta_nazwa']` i `$row['wojewodztwa_nazwa']`.
- Zapis `"<td>".$row['miasta_nazwa']."</td>"` używa **operatora kropki `.`** (konkatenacji, czyli sklejania tekstu) zamiast interpolacji w cudzysłowie — to tylko inny sposób zapisu, dający dokładnie ten sam efekt: sklejenie tekstu `<td>`, wartości z bazy i tekstu `</td>` w jeden ciąg znaków.
- **`echo "</tr>";`** – zamyka wiersz tabeli dla bieżącego miasta. Cała ta sekwencja (`<tr>` → dwie komórki `<td>` → `</tr>`) powtarza się dla każdego kolejnego znalezionego miasta.

---

## SEC-2: Zamknięcie tabeli HTML (`echo "</table>"`)

```php
echo "</table>";
```

### Jak to działa?

- Gdy pętla `while` z SEC-1 zakończy działanie (czyli gdy wypisano już wszystkie znalezione miasta), musimy jeszcze zamknąć znacznik `<table>`, który otworzyliśmy w module `03_zapytanie_i_naglowek_tabeli` (`echo "<table>";`).
- **`echo "</table>";`** – wypisuje znacznik zamykający tabelę. Bez tej linijki tabela HTML byłaby "otwarta" na zawsze (niedomknięty tag), co mogłoby zepsuć wygląd reszty strony w przeglądarce.
- Ta linijka wykonuje się **dokładnie raz**, już po zakończeniu pętli — a nie wewnątrz niej (nie jest w środku nawiasów klamrowych `{ }` pętli `while`).

---

# Podsumowanie przepływu danych

```text
SEC-1: while ($row = $result->fetch_assoc())
       echo "<tr><td>".$row['miasta_nazwa']."</td><td>".$row['wojewodztwa_nazwa']."</td></tr>"
       — Wypisanie każdego znalezionego miasta jako osobnego wiersza tabeli
                 ↓
SEC-2: echo "</table>";
       — Zamknięcie tabeli po wypisaniu wszystkich wyników
```

---

# Ściągawka z najważniejszych pojęć

| **Pojęcie / Element**   | **Co oznacza / Co robi?**                                                                      |
| -------------------------- | ---------------------------------------------------------------------------------------------------- |
| **`fetch_assoc()`**        | Pobiera jeden, kolejny wiersz wyników zapytania jako tablicę "nazwa kolumny → wartość".              |
| **pętla `while`**          | Powtarza kod w środku, dopóki są jeszcze jakieś wiersze wyników.                                     |
| **`$row['alias_z_AS']`**   | Odczytuje wartość kolumny wynikowej po aliasie nadanym w zapytaniu SQL (`AS ...`).                    |
| **operator `.` (kropka)**  | Skleja (konkatenuje) ze sobą kawałki tekstu w PHP.                                                    |
| **`echo "</table>";`**     | Zamyka znacznik tabeli HTML — musi nastąpić po wypisaniu wszystkich wierszy.                          |

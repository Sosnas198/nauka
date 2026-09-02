Kolejność, w jakiej piszesz zapytanie w edytorze (kolejność syntaktyczna), różni się od kolejności, w jakiej silnik bazy danych faktycznie przetwarza dane (kolejność logiczna).

Oto dokładny ciąg wykonywania klauzul przez bazę krok po kroku:

1. **`FROM`** **(+** **`JOIN`\*\***)\*\*
   Baza ustala źródło danych. Odwiedza wskazaną tabelę (lub łączy kilka tabel) i wczytuje surowe wiersze do pamięci.

2. **`WHERE`**
   Filtruje pojedyncze wiersze przed jakimkolwiek grupowaniem. Wiersze niespełniające warunku są odrzucane i nie przechodzą do dalszych etapów.

3. **`GROUP BY`**
   Pozostałe wiersze są dzielunset i porządkowane w grupy na podstawie wartości w wybranych kolumnach.

4. **`HAVING`**
   Filtruje całe grupy. Wylicza funkcje agregujące (`SUM`, `COUNT`, `AVG`) dla każdej grupy z osobna i odrzuca te grupy, które nie spełniają warunku.

5. **`SELECT`**
   Dopiero w tym miejscu silnik wyciąga konkretne kolumny podane przez użytkownika, wylicza ostateczne funkcje agregujące oraz przypisuje aliasy kolumn (np. `AS suma`).

6. **`DISTINCT`**
   Jeśli zapytanie zawiera `DISTINCT`, baza usuwa powtarzające się wiersze z wynikowego zbioru po wykonaniu `SELECT`.

7. **`ORDER BY`**
   Sortuje gotowy wynik końcowy rosnąco lub malejąco. Ponieważ `ORDER BY` wykonuje się po `SELECT`, możesz w nim używać aliasów utworzonych w `SELECT`.

8. **`LIMIT`** **/** **`OFFSET`**
   Na samym końcu baza obcina wynik do określonej liczby wierszy (np. zwraca tylko pierwsze 10 wyników).

**Dlaczego ta wiedza jest przydatna?**

- **Aliasy nie działają w** **`WHERE`\*\***:\*_ Nie możesz napisać `WHERE kwota _ 1.23 > 100`, używając aliasu wyliczonego w `SELECT`(np.`WHERE cenabrutto > 100`), ponieważ `WHERE`wykonuje się znacznie wcześniej niż`SELECT`.
- **Wydajność:** Filtr `WHERE` wykonuje się przed `GROUP BY`, dzięki czemu baza grupuje mniejszy zbiór danych, co znacznie przyspiesza działanie zapytania.

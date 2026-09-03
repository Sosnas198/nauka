### **1. Relacyjny model danych (Dlaczego w ogóle dzielimy dane?)**

Bazy danych SQL nazywamy **relacyjnymi**, ponieważ przechowują dane w osobnych tabelach połączonych **relacjami** (związkami).

Zamiast trzymać wszystko w jednym wielkim arkuszu (co powodowałoby ogromne powtórzenia danych i ryzyko błędów), rozbijamy dane na mniejsze, wyspecjalizowane tabele. Proces projektowania bazy tak, aby uniknąć duplikatów, nazywa się **normalizacją**.

Aby powiązać ze sobą tabele, stosujemy dwa rodzaje kluczy:

- **Klucz Główny (\*\***`PRIMARY KEY`\***\*):** Unikalny identyfikator danego wiersza w tabeli (np. numer `id` klienta lub numer PESEL). Żadne dwa wiersze nie mogą mieć takiego samego klucza głównego.
- **Klucz Obcy (\*\***`FOREIGN KEY`\***\*):** Kolumna w jednej tabeli, która wskazuje na `PRIMARY KEY` w innej tabeli. To jest właśnie ten "most", po którym wykonujemy `JOIN`.

### **2. Podział języka SQL na podjęzyki**

SQL to nie tylko pobieranie danych. Dzieli się na kilka głównych grup poleceń:

- **DML (Data Manipulation Language) – Operowanie danymi:**
  - `SELECT` – odczytywanie danych.
  - `INSERT` – dodawanie nowych wierszy (np. `INSERT INTO source4 SELECT ...`).
  - `UPDATE` – modyfikowanie istniejących danych.
  - `DELETE` – usuwanie wierszy.

- **DDL (Data Definition Language) – Definiowanie struktury:**
  - `CREATE TABLE` – tworzenie nowej tabeli (np. tworzenie struktur w skrypcie `select6.sql`).
  - `ALTER TABLE` – zmiana struktury istniejącej tabeli (np. dodanie kolumny).
  - `DROP TABLE` – całkowite usunięcie tabeli z bazy.

- **DCL / TCL – Kontrola dostępu i transakcji:**
  - `GRANT` / `REVOKE` – przyznawanie i odbieranie uprawnień użytkownikom.
  - `COMMIT` / `ROLLBACK` – zatwierdzanie lub wycofywanie zmian (użyte na końcu skryptu bazy danych).

### **3. Zaawansowane mechanizmy filtrowania i zapytań**

#### **A. Podzapytania (Subqueries)**

Podzapytanie to zapytanie `SELECT` zagnieżdżone wewnątrz innego zapytania. Zamiast pisać dwa osobne zapytania, łączysz je w jedno.

- **Podzapytanie w klauzuli** **`WHERE`\*\***:\*\*

  SQL

  ```sql id="4q8mzs"
  -- Szukamy plików, których rozmiar jest większy niż średnia długość wszystkich plików
  SELECT filename, length
  FROM source1
  WHERE length > (SELECT AVG(length) FROM source1);
  ```

- **Operator** **`EXISTS`\*\***:\*\*
  Sprawdza, czy podzapytanie zwraca jakiekolwiek wiersze (często stosowane w zadaniach do porównywania tabel zamiast tradycyjnych operacji mnogościowych).

#### **B. Operatory logiczne i specjalne w** **`WHERE`**

- **`LIKE`** **+ Wildcards:** Służy do szukania wzorców tekstowych:
  - `%` oznacza dowolny ciąg znaków (np. `WHERE filename LIKE 'A%'` znajdzie każdy plik zaczynający się na litery 'A').
  - `_` oznacza dokładnie jeden dowolny znak.

- **`IN`** **/** **`NOT IN`\*\***:\*\* Pozwala zastąpić wiele warunków `OR` (np. `WHERE extension IN ('txt', 'exe', 'pdf')`).
- **`BETWEEN ... AND ...`\*\***:\*\* Filtruje wartości w domkniętym przedziale (np. zakresem dat `DATA BETWEEN '2014-01-01' AND '2014-12-01'`).

#### **C. Wartość** **`NULL`** **(Brak danych)**

`NULL` w SQL oznacza brak wartości lub wartość nieznaną. Bardzo ważna zasada: **`NULL`** **to nie jest to samo co zero (\*\***`0`\***\*) ani pusty tekst (\*\***`""`\***\*)**.

- Nie można stosować przy nich zwykłych operatorów typu `= NULL` czy `!= NULL`.
- Używa się wyłącznie konstrukcji: **`IS NULL`** lub **`IS NOT NULL`**.

### **4. Przegląd typów relacji w łącznikach** **`JOIN`**

Poniższa tabela zbiera pełne zestawienie metod łączenia tabel po `JOIN`:

| **Typ JOIN**          | **Co zwraca w wyniku?**                                                                          |
| --------------------- | ------------------------------------------------------------------------------------------------ |
| **`INNER JOIN`**      | Tylko te wiersze, dla których warunek spięcia (`ON`) jest spełniony w obu tabelach jednocześnie. |
| **`LEFT JOIN`**       | Wszystkie wiersze z lewej tabeli + dopasowane dane z prawej. Brak dopasowania = `NULL`.          |
| **`RIGHT JOIN`**      | Wszystkie wiersze z prawej tabeli + dopasowane dane z lewej.                                     |
| **`FULL OUTER JOIN`** | Wszystkie wiersze z obu tabel. Jeśli brak powiązania z drugiej strony, wstawia `NULL`.           |
| **`CROSS JOIN`**      |                                                                                                  |

Iloczyn kartazjański: łączy każdy wiersz z pierwszej tabeli z każdym wierszem z drugiej tabeli.

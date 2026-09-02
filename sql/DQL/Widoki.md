**Widok (VIEW)** w SQL to po prostu **zapisane zapytanie** **`SELECT`**, które zachowuje się jak „wirtualna tabela”.

Widok nie przechowuje fizycznie własnych danych (pobiera je w locie z oryginalnych tabel), ale pozwala patrzeć na dane z bazy w przefiltrowany lub łatwiejszy sposób.

**Po co stosuje się widoki?**

- **Uproszczenie skomplikowanych zapytań:** Jeśli ciągle musisz pisać długie zapytanie z `JOIN`, `GROUP BY` czy `WHERE`, możesz zapisać je jako widok i potem odwoływać się do niego jak do zwykłej tabeli jednym krótkim słowem.
- **Bezpieczeństwo danych:** Możesz dać użytkownikowi dostęp tylko do widoku (np. z imieniem i e-mailem), ukrywając przed nim wrażliwe kolumny z tabeli głównej (np. pesel, hasło, zarobki).
- **Wygoda:** Pozwala stworzyć gotowy „raport”, do którego wracasz w dowolnym momencie.

**Jak utworzyć i użyć widoku?**

**1. Tworzenie widoku (\*\***`CREATE VIEW`\***\*)**

Wyobraź sobie, że chcesz zapisać zapytanie, które wyciąga tylko pliki z rozszerzeniem `pdf` z tabeli `source1`:

SQL

```sql id="7k3m2p"
CREATE VIEW pliki_pdf AS
SELECT filename, length, data
FROM source1
WHERE extension = 'pdf';
```

**2. Używanie widoku (jak zwykłej tabeli)**

Teraz nie musisz już pisać warunku `WHERE extension = 'pdf'`. Wystarczy pytać widok:

SQL

```sql id="q8v4nx"
SELECT * FROM pliki_pdf;
```

**3. Filtrowanie i sortowanie widoku**

Możesz zadawać pytania do widoku tak samo, jak do normalnej tabeli:

SQL

```sql id="m5t9rc"
SELECT * FROM pliki_pdf
WHERE length > 10000
ORDER BY filename ASC;
```

**4. Usuwanie widoku (\*\***`DROP VIEW`\***\*)**

Jeśli widok nie jest Ci już potrzebny, usuwasz go bez utraty danych z oryginalnej tabeli:

SQL

```sql id="z2w6bd"
DROP VIEW pliki_pdf;
```

**Czym widok różni się od zwykłej tabeli?**

| **Cecha**                 | **Zwykła Tabela**                           | **Widok (VIEW)**                                                                         |
| ------------------------- | ------------------------------------------- | ---------------------------------------------------------------------------------------- |
| **Przechowywanie danych** | Fizycznie zajmuje miejsce na dysku.         | Zapisana jest tylko definicja zapytania (wirtualna tabela).                              |
| **Aktualność danych**     | Dane są statyczne, dopóki ich nie zmienisz. | **Zawsze aktualne** – w momencie zapytania widok pobiera najświeższe dane z tabel-matek. |
| **Modyfikacja**           | Przechowuje oryginalne rekordy.             | Służy głównie do odczytu (podglądu) złożonych zestawień.                                 |

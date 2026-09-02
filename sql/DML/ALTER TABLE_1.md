# 🛠️ Kurs SQL: Modyfikacja Struktury Tabel (`ALTER TABLE`)

Witaj w poradniku dotyczącym modyfikowania istniejących tabel w bazach danych!

Ten plik został przygotowany tak, aby przeprowadzić Cię krok po kroku – od pojęć podstawowych aż po zaawansowane zależności między tabelami.

---

## 💡 1. Co to jest `ALTER TABLE` i po co tego używamy?

Wyobraź sobie, że tabela w bazie danych to **arkusz w Excelu**:

- `CREATE TABLE` – tworzy nowy, pusty arkusz z nagłówkami.
- `INSERT INTO` – dopisuje nowe wiersze (dane) do arkusza.
- `UPDATE` – zmienia dane w istniejących wierszach (np. zmienia imię Jan na Janusz).
- **`ALTER TABLE`** – zmienia **same nagłówki/strukturę** arkusza (np. dodaje nową kolumnę "Adres Email", usuwa kolumnę "Telefon", zmienia typ danych).

> ⚠️ **Złota zasada:** `ALTER TABLE` zmienia **konstrukcję/szablon** tabeli, a nie same dane w wierszach!

---

## ➕ 2. Dodawanie nowej kolumny (`ADD`)

Jeśli po pewnym czasie okazuje się, że musisz przechowywać dodatkowe informacje (np. adres e-mail pracownika):

```sql
ALTER TABLE nazwa_tabeli
ADD nazwa_nowej_kolumny typ_danych [dodatkowe_warunki];
```

### ✏️ Przykład

Dodajmy kolumnę `email`, która może przechowywać tekst do 100 znaków:

```sql
ALTER TABLE Pracownicy
ADD email VARCHAR(100);
```

---

## ❌ 3. Usuwanie kolumny (`DROP COLUMN`)

Gdy dana kolumna nie jest już potrzebna i chcesz pozbyć się jej ze struktury:

```sql
ALTER TABLE nazwa_tabeli
DROP COLUMN nazwa_kolumny;
```

### ✏️ Przykład

Usuwamy nieużywaną kolumnę `numer_stacjonarny`:

```sql
ALTER TABLE Pracownicy
DROP COLUMN numer_stacjonarny;
```

---

## 🔄 4. Zmiana typu danych kolumny (`ALTER COLUMN` / `MODIFY`)

Co zrobić, gdy pole miało za mały rozmiar lub niewłaściwy typ? (np. `VARCHAR(20)` okazał się za krótki dla nazwisk).

- **SQL Server / PostgreSQL:**

  ```sql
  ALTER TABLE Pracownicy
  ALTER COLUMN nazwisko VARCHAR(100);
  ```

- **MySQL / Oracle:**

  ```sql
  ALTER TABLE Pracownicy
  MODIFY COLUMN nazwisko VARCHAR(100);
  ```

---

## ✏️ 5. Zmiana nazwy kolumny (`RENAME COLUMN`)

```sql
ALTER TABLE Pracownicy
RENAME COLUMN pensja TO wynagrodzenie_brutto;
```

---

## 🔗 6. Zarządzanie Relacjami i Więzami (`CONSTRAINT`)

To kluczowy element projektowania baz danych. Więzy (`constraints`) gwarantują, że dane są poprawne i spójne.

### A. Dodawanie Klucza Obcego (`FOREIGN KEY`)

Klucz obcy łączy ze sobą dwie tabele (np. przypisuje Pracownika do Działu).

```sql
ALTER TABLE Pracownicy
ADD CONSTRAINT fk_pracownik_dzial
FOREIGN KEY (id_dzialu) REFERENCES Dzialy(id);
```

### B. Wymuszanie unikalności (`UNIQUE`)

Zapewnia, że w kolumnie nie powtórzą się dwie takie same wartości (np. dwa takie same numery PESEL lub maile):

```sql
ALTER TABLE Pracownicy
ADD CONSTRAINT uq_pracownik_pesel UNIQUE (pesel);
```

### C. Warunki sprawdzające (`CHECK`)

Służą do pilnowania logicznych reguł (np. wiek nie może być ujemny, a pensja musi być większa niż minimalna):

```sql
ALTER TABLE Pracownicy
ADD CONSTRAINT chk_wiek CHECK (wiek >= 18);
```

---

## 📋 Podsumowanie – Ściągawka (Cheatsheet)

| **Operacja**         | **Kod SQL**                                         | **Co robi?**         |
| -------------------- | --------------------------------------------------- | -------------------- |
| **Dodaj kolumnę**    | `ALTER TABLE t ADD k VARCHAR(50);`                  | Tworzy nowe pole     |
| **Usuń kolumnę**     | `ALTER TABLE t DROP COLUMN k;`                      | Trwale usuwa pole    |
| **Zmień typ**        | `ALTER TABLE t ALTER COLUMN k INT;`                 | Zmienia typ danych   |
| **Zmień nazwę**      | `ALTER TABLE t RENAME COLUMN k1 TO k2;`             | Zmienia nazwę pola   |
| **Dodaj Klucz Obcy** | `ALTER TABLE t ADD CONSTRAINT ... FOREIGN KEY ...;` | Łączy tabele relacją |

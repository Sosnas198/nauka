Tak, klucze i relacje możesz zdefiniować na **dwa sposoby**:

1. **Od razu przy tworzeniu tabeli (\*\***`CREATE TABLE`\***\*)** – najczęstszy sposób, gdy projektujesz bazę od zera.
2. **Do istniejącej już tabeli (\*\***`ALTER TABLE`\***\*)** – sposób używany, gdy tabela już istnieje w bazie, a Ty chcesz do niej dodać powiązanie lub unikalny identyfikator bez jej kasowania.

### Sposób 1: Tworzenie od razu w `CREATE TABLE`

Definiujesz klucz główny i klucz obcy od razu podczas pisania struktury tabeli.

SQL

```sql id="7h2mqp"
-- 1. Najpierw tworzymy tabelę główną (RODZIC)
CREATE TABLE klienci (
    id_klienta INT AUTO_INCREMENT,
    imie VARCHAR(50),
    PRIMARY KEY (id_klienta) -- Tworzymy Klucz Główny
);

-- 2. Tworzymy tabelę powiązaną (DZIECKO)
CREATE TABLE zamowienia (
    id_zamowienia INT AUTO_INCREMENT,
    kwota DECIMAL(10,2),
    id_klienta INT, -- Kolumna na klucz obcy
    PRIMARY KEY (id_zamowienia), -- Klucz Główny tabeli zamówień
    FOREIGN KEY (id_klienta) REFERENCES klienci(id_klienta) -- Klucz Obcy wskazujący na klientów
);
```

### Sposób 2: Modyfikacja istniejącej tabeli przez `ALTER TABLE`

Stosujesz ten sposób, gdy tabele zostały już wcześniej utworzone (np. bez podawania kluczy), a Ty chcesz je teraz ze sobą połączyć.

SQL

```sql id="k4n8vw"
-- Zakładamy, że tabele 'klienci' i 'zamowienia' już istnieją w bazie

-- 1. Dodajemy Klucz Główny do tabeli klienci
ALTER TABLE klienci
ADD PRIMARY KEY (id_klienta);

-- 2. Dodajemy Klucz Obcy do tabeli zamowienia
ALTER TABLE zamowienia
ADD CONSTRAINT fk_zamowienia_klienci
FOREIGN KEY (id_klienta) REFERENCES klienci(id_klienta);
```

### Dlaczego istnieją te dwa sposoby?

- **`CREATE TABLE`** jest szybszy i wygodniejszy, kiedy tworzysz nową aplikację lub robisz zadanie na lekcji od zera.
- **`ALTER TABLE`** przydaje się w pracy, gdy baza danych działa od miesięcy, masz w niej dane i musisz rozbudować jej strukturę bez usuwania tabel.

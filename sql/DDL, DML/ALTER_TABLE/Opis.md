# 🛠️ Kurs SQL: Modyfikacja Struktury Tabel (`ALTER TABLE`)

## 💡 Co to jest `ALTER TABLE` i po co tego używamy?

Wyobraź sobie, że tabela to **arkusz w Excelu**:

- `CREATE TABLE` – tworzy nowy, pusty arkusz z nagłówkami.
- `INSERT INTO` – dodaje nowe wiersze (dane).
- `UPDATE` – zmienia dane w istniejących wierszach.
- **`ALTER TABLE`** – zmienia **strukturę/nagłówki** (dodaje kolumny, usuwa je, zmienia typy).

> ⚠️ **Kluczowe:** `ALTER TABLE` zmienia szablon tabeli, a nie same dane!

---

## ➕ Dodawanie nowej kolumny (`ADD`)

```sql
ALTER TABLE nazwa_tabeli
ADD nazwa_kolumny typ_danych;
```

**Przykład:**

```sql
ALTER TABLE Pracownicy
ADD email VARCHAR(100);
```

**Wyjaśnienie dla ciebie:**

- `VARCHAR(100)` = tekst do 100 znaków (nazwa typu danych)
- **Ważne:** Jeśli tabela ma już 50 pracowników, dodanie kolumny `email` **nie wymaże danych**. Wszystkie istniejące wiersze dostaną pustą komórkę w kolumnie `email`, a nowe dane będą tam wpisywane normalnie.

---

## ❌ Usuwanie kolumny (`DROP COLUMN`)

```sql
ALTER TABLE Pracownicy
DROP COLUMN numer_stacjonarny;
```

⚠️ **Uwaga:** To **usuwanie trwałe** - wszystkie dane w tej kolumnie znikają. Nie ma "Ctrl+Z"!

---

## 🔄 Zmiana typu danych kolumny (`MODIFY`)

```sql
ALTER TABLE Pracownicy
MODIFY COLUMN nazwisko VARCHAR(100);
```

---

## ✏️ Zmiana nazwy kolumny

```sql
ALTER TABLE Pracownicy
RENAME COLUMN pensja TO wynagrodzenie_brutto;
```

---

## 🔗 Zarządzanie Więzami (`CONSTRAINT`)

**Constraint** to reguła, którą baza musi pilnować. Zapewnia, że dane są poprawne i spójne.

### ✅ Klucz Obcy (`FOREIGN KEY`)

Łączy dwie tabele razem. Praktyczny przykład:

Mamy dwie tabele:

- `Pracownicy` - zawiera pracowników
- `Dzialy` - zawiera nazwy działów (ID=1 "IT", ID=2 "HR", ID=3 "Marketing")

Chcemy, aby każdy pracownik **musiał** być przypisany do istniejącego działu. Bez tej reguły, ktoś mógłby wpisać `id_dzialu = 999` a taki dział by nie istniał.

```sql
ALTER TABLE Pracownicy
ADD CONSTRAINT fk_pracownik_dzial
FOREIGN KEY (id_dzialu) REFERENCES Dzialy(id);
```

**Co to robi:**

- Kolumna `id_dzialu` w tabeli `Pracownicy` musi zawierać wartość, która istnieje w kolumnie `id` tabeli `Dzialy`.
- Jeśli spróbujesz wstawić pracownika z `id_dzialu = 999`, baza **odrzuci** to i wyrzuci błąd.
- To gwarantuje spójność danych.

---

### 🔒 Unikatowość (`UNIQUE`)

Zapewnia, że w kolumnie nie powtórzą się dwie takie same wartości.

```sql
ALTER TABLE Pracownicy
ADD CONSTRAINT uq_pracownik_email UNIQUE (email);
```

**Po co:**

- Każdy pracownik ma inne e-maile.
- Baza nie pozwoli wstawić dwóch osób z takim samym e-mailem.

---

### ✋ Warunki logiczne (`CHECK`)

Pilnuje, żeby dane spełniały warunki logiczne.

```sql
ALTER TABLE Pracownicy
ADD CONSTRAINT chk_pensja_dodatnia CHECK (pensja > 0);
```

**Po co:**

- Pensja musi być większa od zera.
- Jeśli ktoś poda `pensja = -5000`, baza odrzuci to i wyrzuci błąd.

Inny przykład:

```sql
ALTER TABLE Pracownicy
ADD CONSTRAINT chk_wiek CHECK (wiek >= 18);
```

---

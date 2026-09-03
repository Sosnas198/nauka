# Klucz główny i klucz obcy w bazach danych

**Klucz główny (`PRIMARY KEY`)** to unikalny identyfikator każdego wiersza w tabeli — można go porównać do numeru PESEL dla człowieka.

**Klucz obcy (`FOREIGN KEY`)** to kolumna, która wskazuje na klucz główny w innej tabeli, tworząc między nimi powiązanie, czyli **relację**.

---

## 1. Klucz główny (`PRIMARY KEY`) — unikalny identyfikator

Klucz główny dba o to, aby każdy rekord w tabeli można było jednoznacznie rozpoznać.

### Najważniejsze cechy i zasady

- **Brak powtórzeń (`UNIQUE`)**
  Wartość klucza głównego musi być unikalna w całej tabeli.

- **Brak pustych wartości (`NOT NULL`)**
  Klucz główny nie może przyjmować wartości `NULL`. Każdy wiersz musi posiadać wartość klucza głównego.

- **Tylko jeden klucz główny w tabeli**
  Tabela może mieć tylko jeden `PRIMARY KEY`. Może on jednak składać się z kilku kolumn — wtedy mówimy o **kluczu złożonym**.

- **Automatyczna numeracja**
  Bardzo często klucz główny jest automatycznie numerowany, np. za pomocą `AUTO_INCREMENT`.

- **AUTO_INCREMENT**
  Dodawany jest tylko do typu danych liczbowych, a nie do typu danych tekstowych

```sql
CREATE TABLE klienci (
    id_klienta INT PRIMARY KEY,
    imie VARCHAR(50),
    nazwisko VARCHAR(50)
);
```

---

## 2. Klucz obcy (`FOREIGN KEY`) — łącznik między tabelami

Klucz obcy służy do **tworzenia relacji pomiędzy tabelami**.

Przechowuje wartości odpowiadające kluczowi głównemu z innej tabeli. Dzięki temu baza danych wie, które rekordy są ze sobą powiązane.

### Najważniejsze cechy i zasady

- **Spójność danych (integrity)**
  Klucz obcy pomaga zapobiegać wpisywaniu wartości, która nie istnieje w powiązanej tabeli.

  Przykładowo: jeśli w tabeli `klienci` nie istnieje klient o `id_klienta = 99`, baza danych może uniemożliwić dodanie zamówienia przypisanego do klienta `99`.

- **Może się powtarzać**
  W przeciwieństwie do klucza głównego, wartość klucza obcego może występować w wielu wierszach.

  Przykład: klient o `id_klienta = 1` może mieć wiele zamówień.

- **Może być pusty (`NULL`)**
  Klucz obcy może przyjmować wartość `NULL`, jeżeli nie zostanie ustawione ograniczenie `NOT NULL`.

- **Wiele kluczy obcych w jednej tabeli**
  Tabela może posiadać wiele kluczy obcych wskazujących na różne tabele.

- **Typ danych**
  Klucz obcy musi mieć ten sam typ dnaych co klucz podstawowy, na którego wskazuje.

```sql
CREATE TABLE zamowienia (
    id_zamowienia INT PRIMARY KEY,
    data_zamowienia DATE,
    id_klienta INT,
    FOREIGN KEY (id_klienta) REFERENCES klienci(id_klienta)
);
```

---

## 3. Utworzenie kluczy podczas tworzenia tabel

```sql
CREATE TABLE klienci (
    id_klienta INT PRIMARY KEY,
    imie VARCHAR(50),
    nazwisko VARCHAR(50)
);

CREATE TABLE zamowienia (
    id_zamowienia INT PRIMARY KEY,
    id_klienta INT,
    FOREIGN KEY (id_klienta)
        REFERENCES klienci(id_klienta)
);
```

---

## 4. Utworzenie kluczy po utworzeniu tabel

```sql
ALTER TABLE klienci
ADD PRIMARY KEY (id_klienta);

ALTER TABLE zamowienia
ADD CONSTRAINT fk_zamowienia_klienci
FOREIGN KEY (id_klienta) REFERENCES klienci(id_klienta);
```

---

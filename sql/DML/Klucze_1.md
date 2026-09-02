**Klucz Główny (\*\***`PRIMARY KEY`\***\*)** to unikalny identyfikator każdego wiersza w tabeli (odpowiednik numeru PESEL dla człowieka). **Klucz Obcy (\*\***`FOREIGN KEY`\***\*)** to kolumna, która wskazuje na klucz główny w innej tabeli, tworząc między nimi powiązanie (relację).

### 1. Klucz Główny (`PRIMARY KEY`) – Unikalny identyfikator

Dba o to, aby żaden wiersz w tabeli nie był identyczny z innym i żeby można było jednoznacznie wskazać konkretny rekord.

**Najważniejsze cechy i zasady:**

- **Brak powtórzeń (\*\***`UNIQUE`\***\*):** Wartość w tej kolumnie musi być niepowtarzalna w skali całej tabeli.
- **Brak pustych wartości (\*\***`NOT NULL`\***\*):** Nie może przyjmować wartości `NULL` (musi istnieć dla każdego wiersza).
- **Tylko jeden w tabeli:** Tabela może mieć tylko jeden klucz główny (choć może się on składać z kilku połączonych kolumn – tzw. klucz złożony).
- **Automatyczna numeracja:** Bardzo często stosuje się dla niego automatyczne generowanie kolejnych liczb (np. `AUTO_INCREMENT`).

_Przykład:_ Kolumna `id_klienta` w tabeli z klientami.

### 2. Klucz Obcy (`FOREIGN KEY`) – Łącznik między tabelami

Służy do tworzenia relacji. Przechowuje wartości, które odpowiadają kluczowi głównemu z innej (lub tej samej) tabeli.

**Najważniejsze cechy i zasady:**

- **Spójność danych (Integrity):** Nie pozwala wpisać wartości, która nie istnieje jako klucz główny w powiązanej tabeli (np. nie pozwala dodać zamówienia dla klienta o `id = 99`, jeśli w tabeli klientów nie ma takiego `id`).
- **Może się powtarzać:** W przeciwieństwie do klucza głównego, jedna wartość klucza obcego może pojawić się w wielu wierszach (np. ten sam klient z `id = 1` może dokonać wielu zakupów).
- **Może być pusty (\*\***`NULL`\***\*):** Chyba że jawnie wymusisz inaczej, klucz obcy może przyjmować wartość `NULL` (np. zamówienie bez przypisanego stałego klienta).
- **Wiele kluczy w tabeli:** Tabela może posiadać kilka kluczy obcych wskazujących na zupełnie różne tabele.

_Przykład:_ Kolumna `id_klienta` znajdująca się w tabeli `zamowienia`.

### Szybkie porównanie

| **Cecha**                               | **Klucz Główny (PRIMARY KEY)** | **Klucz Obcy (FOREIGN KEY)** |
| --------------------------------------- | ------------------------------ | ---------------------------- |
| **Główna rola**                         | Identyfikuje konkretny wiersz  | Łączy wiersz z inną tabelą   |
| **Unikalność**                          | Musi być unikalny              | Może się powtarzać           |
| **Puste wartości (\*\***`NULL`\***\*)** | **Nigdy** nie może być `NULL`  | Może być `NULL`              |
| **Ilość w tabeli**                      | Maksymalnie 1                  | Może być ich wiele           |

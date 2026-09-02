**`INNER JOIN`** to najbardziej podstawowy i najczęściej używany sposób łączenia tabel w SQL. Najprościej wyobrazić go sobie jako **znajdowanie elementów wspólnych** (części wspólnej) z dwóch różnych tabel.

Wyobraź sobie dwie tabele z bazy danych:

**Tabela** **`klient`**

| **id_klienta** | **imie** |
| -------------- | -------- |
| 1              | Ania     |
| 2              | Tomek    |
| 3              | Bartek   |

**Tabela** **`zamowienie`**

| **id_zamowienia** | **id_klienta** | **kwota** |
| ----------------- | -------------- | --------- |
| 101               | 1              | 150 zł    |
| 102               | 1              | 200 zł    |
| 103               | 2              | 50 zł     |
| 104               | 99             | 300 zł    |

### Jak działa `INNER JOIN`?

`INNER JOIN` sprawdza każdy wiersz z pierwszej tabeli i szuka dopasowania w drugiej tabeli na podstawie **klucza**, który wskazujesz po słowie `ON`.

Jeśli wywołasz zapytanie:

SQL

```sql id="r7k2mq"
SELECT klient.imie, zamowienie.id_zamowienia, zamowienie.kwota
FROM klient
INNER JOIN zamowienie ON klient.id_klienta = zamowienie.id_klienta;
```

Baza wykonuje następującą analizę wiersz po wierszu:

1. **Ania (\*\***`id_klienta = 1`\***\*)**: Baza szuka w tabeli `zamowienie` wierszy z `id_klienta = 1`. Znajduje zamówienia `101` oraz `102`. Łączy Anię z tymi dwoma zamówieniami.
2. **Tomek (\*\***`id_klienta = 2`\***\*)**: Baza szuka wierszy z `id_klienta = 2`. Znajduje zamówienie `103`. Łączy Tomka z tym zamówieniem.
3. **Bartek (\*\***`id_klienta = 3`\***\*)**: Baza szuka wierszy z `id_klienta = 3`. **Nie znajduje nic**. Bartek zostaje całkowicie odrzucony i nie pojawi się w wyniku.
4. **Zamówienie 104 (\*\***`id_klienta = 99`\***\*)**: Baza szuka klienta o id 99. **Nie znajduje nic**. To zamówienie również zostaje odrzucone.

### Wynik zapytania `INNER JOIN`

| **imie** | **id_zamowienia** | **kwota** |
| -------- | ----------------- | --------- |
| Ania     | 101               | 150 zł    |
| Ania     | 102               | 200 zł    |
| Tomek    | 103               | 50 zł     |

### Budowa składni krok po kroku

SQL

```sql id="n4x8pc"
SELECT kolumna1, kolumna2
FROM TabelaA
INNER JOIN TabelaB ON TabelaA.wspolna_kolumna = TabelaB.wspolna_kolumna;
```

- **`FROM TabelaA`**: Pierwsza (lewa) tabela, z której startujesz.
- **`INNER JOIN TabelaB`**: Druga (prawa) tabela, którą chcesz dokleić z boku.
- **`ON TabelaA.id = TabelaB.id`**: Warunek połączenia – informacja dla bazy, które kolumny wskazują na to samo (najczęściej `PRIMARY KEY` z jednej tabeli odpowiada `FOREIGN KEY` z drugiej).

### Używanie aliasów (skrótów) dla czytelności

Zamiast pisać pełne nazwy tabel przy każdej kolumnie, stosuje się aliasy (skrótowe litery):

SQL

```sql id="v6t1bz"
SELECT k.imie, z.kwota
FROM klient k
INNER JOIN zamowienie z ON k.id_klienta = z.id_klienta;
```

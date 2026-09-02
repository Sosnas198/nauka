Wyobraź sobie, że masz przed sobą **dwa osobne arkusze w Excelu** z listami obecności albo listami zakupów. Operacje mnogościowe (w tym `UNION`) służą po prostu do tego, żeby wziąć dane z tych dwóch tabel i połączyć je, porównać albo znaleźć części wspólne — tak, jakbyś robił działania na zbiorach na matematyce.

Są niezastąpione, gdy dane tego samego typu masz rozbite w bazy na osobne tabele (np. pliki na pendrive i pliki na dysku).

**1.** **`UNION`** **(Suma bez duplikatów)**

Bierze wiersze z pierwszej tabeli, dokłada wiersze z drugiej tabeli, a jeśli jakiś wiersz powtarza się w obu miejscach — **zostawia tylko jeden egzemplarz**.

- **Po co:** Chcesz stworzyć jedną pełną listę unikalnych elementów z dwóch źródeł (np. listę wszystkichunikalnych klientów ze sklepów stacjonarnych i sklepu online).
- **Przykład z Twojego zadania:** Wyświetl wszystkie różne pliki w SOURCE1 i SOURCE2.

SQL

```sql id="7f3kq1"
SELECT FILENAME, EXTENSION FROM source1
UNION
SELECT FILENAME, EXTENSION FROM source2;
```

**2.** **`UNION ALL`** **(Suma z powtórzeniami)**

Łączy wszystko jak leci z obu tabel, **nie usuwając duplikatów**. Działa znacznie szybciej niż zwykłe `UNION`, bo baza nie musi tracić czasu na szukanie i usuwanie powtórek.

- **Po co:** Gdy chcesz sprawdzić pełną masę danych i zależy Ci na wydajności, a powtórzenia Ci nie przeszkadzają (albo wręcz ich potrzebujesz).
- **Przykład z Twojego zadania:** Wyświetl wszystkie nazwy plików ze SOURCE1 i SOURCE2 uwzględniając te, które się powtarzają.

SQL

```sql id="m8v2pd"
SELECT FILENAME FROM source1
UNION ALL
SELECT FILENAME FROM source2;
```

**3.** **`INTERSECT`** **(Część wspólna / Przecięcie)**

Zwraca **tylko te wiersze, które występują jednocześnie w OBU tabelach**.

- **Po co:** Chcesz znaleźć wspólne elementy dwóch zbiorów (np. szukasz towarów, które są dostępne w magazynie A i jednocześnie w magazynie B).
- **Przykład z Twojego zadania:** Sprawdź, które programy (exe) mają identyczną nazwę w SOURCE1 i SOURCE2.

SQL

```sql id="q4n9sx"
SELECT FILENAME FROM source1 WHERE EXTENSION = 'exe'
INTERSECT
SELECT FILENAME FROM source2 WHERE EXTENSION = 'exe';
```

**4.** **`EXCEPT`** **(Różnica zbiorów)**

Wyciąga wiersze z **pierwszej** tabeli, odliczając od nich wszystko to, co znajduje się w **drugiej** tabeli.

- **Po co:** Chcesz zobaczyć, czego brakuje w jednym miejscu względem drugiego (np. które produkty kupił Klient A, a których jeszcze nigdy nie kupił Klient B).
- **Przykład z Twojego zadania:** Pliki na PENDRIVE, które NIE występują na SOURCE1.

SQL

```sql id="z6t1wc"
SELECT FILENAME FROM pendrive
EXCEPT
SELECT FILENAME FROM source1;
```

**Złota zasada operacji mnogościowych:**

Oba zapytania łączone przez `UNION`, `INTERSECT` czy `EXCEPT` **muszą zwracać dokładnie tę samą liczbę kolumn** i kolumny te muszą być tego samego typu (np. tekst do tekstu, liczba do liczby). Nie możesz w pierwszym `SELECT` wyciągnąć 3 kolumn, a w drugim tylko 1.

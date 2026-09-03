Tak, **`JOIN`** **to po prostu rozbudowany** **`SELECT`**.

Do tej pory `SELECT` służył Ci do czytania z **jednej** tabeli. Problem pojawia się wtedy, gdy potrzebne dane są rozbite na **dwie różne tabele** i chcesz złożyć z nich jeden wspólny widok.

### Metaforyczna zasada działania `JOIN`

Wyobraź sobie dwie kartki papieru:

- **Tabela 1 (\*\***`uczniowie`\***\*):** Zawiera kolumny `id_ucznia`, `imie`, `klasa_id`.
- **Tabela 2 (\*\***`klasy`\***\*):** Zawiera kolumny `id_klasy`, `nazwa_profilu`.

Na kartce uczniów przy Ani stoi `klasa_id = 3`. Żeby dowiedzieć się, co to za klasa, musisz spojrzeć na drugą kartkę (`klasy`), odnaleźć wiersz z `id_klasy = 3` i przeczytać nazwę profilu (np. "Matematyczny").

**`JOIN`** **robi dokładnie to samo automatycznie za pomocą wspólnego łącznika (klucza)**.

### Rodzaje `JOIN` (Czyli jak łączyć tabele)

Najczęściej używa się dwóch podstawowych wariantów:

**1.** **`INNER JOIN`** **(Tylko pasujące puzle)**

Łączy tylko te wiersze z obu tabel, które mają swój odpowiednik na drugiej kartce. Jeśli uczeń nie ma przypisanej klasy albo klasa nie ma uczniów — zostaną pominięci.

SQL

```sql id="q7m2vk"
SELECT uczniowie.imie, klasy.nazwa_profilu
FROM uczniowie
INNER JOIN klasy ON uczniowie.klasa_id = klasy.id_klasy;
```

**2.** **`LEFT JOIN`** **(Bierzemy wszystko z pierwszej tabeli)**

Wyświetla **wszystkich** uczniów z pierwszej tabeli (tej po `FROM`), nawet jeśli nie mają przypisanej żadnej klasy. W miejscu profilu bazy wstawi brak danych (`NULL`).

SQL

```sql id="n5c8rx"
SELECT uczniowie.imie, klasy.nazwa_profilu
FROM uczniowie
LEFT JOIN klasy ON uczniowie.klasa_id = klasy.id_klasy;
```

### Różnica między `UNION` a `JOIN`

Łatwo je pomylić na początku, ale robią zupełnie inne rzeczy:

- **`UNION`** **(Sklejanie w pionie):** Dokłada wiersze pod spód. (Masz 5 wierszy w T1 i 5 wierszy w T2 $\rightarrow$ dostajesz 10 wierszy w jednej długiej tabeli).
- **`JOIN`** **(Sklejanie w poziomie):** Dokłada kolumny z boku. (Masz 2 kolumny w T1 i 2 kolumny w T2 $\rightarrow$ dostajesz 4 kolumny w jednej szerokiej tabeli).

### Jak `JOIN` wpisuje się w kolejność wykonywania zapytań?

`JOIN` wykonuje się na samym początku w fazie **`FROM`**:

1. **`FROM`** **+** **`JOIN`** – Baza bierze obie tabele, znajduje powiązania (`ON`) i tworzy w pamięci jedną szeroką tabelę roboczą.
2. **`WHERE`** – Filtruje wiersze z tej połaczonej tabeli.
3. **`GROUP BY`** – Grupuje połączone dane.
4. **`SELECT`** – Wybiera kolumny z OBU połączonych tabel do wyświetlenia.

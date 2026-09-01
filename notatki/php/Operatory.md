Operatory to specjalne znaczki i symbole, które pozwalają wykonywać na zmiennych i stałych różnego rodzaju operacje: od zwykłej matematyki, przez porównywanie, aż po logikę.

## 1. Operatory arytmetyczne (Matematyka)

Służą do robienia podstawowych działań matematycznych na liczbach.

| **Symbol** | **Przykład** | **Nazwa** | **Wynik działania** |
| ---------- | ------------ | --------- | ------------------- |
| **+**      | `$a + $b`    | Dodawanie |                     |

Suma zmiennej `$a` i `$b`.

| **-** | `$a - $b` | Odejmowanie |     |
| ----- | --------- | ----------- | --- |

Różnica między `$a` i `$b`.

| **\*** | `$a * $b` | Mnożenie |     |
| ------ | --------- | -------- | --- |

Iloczyn `$a` i `$b`.

| **/** | `$a / $b` | Dzielenie |     |
| ----- | --------- | --------- | --- |

Iloraz `$a` i `$b` (bez reszty).

| **%** | `$a % $b` | Modulo |     |
| ----- | --------- | ------ | --- |

Reszta z dzielenia `$a` przez `$b`.

## 2. Operatory przypisania

Służą do nadawania wartości zmiennym oraz ich szybkiego modyfikowania.

| **Symbol** | **Przykład** | **Opis / Wynik** |
| ---------- | ------------ | ---------------- |
| **=**      | `$a = $b`    |                  |

Przypisuje zmiennej `$a` wartość zmiennej `$b`.

| **+=** | `$a += $b` |     |
| ------ | ---------- | --- |

To samo co: `$a = $a + $b`.

| **-=** | `$a -= $b` |     |
| ------ | ---------- | --- |

To samo co: `$a = $a - $b`.

| **\*=** | `$a *= $b` |     |
| ------- | ---------- | --- |

To samo co: `$a = $a * $b`.

| **/=** | `$a /= $b` |     |
| ------ | ---------- | --- |

To samo co: `$a = $a / $b`.

| **%=** | `$a %= $b` |     |
| ------ | ---------- | --- |

Zmienna `$a` przyjmie wartość reszty z dzielenia `$a` przez `$b`.

| **.=** | `$a .= " dalszy tekst"` |     |
| ------ | ----------------------- | --- |

Dokleja do istniejącego tekstu w zmiennej `$a` nowy fragment na końcu.

## 3. Operatory inkrementacji i dekrementacji

Służą do błyskawicznego zwiększania lub zmniejszania wartości danej zmiennej dokładnie o `1`.

| **Symbol** | **Przykład** | **Nazwa**        | **Wynik działania** |
| ---------- | ------------ | ---------------- | ------------------- |
| **++**     | `++$a`       | Preinkrementacja |                     |

Najpierw zwiększa `$a` o jeden, a dopiero potem ją zwraca.

| **++** | `$a++` | Postinkrementacja |     |
| ------ | ------ | ----------------- | --- |

Najpierw zwraca aktualną wartość `$a`, a dopiero potem zwiększa ją o jeden.

| **--** | `--$a` | Predekrementacja |     |
| ------ | ------ | ---------------- | --- |

Najpierw zmniejsza `$a` o jeden, a potem ją zwraca.

| **--** | `$a--` | Postdekrementacja |     |
| ------ | ------ | ----------------- | --- |

Najpierw zwraca wartość `$a`, po czym zmniejsza ją o jeden.

## 4. Operatory logiczne

Pozwalają łączyć warunki. Zwracają zawsze prawdę (`true`) albo fałsz (`false`).

| **Symbol** | **Przykład** | **Nazwa**        | **Wynik działania** |
| ---------- | ------------ | ---------------- | ------------------- |
| **&&**     | `$a && $b`   | Koniunkcja (AND) |                     |

Zwraca `true` tylko wtedy, gdy **obie** zmienne są prawdziwe.

| \*\* |     | \*\* | `$a \|\| $b` | Alternatywa (OR) |     |
| ---- | --- | ---- | ------------ | ---------------- | --- |

Zwraca `true`, jeśli **przynajmniej jedna** ze zmiennych jest prawdziwa.

| **!** | `!$a` | Negacja (NOT) |     |
| ----- | ----- | ------------- | --- |

Odwraca znaczenie – zwraca `true`, jeśli `$a` ma wartość `false`.

## 5. Operatory porównania

Służą do sprawdzania relacji między dwoma elementami. Jeśli warunek jest spełniony, dają w wyniku `true`.

| **Symbol** | **Przykład** | **Nazwa** | **Wynik działania** |
| ---------- | ------------ | --------- | ------------------- |
| **==**     | `$a == $b`   | Równy     |                     |

Zwraca `true`, jeśli `$a` jest równe `$b`.

| **!=** | `$a != $b` | Nie równe |     |
| ------ | ---------- | --------- | --- |

Zwraca `true`, jeśli `$a` nie jest równe `$b`.

| **===** | `$a === $b` | Identyczny |     |
| ------- | ----------- | ---------- | --- |

Zwraca `true`, jeśli `$a` jest równe `$b` **oraz** są dokładnie tego samego typu.

| **!==** | `$a !== $b` | Nie identyczny |     |
| ------- | ----------- | -------------- | --- |

Zwraca `true`, jeśli `$a` nie jest równe `$b` lub nie są tego samego typu.

| **<** | `$a < $b` | Mniejsze |     |
| ----- | --------- | -------- | --- |

Zwraca `true`, jeśli `$a` jest mniejsze niż `$b`.

| **>** | `$a > $b` | Większe |     |
| ----- | --------- | ------- | --- |

Zwraca `true`, jeśli `$a` jest większe niż `$b`.

| **<=** | `$a <= $b` | Mniejsze lub równe |     |
| ------ | ---------- | ------------------ | --- |

Zwraca `true`, jeśli `$a` jest mniejsze lub równe `$b`.

| **>=** | `$a >= $b` | Większe lub równe |     |
| ------ | ---------- | ----------------- | --- |

Zwraca `true`, jeśli `$a` jest większe lub równe `$b`.

## 6. Operator ciągu (łączenia / konkatenacji)

- **Kropka (\*\***`.`\***\*):** Służy do sklejania kilku kawałków tekstu w jedną całość lub łączenia tekstu ze zmiennymi.

## 7. Operator kontroli błędów

- **Małpa (\*\***`@`\***\*):** Jeśli postawisz ten znak przed wywołaniem jakiegoś polecenia, PHP w razie wystąpienia błędu nie wyświetli na stronie żadnego ostrzeżenia ani komunikatu.

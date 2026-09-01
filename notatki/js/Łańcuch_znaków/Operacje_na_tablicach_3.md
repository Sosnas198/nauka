# Tablice

Tablice (ang. *arrays*) w programowaniu działają jak "super-listy" przypominające szafki z szufladami, w których elementy są uporządkowane w jednym ciągu.

* **Tworzenie tablic:** Tablice tworzy się za pomocą nawiasów kwadratowych `[]`, a elementy oddziela się w nich przecinkami. Możesz w nich umieszczać liczby, teksty (stringi), a nawet inne obiekty.

* **Indeksowanie od zera:** Komputer zawsze zaczyna liczyć szuflady w tablicy od numeru `0` zamiast od `1`. Numery te nazywamy indeksami. Przykładowo, dla tablicy `let zakupy = ['mleko', 'chleb', 'jajka', 'ser'];`, element `zakupy[0]` to `'mleko'`, a `zakupy[2]` to `'jajka'`. Jeśli zażądasz szuflady, której nie ma (np. `zakupy[10]`), JavaScript zwróci wartość `undefined`. Za pomocą indeksu możesz również podmienić element w tablicy, np. `zakupy[1] = 'bułki';`.

* **Właściwość `.length`:** Wskazuje, ile elementów aktualnie znajduje się w tablicy (tutaj komputer liczy normalnie, od `1`). Ogólny wzór na wyciągnięcie ostatniego elementu tablicy to `zakupy[zakupy.length - 1]`.

* **Podstawowe operacje modyfikacji:**

  * `.push(element)` – dodaje nowy element na sam koniec tablicy.
  * `.pop()` – usuwa ostatni element z tablicy i może go zwrócić.
  * `.splice(od_indeksu, ile_elementow_usunąć)` – potężna metoda służąca do usuwania elementów ze środka tablicy (pozostałe elementy automatycznie przuporządkowują swoje indeksy).

* **Przeszukiwanie tablic:**

  * `.includes('element')` – sprawdza, czy dany element znajduje się na liście i zwraca wartość logiczną `true` lub `false`.
  * `.indexOf('element')` – szuka elementu i zwraca numer jego szuflady (indeks). Jeśli szukanego elementu nie ma w tablicy, metoda zwraca `-1`.

* **Sortowanie:** Metoda `.sort()` układa elementy tablicy w odpowiedniej kolejności (np. tekstowej / alfabetycznej od A do Z).

* **Praca z tekstem i tablicami (`split`):** Metoda `blok.split(' ')` dzieli długi ciąg tekstowy na mniejsze kawałki wszędzie tam, gdzie natknie się na podany znak (w tym przypadku spację) i zwraca tablicę zawierającą te pocięte fragmenty tekstu. Alternatywnie do wycinania fragmentów tekstu można stosować metody tekstowe takie jak `.indexOf(' ')` oraz `.slice()`.

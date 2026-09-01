# Zestawienie metod operowania na tablicach

Oto zestawienie metod operowania na tablicach przygotowane na podstawie dostarczonej dokumentacji.

## 1. Czym jest tablica?

Tablica to ciąg elementów umożliwiający przechowywanie wielu wartości w jednej zmiennej. Każdy element ma przyporządkowany indeks liczony od zera ($0, 1, 2\dots$). Tablice, których elementami są inne tablice, to tablice wielowymiarowe.

## 2. Sposoby tworzenia tablic

Tablice można tworzyć na dwa główne sposoby (używając konstruktora `new Array()` lub zapisu z nawiasami kwadratowymi `[]`):

* **Tworzenie pustej tablicy:**

  ```JavaScript
  var tablica1 = new Array();[cite: 5]
  var tablica2 = [];[cite: 5]
  ```

* **Tworzenie tablicy o określonym rozmiarze:**

  ```JavaScript
  var tablica = new Array(10); // tworzy tablicę z 10 pustymi miejscami
  ```

* **Tworzenie tablicy z jednym elementem:**

  ```JavaScript
  var tablica = [10]; // tablica z 1 elementem o wartości 10
  ```

  *(Uwaga:* *`new Array(10)`* *tworzy tablicę 10-elementową, a* *`[10]`* *tworzy tablicę jednoelementową z wartością 10)*.

* **Tworzenie tablicy z gotową listą elementów:**

  ```JavaScript
  var tablica1 = new Array(1, 2, 3, 4, 5);[cite: 5]
  var tablica2 = [1, 2, 3, 4, 5];[cite: 5]
  ```

## 3. Modyfikacja elementów tablicy (dodawanie i usuwanie)

* **`push(element)`** — dodaje element na **koniec** tablicy:

  ```JavaScript
  var tablica = ['Ala', 'Ola', 3];[cite: 5]
  tablica.push("Nowy"); // ['Ala', 'Ola', 3, 'Nowy']
  ```

* **`unshift(element)`** — dodaje element na **początek** tablicy:

  ```JavaScript
  var tablica = ['Ala', 'Ola'];[cite: 5]
  tablica.unshift("Ela"); // ['Ela', 'Ala', 'Ola']
  ```

* **`pop()`** — usuwa **ostatni** element z tablicy:

  ```JavaScript
  var tablica = ['Ala', 'Ola', 'Nowy'];[cite: 5]
  tablica.pop(); // usuwa 'Nowy'
  ```

* **`shift()`** — usuwa **pierwszy** element z tablicy[cite: 5]:

  ```JavaScript
  var tablica = ['Ela', 'Ala', 'Ola'];[cite: 5]
  tablica.shift(); // usuwa 'Ela'[cite: 5]
  ```

## 4. Sortowanie i zmiana kolejności

* **`sort()`** — sortuje elementy tablicy[cite: 5]:

  ```JavaScript
  var tablica = ['Ola', 'Ala', 'Nowy'];[cite: 5]
  tablica.sort(); // ['Ala', 'Nowy', 'Ola'][cite: 5]
  ```

* **`reverse()`** — odwraca kolejność elementów w tablicy[cite: 5]:

  ```JavaScript
  var tablica = ['Ala', 'Ola', 'Nowy'];[cite: 5]
  tablica.reverse(); // ['Nowy', 'Ola', 'Ala'][cite: 5]
  ```

* **Sortowanie malejące** (połączenie obu metod)[cite: 5]:

  ```JavaScript
  var tablica = ['Ala', 'Ola', 'Nowy'];[cite: 5]
  tablica.sort();[cite: 5]
  tablica.reverse();[cite: 5]
  ```

## 5. Wyświetlanie zawartości i pętle

* **Iteracja za pomocą tradycyjnej pętli** **`for`** **oraz** **`.length`****:**

  ```JavaScript
  var tablica = [1, 2, 3, 4, 5];[cite: 5]
  for (var n = 0; n < tablica.length; ++n) {[cite: 5]
      document.write(tablica[n] + "<br>");[cite: 5]
  }
  ```

* **Iteracja za pomocą pętli** **`for...in`****:**

  ```JavaScript
  var tablica = ['Ala', 'Ola', 3, 4, 5];[cite: 5]
  for (var v in tablica) {[cite: 5]
      document.write(tablica[v] + " ");[cite: 5]
  }
  ```

* **Wyświetlenie tablicy bezpośrednio w elemencie DOM:**

  ```JavaScript
  var tablica = ['Ala', 'Ola', 3, 4, 5];[cite: 5]
  document.getElementById("blok").innerHTML = tablica;[cite: 5]
  ```

## 6. Tablice asocjacyjne (obiekty jako tablice klucz-wartość)

W JavaScript tablice asocjacyjne można tworzyć przy użyciu obiektów (`new Object()` lub `{}`), przypisując słowne klucze zamiast indeksów numerycznych[cite: 5]:

* **Tworzenie i przypisywanie elementów:**

  ```JavaScript
  var tablica = new Object();[cite: 5]
  tablica["Ala"] = "kot";[cite: 5]
  tablica["Pi"] = 3.1415;[cite: 5]
  ```

* **Tworzenie za pomocą literału obiektu:**

  ```JavaScript
  var tablica = { "Ala": "kot", "Pi": 3.1415 };[cite: 5]
  ```

* **Odczyt kluczy i wartości za pomocą pętli** **`for...in`****:**

  ```JavaScript
  for (var klucz in tablica) {[cite: 5]
      document.write(klucz + ": " + tablica[klucz] + "<br>");[cite: 5]
  }
  ```

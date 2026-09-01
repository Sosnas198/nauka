# Zasięg zmiennych w JavaScript: Globalny vs Lokalny

W zależności od tego, **GDZIE** zdefiniujesz zmienną (przed funkcją czy w środku funkcji), będzie ona zachowywać się zupełnie inaczej.

---

## 🌐 Scenariusz 1: Zmienna PRZED funkcją (Zasięg globalny / zewnętrzny)

Zmienną definiujemy na zewnątrz, przed funkcją, kiedy chcemy, aby funkcja **pamiętała swój stan przy każdym kolejnym uruchomieniu** (działała jak akumulator lub licznik kroków) albo gdy inne funkcje też muszą mieć do niej dostęp.

### Kiedy warto tak zrobić?

1. **Liczniki kliknięć / akcji:** Gdy każde wywołanie funkcji ma zwiększyć wartość o 1 (np. dodawanie kolejnych bloków: `blok numer: ${i++}`).
2. **Suma skumulowana (globalna):** Gdy dodajesz punkty w grze, wrzucasz produkty do koszyka i chcesz, żeby ta suma rosła przy każdym kliknięciu.

### Jak to działa w praktyce?

**JavaScript**

```javascript
let suma = 0; // Zmienna żyje na zewnątrz i nigdy się nie resetuje sama z siebie

function dodajDoSumy(kwota) {
  suma = suma + kwota; // Funkcja modyfikuje zewnętrzną zmienną
  console.log(`Aktualny stan konta: ${suma}`);
}

dodajDoSumy(10); // Wypisze: Aktualny stan konta: 10
dodajDoSumy(5); // Wypisze: Aktualny stan konta: 15 (pamięta poprzednie 10!)
dodajDoSumy(20); // Wypisze: Aktualny stan konta: 35
```

> 💡 **Teoria:** Zmienna `suma` powstaje tylko raz, na samym początku. Funkcja `dodajDoSumy` po zakończeniu swojego działania "umiera", ale wartość w `suma` zostaje bezpiecznie zapisana w pamięci.

---

## 🔒 Scenariusz 2: Zmienna WEWNĄTRZ funkcji (Zasięg lokalny)

Zmienną definiujemy w środku funkcji, kiedy jest ona potrzebna **tylko na czas trwania tego jednego konkretnego wywołania**, a przy następnym uruchomieniu ma zacząć od zera (od czystej karty).

### Kiedy warto tak zrobić?

1. **Lokalne obliczenia:** Gdy funkcja dostaje jakieś dane, musi szybko coś zsumować (np. ceny z tablicy), zwrócić wynik i zapomnieć o sprawie.
2. **Pętle wewnątrz funkcji:** Gdy zmienna `i` steruje pętlą `for` w środku funkcji.

### Jak to działa w praktyce?

**JavaScript**

```javascript
function obliczZnizke(cenaPodstawowa) {
  let suma = 0; // Ta zmienna rodzi się w momencie wywołania funkcji...

  suma = cenaPodstawowa * 0.9; // ...robi obliczenie...

  return suma; // ...zwraca wynik i W TYM MOMENCIE ZMIENNA "SUMA" UMIERA.
}

console.log(obliczZnizke(100)); // Wypisze: 90
console.log(obliczZnizke(100)); // Wypisze: 90 (za każdym razem startuje od zera)
```

> 💡 **Teoria:** Jeśli zmienna `let suma = 0` jest w środku, to każde kliknięcie lub uruchomienie funkcji tworzy tę zmienną **całkowicie od nowa**. Nie ma mowy o pamiętaniu historii z poprzedniego wywołania.

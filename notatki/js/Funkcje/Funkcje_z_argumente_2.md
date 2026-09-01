# Funkcje z argumentami i pętla z warunkiem omijania

Oto tłumaczenie "dla amatora" krok po kroku połączone z gotowymi blokami kodu z nowego pliku na temat funkcji z argumentami i pętli z warunkiem omijania.

## 1. Budowa tabeli w HTML-u (Struktura z przyciskami)

**Jak to działa po ludzku:**

Tworzymy tabelę z dwoma kolumnami. W lewej kolumnie wpisujemy nazwy kolorów i nadajemy im klasę `.kolor`, żeby JavaScript wiedział, gdzie ich szukać. W prawej kolumnie wrzucamy przyciski "zmien". Każdy przycisk dostaje numer w nawiasie (np. `0`, `1`, `2`), który odpowiada numerowi wiersza w tabeli (komputery liczą od zera!).

**Kod:**

### HTML

```HTML
<table border="1">
<tr>
<td class="kolor">czerwony</td>
<td><button onclick="zmien(0)">zmien</button></td>
</tr>
<tr>
<td class="kolor">niebieski</td>
<td><button onclick="zmien(1)">zmien</button></td>
</tr>
<tr>
<td class="kolor">zolty</td>
<td><button onclick="zmien(2)">zmien</button></td>
</tr>
<tr>
<td class="kolor">zielony</td>
<td><button onclick="zmien(3)">zmien</button></td>
</tr>
<tr>
<td class="kolor">filetowy</td>
<td><button onclick="zmien(4)">zmien</button></td>
</tr>
</table>
```

## 2. Otwieranie okienka i pobieranie koloru od użytkownika (`prompt`)

**Jak to działa po ludzku:**

Kiedy użytkownik kliknie przycisk "zmien", odpala się funkcja z odpowiednim numerem `x`. Pierwsze co robimy, to wywołujemy okienka wyskakującego `prompt`, w które użytkownik wpisuje po angielsku nazwę nowego koloru. Wartość ta ląduje w zmiennej `nowy_kolor`.

## 3. Zmiana nazwy i koloru tekstu w klikniętej komórce

**Jak to działa po ludzku:**

Za pomocą `document.querySelectorAll('.kolor')` zgarniamy wszystkie komórki z klasą `.kolor` do jednej paczki (tablicy). Następnie biorąc konkretną komórkę pod indeksem `x` (czyli tę, której przycisk kliknięto):

1. Zmieniamy jej tekst w środku na to, co wpisał użytkownik (`innerHTML = nowy_kolor`).
2. Zmieniamy kolor samych liter na ten wpisany kolor (`style.color = nowy_kolor`).

## 4. Pętla masowa z ominięciem klikniętego elementu (`if (kolor[i] != kolor[x])`)

**Jak to działa po ludzku:**

Chcemy zmienić tło **wszystkich pozostałych** komórek na kolor podany przez użytkownika, ale **ominąć** tę komórkę, którą właśnie kliknęliśmy. Uruchamiamy pętlę `for`, która idzie po kolei po całej tablicy komórek. Warunek `if (kolor[i] != kolor[x])` działa jak bramkarz: sprawdza, czy aktualnie sprawdzana komórka (`i`) to nie jest ta kliknięta (`x`). Jeśli to inny wiersz – zmienia jej tło (`backgroundColor`) na `nowy_kolor`.

## Cały połączony skrypt JavaScript:

### JavaScript

```JavaScript
function zmien(x){
    // 1. Zgarniamy wszystkie komórki z klasą .kolor do tablicy
    let kolor = document.querySelectorAll('.kolor');

    // 2. Wyskakuje okienko z prośbą o wpisanie koloru po angielsku
    let nowy_kolor = prompt("podaj kolor po ang");

    // 3. Zmieniamy tekst i kolor liter w klikniętej komórce
    kolor[x].style.color = nowy_kolor;
    kolor[x].innerHTML = nowy_kolor;

    // 4. Pętla przechodząca po wszystkich komórkach i zmieniająca tło w pozostałych
    for(let i = 0; i < kolor.length; i++){
        if(kolor[i] != kolor[x]) {
            kolor[i].style.backgroundColor = nowy_kolor;
        }
    }
}
```

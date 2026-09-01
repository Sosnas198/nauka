W języku PHP za pobranie aktualnej daty i czasu (zawsze bezpośrednio z serwera) odpowiada specjalna instrukcja `date()`.

Aby pokazać tę datę lub godzinę na ekranie komputera użytkownika, musimy połączyć ją z poleceniem `echo` lub `print`.

## 1. Jak sprecyzować, co chcemy wyświetlić?

Sama funkcja `date()` nie wie, czy ma pokazać rok, minutę czy dzień tygodnia. Musimy jej to podpowiedzieć za pomocą specjalnych liter wpisanych w cudzysłowie.

Oto ściągawka z najważniejszych oznaczeń:

* **d**: dzień miesiąca w formacie od 01 do 31.
* **D**: skrócona nazwa dnia tygodnia składająca się z 3 liter.
* **l** (mała litera „L”): pełna nazwa dnia tygodnia.
* **m**: miesiąc w formacie od 01 do 12.
* **M**: skrócona nazwa miesiąca składająca się z 3 liter.
* **Y**: rok w wersji czterocyfrowej.
* **y**: skrócona wersja roku pokazująca tylko dwie ostatnie cyfry.
* **H**: godzina w formacie 24-godzinnym (od 00 do 23).
* **h**: godzina w formacie 12-godzinnym z zerami na początku (od 01 do 12).
* **i**: minuty w formacie z zerami (od 00 do 59).
* **s**: sekundy w formacie z zerami (od 00 do 59).

## 2. Przykład praktyczny

Jeśli chcesz wyświetlić na stronie napis „Data: ” wraz z aktualnym rokiem, skróconym miesiącem i dniem, Twój kod PHP będzie wyglądał tak:

PHP

```php
echo "Data: ";
echo date("Y-M-d ");
```

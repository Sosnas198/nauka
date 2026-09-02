`INNER JOIN` służy do tego, aby **uniknąć przepisywania tych samych danych tysiące razy** i zapobiec bałaganowi w bazie.

**Po co to robić? (Problem vs Rozwiązanie)**

- **Gdyby nie było JOIN:** W tabeli z zamówieniami przy każdym zakupie musiałbyś wpisywać imię, nazwisko, adres, telefon i e-mail klienta. Jeśli klient zmieniłby numer telefonu, musiałbyś poprawiać go w 50 miejscach (w każdym jego zamówieniu).
- **Z użyciem JOIN:** Dane klienta trzymasz tylko raz w tabeli `klient`. W tabeli `zamowienie` wpisujesz tylko krótki identyfikator (`id_klienta`). Gdy potrzebujesz pełnego raportu, `JOIN` w ułamku sekundy klei te tabele na ekranie.

**Jak rozczytać wynik, żeby się nie pogubić?**

Gdy baza wykona `INNER JOIN`, tworzy w pamięci tymczasową "super-tabelę", składając wiersze poziomo (zgodnie ze wskazanym kluczem).

Popatrz na to wyobrażeniowo — baza bierze wiersz z lewej tabeli i szuka dla niego "pary" w prawej tabeli:

1. **Patrzy na pierwszą tabelę (\*\***`klient`\***\*):** Widzi wiersz `id: 1, imie: Ania`.
2. **Patrzy na warunek** **`ON`\*\***:\*\* Widzi `klient.id_klienta = zamowienie.id_klienta`.
3. **Szuka w drugiej tabeli (\*\***`zamowienie`\***\*):** Znajduje dwa zamówienia, które mają `id_klienta = 1` (np. zamówienie na 150 zł i zamówienie na 200 zł).
4. **Składa wynik w paski:** Zamiast jednego wiersza dla Ani, dostajesz w wyniku **dwa wiersze**, bo Ania ma dwie pasujące relacje w drugiej tabeli:
   - `[Ania] + [Zamówienie #101 | 150 zł]`
   - `[Ania] + [Zamówienie #102 | 200 zł]`

Jeśli jakiś klient z pierwszej tabeli **nie ma żadnego zamówienia**, baza go odrzuca – nie zobaczysz go w wyniku `INNER JOIN`.

**Dlaczego to może się wydawać mylące?**

Większość osób gubi się, bo w wyniku `INNER JOIN` **liczba wierszy może się zmienić**:

- Jeśli jeden klient zrobił 5 zakupów, w wyniku pojawi się 5 razy (imie Ani powtórzy się 5 razy z różnymi danymi zakupów).
- Jeśli klient nic nie kupił, zniknie z wyniku całkowicie.

`INNER JOIN` tworzy po prostu listę wyłącznie tych par, które **istnieją i pasują do siebie w obu tabelach naraz**.

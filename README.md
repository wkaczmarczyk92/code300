# code300

### 📘 Uruchomienie projektu
Wymagania

PHP 8.2+

Composer

MySQL / MariaDB

(opcjonalnie) Postman / inny klient API

### 🚀 Jak uruchomić projekt lokalnie

Pobierz projekt

git clone <repozytorium>
cd <nazwa_projektu>


### Plik .env

Plik .env jest już dodany do repozytorium i zawiera wstępną konfigurację.
Należy:

utworzyć lokalną bazę danych

uzupełnić dane dostępowe w pliku .env, w szczególności:

DB_DATABASE=
DB_USERNAME=
DB_PASSWORD=


### Zainstaluj zależności (vendor)

composer install


### Wykonaj migracje

php artisan migrate


### Uruchom seedy

php artisan db:seed


Seeder uruchamia wszystkie seedy skonfigurowane w DatabaseSeeder.

Uruchom aplikację

php artisan serve


Aplikacja będzie dostępna pod adresem:

http://127.0.0.1:8000

### 🔐 Logowanie i autoryzacja API

Aby korzystać z API, należy najpierw się zalogować.

### 1️⃣ Logowanie

Wyślij request:

POST /api/login


Body (JSON):

{
  "email": "admin@gmail.com",
  "password": "haslo"
}

W odpowiedzi API zwróci token dostępu.

### 2️⃣ Autoryzacja kolejnych requestów

Każdy kolejny request do chronionych endpointów API musi zawierać nagłówki:

Authorization: Bearer <TOKEN>
Accept: application/json


Bez poprawnego tokena API zwróci 401 Unauthorized.

### 📚 Autorzy i książki

Autorzy i książki są połączone relacją many-to-many poprzez tabelę pivot.

Podczas dodawania autora można przekazać book_id, aby automatycznie powiązać go z książką.

Podczas dodawania książki można przekazać author_id / author_ids, aby powiązać ją z autorem/autorami.

Relacje są zapisywane w tabeli pivot.

### 🧵 Kolejki (Jobs)

Po dodaniu książki uruchamiany jest Job, który zapisuje tytuł ostatnio dodanej książki w kolumnie autora.

Dla uproszczenia (oraz ze względu na czas realizacji) kolejka działa w trybie:

QUEUE_CONNECTION=sync

### ⚠️ Ograniczenia (świadome decyzje)

Ze względu na ograniczony czas realizacji (okres przedświąteczny):

Pominięto rozbudowane filtry przy pobieraniu list (zastosowano jedynie paginate)

Pominięto stworzenie dedykowanej komendy Artisan do dodawania autora

Skupiono się na poprawnej architekturze API, relacjach, walidacji i testach

🧪 Testy

Projekt zawiera testy unit dla API POST /books orac DELETE /books/{id}
Testy można uruchomić poleceniem:

php artisan test tests/Unit/Books/TestBookDestroy.php
php artisan test tests/Unit/Books/TestBookStore.php

### 🧩 Architektura i uproszczenia

Ze względu na to, że projekt powstawał jako **zadanie rekrutacyjne**, logika aplikacji została umieszczona bezpośrednio w **kontrolerach**.

# Symfony Project - Form

Mikroserwis napisany z wykorzystaniem frameworka Symfony.

## 🔥 Instalacja

1. Wklej poniższe komendy (WSZYSTKIE NA RAZ) np. w katalogu /workspace

```bash
# Pobierz repozytorium
git clone https://github.com/jaroslawmuzyka/symfony-project-form project-symfony-form

# Wejdź do katalogu projektu
cd project-symfony-form

# Wejdź do katalogu .docker
cd .docker

# Uruchom kontenery
docker compose up -d

# Zainstaluj Composer i zaktualizuj zależności
docker exec -it symfony_dockerized-php-1 bash -c "composer install"

# Znajdź adres IP bazy danych
DB_IP=$(docker inspect symfony_dockerized-db-1 | grep 'IPAddress' | cut -d '"' -f 4)

# Aktualizuj plik .env z adresem IP bazy danych
awk -v DB_IP="$DB_IP" 'BEGIN { FS = "="; OFS = "=" } /DATABASE_URL/ {$2 = "mysql://app_user:helloworld@" DB_IP ":3306/app_db"} 1' ../.env > tmpfile && mv tmpfile ../.env
```
2. Niestety plik .env w katalogu głównym aplikacji nie zaktualizował się poprawnie - usuń puste miejsca tak aby DATABASE_URL było w jednej linii (usuń odstęp).
```bash
Przykład (bez odstępów): DATABASE_URL=mysql://app_user:helloworld@TUTAJ_ZMIEN_ADRES_IP:3306/app_db
```

5. Wklej poniższe komendy (WSZYSTKIE NA RAZ)
```bash
# Wykonaj migracje i automatycznie odpowiedz "yes" na pytanie
docker exec -it symfony_dockerized-php-1 bash -c "echo 'yes' | bin/console doctrine:migrations:migrate"

# Znajdź port Nginx
NGINX_PORT=$(docker ps --filter name=symfony_dockerized-nginx-1 --format "{{.Ports}}" | cut -d ':' -f 2 | cut -d '-' -f 1)

# Wyświetl informację o uruchomionej aplikacji
GREEN_BACKGROUND=$(tput setab 2)
RESET_COLOR=$(tput sgr0)

echo -e "${GREEN_BACKGROUND}\n\nAPLIKACJA JEST DOSTĘPNA POD ADRESEM: http://localhost:$NGINX_PORT\n${RESET_COLOR}"
```
4. Po wykonaniu skryptu instalacyjnego powieneś na końcu otrzymać wiadomość:
"APLIKACJA JEST DOSTĘPNA POD ADRESEM: [HTTP://LOCALHOST:TWOJ_PORT](http://localhost:TWOJ_PORT/)"


## 📥 [MailTrap.io](https://mailtrap.io/) - przechwytywanie emaili testowych

Skorzystaj z danych demonstracyjnych poniżej (lub załóż konto) aby sprawdzić maile potwierdzające wraz ze szczegółami konta w mailu.

Dane demonstracyjne do MailTarp.io:

```bash
kontakt@jaroslawmuzyka.pl
4q2`W*E7jt54
```
Można też założyć własne konto:

1. Zarejestruj się na stronie: https://mailtrap.io/
2. Przejdź do zakładki EMAIL TESTING -> MY INBOX
3. Naśiśnij na "Show Credentials" i wybierz z rozwijanej listy "Symfony
4. Skopiuj MAILER_DSN i zmień go do pliku .env

## 🔗 Przykładowe linki (zmień port na własny)
- Logowanie http://localhost:37213/login
- Rejestracja http://localhost:37213/register
- Resetowanie hasła http://localhost:37213/reset-password
- Panel administratora http://localhost:37213/admin
- Tworzenie użytkownika z PA http://localhost:37213/admin/create
- Edycja użytkownika http://localhost:37213/admin/edit/1
- Usunięcie użytkownika http://localhost:37213/admin/delete/1

## ✉️ Support

kontakt@jaroslawmuzyka.pl

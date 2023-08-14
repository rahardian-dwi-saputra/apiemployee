# API Employee
API Pegawai digunakan untuk mengelola pembuatan dan pemutakhiran data profil pegawai

## Requirement
- Laravel Valet 2.5.1 or later
- PHP 8.2.4 or later
- Composer 2.5.4 or later
- MySQL Server 8.0 or later
- MySQL Workbench 8.0 CE or later

## Instalasi
- Cloning repository git ke sebuah folder di local
```sh
git clone https://github.com/rahardian-dwi-saputra/apiemployee.git
```

- Install depedensi via composer
```sh
composer install
```

- Buat sebuah file .env
```sh
cp .env.example .env
```

- Buat database kosong menggunakan tool database yang anda sukai. Pada file `.env` isikan opsi `DB_CONNECTION`, `DB_HOST`, `DB_PORT`, `DB_DATABASE`, `DB_USERNAME`, dan `DB_PASSWORD` sesuai dengan kredensial database yang sudah anda buat

- Lakukan migrasi database
```sh
php artisan migrate
php artisan db:seed
```

- Jalankan project dengan valet laravel
```sh
valet start
```
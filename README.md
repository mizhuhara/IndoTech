<p align="center"><a href="#" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="IndoTech"></a></p>

# IndoTech

Proyek website tim IndoTech, dibangun dengan [Laravel](https://laravel.com).

## Requirement

- PHP >= 8.3
- Composer
- Node.js + npm
- Git

## Setup Lokal (untuk setiap anggota tim)

```bash
git clone https://github.com/mizhuhara/IndoTech.git
cd IndoTech
composer install
npm install
cp .env.example .env
php artisan key:generate
touch database/database.sqlite
php artisan migrate --seed
npm run dev
```

Lalu buka `http://localhost:8000`.

> `.env` dan `database.sqlite` bersifat lokal, jangan pernah di-commit atau dibagikan.

## Alur Kerja Tim

1. Selalu mulai dari `main` terbaru:
   ```bash
   git checkout main
   git pull
   ```
2. Buat branch untuk pekerjaanmu:
   ```bash
   git checkout -b fitur/nama-fitur
   ```
3. Kerjakan, lalu commit dengan pesan jelas.
4. Push branch:
   ```bash
   git push -u origin fitur/nama-fitur
   ```
5. Buka **Pull Request** di GitHub, minta review teman.
6. Jangan push langsung ke `main`.

### Sebelum push, jalankan dulu:

```bash
composer test
vendor/bin/pint
```

## Tooling

- `composer dev` — jalanin server dev dengan hot reload.
- `composer setup` — setup otomatis di mesin baru (install, .env, key, migrate, build assets).
- `vendor/bin/pint` — format kode biar gaya semua anggota seragam.

## License

Dibangun di atas framework [MIT license](https://opensource.org/licenses/MIT).
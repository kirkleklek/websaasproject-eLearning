# Migrasi Database dari PostgreSQL ke MySQL

## Perubahan yang Sudah Dilakukan

✅ **Config Files Updated**
- [config/database.php](wib_app/config/database.php) - Default connection diubah ke `mysql`
- [.env](wib_app/.env) - Database credentials diupdate ke MySQL local

✅ **Kompatibilitas Code**
- Semua migrations sudah kompatibel (menggunakan Laravel schema builder)
- Query `selectRaw` di controllers sudah kompatibel dengan MySQL
- Tidak ada PostgreSQL-specific syntax yang ditemukan

## Langkah Setup MySQL

### 1. Install MySQL (jika belum)
Download dan install MySQL dari: https://dev.mysql.com/downloads/mysql/

### 2. Buat Database
Buka MySQL command line atau tool seperti phpMyAdmin, lalu jalankan:

```sql
CREATE DATABASE wib_saas CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

### 3. Update Credentials di .env
Edit file `.env` dan sesuaikan kredensial MySQL Anda:

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=wib_saas
DB_USERNAME=root
DB_PASSWORD=your_mysql_password_here
```

### 4. Clear Cache dan Jalankan Migrations
```bash
cd wib_app
php artisan config:clear
php artisan cache:clear
php artisan migrate:fresh --seed
```

## Testing Connection

Test koneksi database dengan:
```bash
php artisan tinker
>>> DB::connection()->getPdo();
```

Jika berhasil, akan menampilkan PDO object tanpa error.

## Catatan Penting

- **Backup Data**: Jika ada data penting di PostgreSQL, export dulu sebelum migrasi
- **Credentials**: Pastikan password MySQL sudah diisi di `.env`
- **Port**: Default MySQL port adalah 3306 (beda dengan PostgreSQL 5432)
- **Charset**: MySQL sudah di-set ke `utf8mb4` untuk support emoji dan karakter internasional

## Rollback ke PostgreSQL (jika diperlukan)

Jika ingin kembali ke PostgreSQL, ubah `.env`:
```env
DB_CONNECTION=pgsql
DB_HOST=hayabusa.proxy.rlwy.net
DB_PORT=51645
DB_DATABASE=railway
DB_USERNAME=postgres
DB_PASSWORD=nyrEgqNVQzoQZRdWLVwwpsIEtXNarrYN
```

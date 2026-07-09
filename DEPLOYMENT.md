# Deployment Guide - Railway

## Quick Deploy to Railway

### 1. Setup PostgreSQL Database

Di Railway dashboard:
1. Klik **"+ New"** → **"Database"** → **"Add PostgreSQL"**
2. Railway akan auto-create database dan set environment variables

### 2. Set Environment Variables

Di Railway project settings → **Variables** tab, set:

```bash
# Application
APP_NAME="WIB Learning"
APP_ENV=production
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app

# Generate APP_KEY dengan: php artisan key:generate --show
APP_KEY=base64:YOUR_GENERATED_KEY_HERE

# Database (Railway auto-inject dari PostgreSQL service)
DB_CONNECTION=pgsql
DB_HOST=${PGHOST}
DB_PORT=${PGPORT}
DB_DATABASE=${PGDATABASE}
DB_USERNAME=${PGUSER}
DB_PASSWORD=${PGPASSWORD}

# Session & Cache
SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

# Mail (Setup nanti untuk production)
MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@wib.com
MAIL_FROM_NAME="${APP_NAME}"

# Storage
FILESYSTEM_DISK=public
```

### 3. Generate APP_KEY

Jalankan di local:
```bash
php artisan key:generate --show
```

Copy hasilnya (format: `base64:xxxxx`) dan paste ke Railway environment variable `APP_KEY`.

### 4. Deploy

Railway akan auto-deploy setiap kali ada push ke GitHub.

Atau trigger manual deploy di Railway dashboard.

### 5. Verify Deployment

Setelah deploy success:
1. Buka URL Railway kamu: `https://your-app.up.railway.app`
2. Test register & login
3. Check admin dashboard

---

## Troubleshooting

### Error: "No application encryption key has been specified"
→ Set `APP_KEY` di Railway environment variables

### Error: Migration failed
→ Database connection issue, check `DB_*` variables

### Error: 500 Internal Server Error
→ Check logs di Railway dashboard → **Deploy Logs**

---

## Using Supabase Instead of Railway PostgreSQL

Jika menggunakan Supabase:

1. Buat project di [Supabase](https://supabase.com)
2. Get connection string dari: Settings → Database → Connection String → URI
3. Set di Railway variables:

```bash
DB_CONNECTION=pgsql
DB_HOST=db.your-project.supabase.co
DB_PORT=5432
DB_DATABASE=postgres
DB_USERNAME=postgres
DB_PASSWORD=your-supabase-password
```

**Note:** Supabase = PostgreSQL, jadi config sama persis.

---

## Production Checklist

Sebelum production dengan real users:

- [ ] Setup email service (Mailgun/SES) - ganti `MAIL_MAILER=log`
- [ ] Setup payment gateway (Midtrans/Xendit) - tambah config
- [ ] Setup S3/cloud storage untuk files - ganti `FILESYSTEM_DISK=s3`
- [ ] Setup Redis untuk queue & cache (optional tapi recommended)
- [ ] Enable error tracking (Sentry/Flare)
- [ ] Setup backup strategy untuk database
- [ ] Test full user flow (register → upgrade → certificate)

---

## Next Steps

Setelah deployment berhasil, baca [README.md](README.md) untuk:
- Setup email notifications
- Payment gateway integration
- Production optimization tips

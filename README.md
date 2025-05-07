# Digital Guestbook System

Sistem buku tamu digital dengan penyimpanan MySQL dan login AJAX.

## Fitur

- Sistem autentikasi pengguna
- Pencatatan pesan tamu dengan timestamp
- Penyimpanan database (MySQL)
- Login berbasis AJAX untuk pengalaman pengguna yang lebih baik
- Desain responsif dengan Bootstrap 5

## Tampilan Aplikasi

- Halaman login dengan animasi dan validasi form
- Dashboard buku tamu dengan form pengisian dan daftar pesan
- Penyimpanan data terorganisir di database

## Persyaratan Sistem

- PHP 7.4+
- MySQL 5.7+
- Web server (Apache/Nginx)

## Instalasi

1. Clone repositori ini

   git clone https://github.com/natasysthms/BukuTamu.git

2. Buat database MySQL

   mysql -u username -p < database_setup.sql
   mysql -u username -p < additional_tables.sql


3. Konfigurasi koneksi database
   - Buka file `db_connect.php`
   - Perbarui kredensial database:
    php
     $db_host = 'localhost';     // Host database Anda
     $db_user = 'username';      // Username MySQL Anda
     $db_pass = 'password';      // Password MySQL Anda
     $db_name = 'buku_tamu';     // Nama database
   

4. (Opsional) Migrasi data dari file teks
   - Jika Anda memiliki file data_tamu.txt, jalankan migrate_data.php
   - Akses via browser: `http://localhost/path/to/migrate_data.php`

5. Akses aplikasi
   - URL: `http://localhost/path/to/login.php`
   - Login default: admin / admin123

## Struktur File


/
├── database_setup.sql       # Skrip pembuatan database dan tabel
├── additional_tables.sql    # Tabel tambahan (log, indeks)
├── db_connect.php           # Koneksi database
├── login.php                # Halaman login (AJAX)
├── login_process.php        # Proses login AJAX
├── guestbook.php            # Halaman utama buku tamu
├── logout.php               # Handler logout
└── migrate_data.php         # Skrip migrasi data (opsional)


## Penggunaan

1. Login menggunakan kredensial yang telah dikonfigurasi
2. Setelah login berhasil, Anda akan diarahkan ke halaman buku tamu
3. Isi form dengan nama, email, dan pesan
4. Kirim pesan untuk menambahkan entri baru ke buku tamu
5. Lihat daftar pesan yang telah dikirim di bagian bawah halaman
6. Logout setelah selesai menggunakan aplikasi

## Keamanan

- Password disimpan dalam bentuk hash menggunakan bcrypt
- Proteksi terhadap SQL injection dengan prepared statements dan escaping
- Validasi input pada sisi server dan klien
- Sistem log untuk melacak aktivitas login

## Pengembangan Lanjutan

Beberapa ide untuk pengembangan lebih lanjut:
- Sistem registrasi pengguna
- Paginasi untuk daftar tamu
- Fitur pencarian dan filter
- Panel admin untuk moderasi pesan
- Implementasi AJAX untuk pengiriman pesan

## Kontribusi

Kontribusi selalu diterima. Untuk berkontribusi:

1. Fork repositori ini
2. Buat branch fitur baru (`git checkout -b feature/fitur-keren`)
3. Commit perubahan Anda (`git commit -m 'Menambahkan fitur keren'`)
4. Push ke branch (`git push origin feature/fitur-keren`)
5. Buat Pull Request baru

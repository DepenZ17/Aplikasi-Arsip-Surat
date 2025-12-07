# Aplikasi Arsip Surat

Aplikasi Arsip Surat berbasis web yang digunakan untuk mengelola surat masuk dan surat keluar, termasuk pencatatan, pencarian, dan pelacakan disposisi. Aplikasi ini ditujukan untuk membantu bagian administrasi/umum dalam mengarsipkan dokumen surat secara lebih rapi, terstruktur, dan mudah ditemukan kembali.

---

## ✨ Fitur Utama

- **Manajemen Surat Masuk**
  - Input data surat masuk (nomor surat, tanggal, asal surat, perihal, lampiran, dll).
  - Upload file scan surat.
  - Pencarian surat masuk berdasarkan kata kunci, nomor, atau rentang tanggal.

- **Manajemen Surat Keluar**
  - Input data surat keluar (nomor surat, tanggal, tujuan, perihal, dll).
  - Pencarian surat keluar berdasarkan kata kunci, nomor, atau rentang tanggal.

- **Disposisi & Klasifikasi**
  - Pencatatan disposisi surat ke bagian/pejabat terkait.
  - Manajemen klasifikasi / jenis surat.
  - Referensi data pendukung (klasifikasi, jenis, dll).

- **User & Pengaturan**
  - Login dan logout.
  - Pengaturan pengguna dan hak akses (admin / user lain).
  - Menu pengaturan aplikasi (misalnya instansi, logo, dsb. tergantung implementasi).

- **Backup & Restore (jika tersedia)**
  - Menu backup dan restore data melalui antarmuka aplikasi.

---

## 🛠️ Teknologi yang Digunakan

- **Bahasa Pemrograman**: PHP  
- **Database**: MySQL / MariaDB  
- **Front-end**:
  - HTML, CSS, JavaScript  
  - Bisa menggunakan Bootstrap / CSS custom  
- **Web Server**: Apache (melalui XAMPP / Laragon / WAMP atau sejenis)

---

## 📁 Struktur Folder (singkat)

Beberapa folder penting di dalam project (nama bisa disesuaikan dengan struktur asli):

- `asset/` – berisi asset front-end seperti CSS, JS, dan gambar.  
- `database/` – berisi file SQL (struktur dan data awal database).  
- `include/` – file helper / konfigurasi tambahan.  
- `upload/` – tempat penyimpanan file upload (scan surat, lampiran, dll).  
- `admin`, `disposisi`, `agenda_surat_masuk`, `agenda_surat_keluar`, dll. – modul-modul fungsi aplikasi.  
- File PHP di root – halaman utama, login, pengaturan, transaksi surat, dll.

---

## 📦 Persyaratan Sistem

- PHP 7.x atau lebih baru  
- MySQL / MariaDB  
- Web server Apache  
- Disarankan menggunakan:
  - XAMPP / Laragon / WAMP atau stack sejenis

---

## 🚀 Cara Instalasi (Lokal)

1. **Clone / Download Project**

   Clone repo:

   ```bash
   git clone https://github.com/USERNAME/NAMA-REPO-ARSIP.git
atau download sebagai ZIP dari GitHub dan extract ke folder htdocs (XAMPP) atau www (Laragon).

Buat Database

Buka phpMyAdmin.

Buat database baru, misalnya: arsip_surat.

Import file SQL yang ada di folder:

database/arsip_surat.sql


(ganti dengan nama file .sql yang sesuai dengan isi folder database milik Anda).

Konfigurasi Koneksi Database

Cari file koneksi database, contoh umum:

koneksi.php
config.php
include/koneksi.php


Sesuaikan pengaturan:

$host     = "localhost";
$user     = "root";
$password = "";
$db       = "arsip_surat";


Ganti nama database, user, dan password sesuai pengaturan MySQL yang Anda gunakan.

Jalankan Aplikasi

Aktifkan Apache dan MySQL di XAMPP / Laragon.

Buka browser dan akses:

http://localhost/arsip


(sesuaikan dengan nama folder project ini di htdocs / www).

🧑‍💻 Pengembangan

Jika ingin mengembangkan aplikasi ini lebih lanjut:

Ubah logika dan tampilan di file PHP di root dan di folder seperti admin/, disposisi/, agenda_surat_masuk/, agenda_surat_keluar/, dll.

Sesuaikan CSS dan JavaScript di folder asset/, css/, atau js/ (jika struktur memisahkan asset).

========================================================================
SIDA-KB (Sistem Informasi & Digitalisasi Kearsipan Program KB)
Versi: PHP Native (MySQL PDO)
========================================================================

STRUKTUR FOLDER & BERKAS:
├── assets/
│   ├── css/
│   │   └── style.css            -> Desain antarmuka & format cetak A4 kop dinas
│   └── js/
│       ├── api.js               -> Client API request (proses/api.php)
│       └── app.js               -> Kontroller logika CRUD, filter & modal
├── config/
│   └── database.php             -> Pengaturan koneksi database MySQL (PDO)
├── database/
│   └── sida_kb_backup.sql       -> Backup skema tabel & data awal BKKBN
├── includes/
│   ├── header.php               -> Template header HTML & CDN
│   ├── navbar.php               -> Navigasi menu & jam realtime
│   ├── footer.php               -> Template footer
│   └── modals.php               -> Modal tambah/edit, detail, hapus, toast
├── proses/
│   └── api.php                  -> Backend pemroses CRUD & API
├── .htaccess                    -> Keamanan & konfigurasi web server Apache
├── arsip.php                    -> Halaman data arsip & pencarian live
├── index.php                    -> Halaman dashboard utama
├── panduan.php                  -> Halaman panduan Jadwal Retensi Arsip (JRA)
├── rekapitulasi.php             -> Halaman cetak laporan rekapitulasi resmi
├── tentang.php                  -> Halaman informasi sistem SIDA-KB
└── README.txt                   -> Berkas petunjuk ini

========================================================================
CARA HOSTING KE INFINITYFREE:
========================================================================
1. Buka File Manager di InfinityFree, masuk ke dalam folder "htdocs".
2. Buka berkas "config/database.php", masukkan Kata Sandi MySQL Anda di baris:
   $db_pass = 'MASUKKAN_KATA_SANDI_ANDA';
3. Upload seluruh isi folder ini langsung ke dalam folder "htdocs".
4. Buka domain gratis Anda di peramban (browser).
5. Sistem akan otomatis mendeteksi dan membuat tabel database saat pertama
   kali dibuka!
========================================================================


<?php
/**
 * =========================================================================
 * KONFIGURASI DATABASE MYSQL (PHP NATIVE) - SIDA-KB
 * Sistem Informasi & Digitalisasi Kearsipan Program KB
 * =========================================================================
 */

// Cek apakah sedang dijalankan di localhost atau di hosting InfinityFree
$isLocal = in_array($_SERVER['HTTP_HOST'] ?? '', ['localhost', '127.0.0.1', 'sida-kb.test']) 
           || (isset($_SERVER['SERVER_NAME']) && in_array($_SERVER['SERVER_NAME'], ['localhost', '127.0.0.1', 'sida-kb.test']));

if ($isLocal) {
    // 1. PENGATURAN LOCALHOST (Laragon / XAMPP)
    $db_host = '127.0.0.1';
    $db_port = '3306';
    $db_name = 'sida_kb';
    $db_user = 'root';
    $db_pass = '';
} else {
    // 2. PENGATURAN HOSTING INFINITYFREE
    $db_host = 'sql101.infinityfree.com';
    $db_port = '3306';
    $db_name = 'if0_43405923_sida_kb';
    $db_user = 'if0_43405923';
    $db_pass = 'MASUKKAN_KATA_SANDI_ANDA'; // <-- Ganti dengan Kata Sandi MySQL InfinityFree Anda
}

$pdo = null;
$db_error = null;

try {
    $dsn = "mysql:host={$db_host};port={$db_port};dbname={$db_name};charset=utf8mb4";
    $options = [
        PDO::ATTR_ERRMODE            => PDO::ERRMODE_EXCEPTION,
        PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
        PDO::ATTR_EMULATE_PREPARES   => false,
    ];
    $pdo = new PDO($dsn, $db_user, $db_pass, $options);
    
    // Auto-create tabel arsip jika belum ada
    checkAndInitTables($pdo);

} catch (PDOException $e) {
    $db_error = $e->getMessage();
}

/**
 * Fungsi helper untuk mengambil objek koneksi PDO
 */
function getDB() {
    global $pdo, $db_error, $db_host, $db_name, $db_user;
    if (!$pdo) {
        http_response_code(500);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode([
            'success' => false,
            'message' => 'Gagal terhubung ke database MySQL: ' . $db_error,
            'hint' => 'Pastikan pengaturan di file config/database.php sudah sesuai.'
        ]);
        exit;
    }
    return $pdo;
}

/**
 * Otomatis membuat tabel arsip dan data awal BKKBN jika tabel belum ada
 */
function checkAndInitTables($pdo) {
    try {
        $check = $pdo->query("SHOW TABLES LIKE 'arsip'");
        if ($check->rowCount() === 0) {
            $sql = "CREATE TABLE IF NOT EXISTS `arsip` (
                `id` bigint unsigned NOT NULL AUTO_INCREMENT,
                `no_arsip` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `judul` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `sub_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `tanggal_arsip` date NOT NULL,
                `lokasi_fisik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `masa_retensi` int NOT NULL DEFAULT 5,
                `status_retensi` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
                `deskripsi` text COLLATE utf8mb4_unicode_ci,
                `created_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP,
                `updated_at` timestamp NULL DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
                PRIMARY KEY (`id`),
                UNIQUE KEY `arsip_no_arsip_unique` (`no_arsip`)
            ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;";
            $pdo->exec($sql);

            $stmt = $pdo->prepare("INSERT INTO `arsip` 
                (`no_arsip`, `judul`, `kategori`, `sub_kategori`, `tanggal_arsip`, `lokasi_fisik`, `masa_retensi`, `status_retensi`, `deskripsi`) 
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)");

            $samples = [
                ['KB/2026/001', 'Kartu Peserta KB (K/I/KB) Implan Ny. Rahmawati', 'Pelayanan Medik', 'Kartu Peserta KB (K/I/KB)', '2026-02-10', 'Rak A1 - Boks 01', 5, 'Aktif', 'Rekam medik pelayanan pemasangan Implan 2 batang di Puskesmas Sehat, lengkap dengan informed consent dan anamnesa medis.'],
                ['KB/2026/002', 'Informed Consent Tindakan Medis Tubektomi (MOW)', 'Pelayanan Medik', 'Informed Consent', '2026-01-18', 'Rak A1 - Boks 02', 10, 'Aktif', 'Surat persetujuan tindakan medis operatif kontrasepsi mantap wanita (MOW) beserta surat persetujuan dan tanda tangan suami.'],
                ['KB/2025/014', 'Berita Acara Serah Terima (BAST) Alokon IUD & Kondom', 'Logistik Alokon', 'BAST Alokon', '2025-11-05', 'Rak B2 - Boks 05', 5, 'Aktif', 'Penerimaan alokon DAK Subbidang KB dari Gudang Farmasi Kabupaten ke Balai Penyuluhan KB sebanyak 500 set IUD CuT 380A dan 100 gross kondom.'],
                ['KB/2023/008', 'Dokumentasi & Notulen KIE Kelompok Bina Keluarga Balita (BKB)', 'Pendataan & KIE', 'Materi & Notulen KIE', '2023-08-14', 'Rak D1 - Boks 03', 3, 'Aktif', 'Laporan penyuluhan 1000 Hari Pertama Kehidupan (HPK) pencegahan stunting pada kelompok sasaran ibu hamil dan baduta di Desa Sukamaju.'],
                ['KB/2021/045', 'Kartu Catatan Alokon Keluar Masuk Gudang Tahun 2021', 'Logistik Alokon', 'Kartu Stok Alokon', '2021-06-20', 'Rak B3 - Boks 12', 5, 'Inaktif', 'Catatan distribusi pil kombinasi dan suntik 3 bulanan Depo Progestin ke jejaring faskes dan bidan praktik mandiri (BPM).'],
                ['KB/2016/003', 'Kuitansi & SPJ Belanja Operasional KIE KB Keliling TA 2016', 'Administrasi & Laporan', 'SPJ Operasional', '2016-04-12', 'Gudang Retensi - Boks 99', 5, 'Siap Musnah', 'Berkas pertanggungjawaban keuangan kegiatan mobil penerangan KB tahun 2016 yang telah diaudit dan telah melampaui batas masa simpan inaktif 5 tahun.']
            ];

            foreach ($samples as $s) {
                $stmt->execute($s);
            }
        }
    } catch (Exception $e) {
        // Abaikan
    }
}


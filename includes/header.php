<?php
/**
 * =========================================================================
 * HEADER TEMPLATE - SIDA-KB
 * =========================================================================
 */
require_once __DIR__ . '/../config/database.php';
if (!isset($pageTitle)) {
    $pageTitle = 'SIDA-KB | Sistem Informasi & Digitalisasi Kearsipan Program KB';
}
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title><?= htmlspecialchars($pageTitle) ?></title>
  <meta name="description" content="Sistem Informasi & Digitalisasi Kearsipan Program Keluarga Berencana (SIDA-KB) untuk Balai Penyuluhan KB dan Faskes.">

  <!-- Favicon -->
  <link rel="icon" type="image/svg+xml" href="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' viewBox='0 0 24 24' fill='%23059669'><path d='M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'/></svg>">

  <!-- Tailwind CSS CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            brand: {
              50: '#ecfdf5',
              100: '#d1fae5',
              200: '#a7f3d0',
              500: '#10b981',
              600: '#059669',
              700: '#047857',
              800: '#065f46',
              900: '#064e3b',
            }
          }
        }
      }
    }
  </script>

  <!-- Google Font: Plus Jakarta Sans -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">

  <!-- Custom Stylesheet -->
  <link rel="stylesheet" href="assets/css/style.css">
</head>
<body class="bg-slate-50 text-slate-800 min-h-screen flex flex-col antialiased selection:bg-brand-500 selection:text-white">

  <?php if (!empty($db_error)): ?>
  <!-- Alert Banner jika Database Belum Terhubung di Hosting -->
  <div class="bg-amber-500 text-slate-900 px-4 py-2.5 text-xs border-b border-amber-600 no-print">
    <div class="max-w-7xl mx-auto flex items-center justify-between gap-3">
      <div class="flex items-center gap-2">
        <svg class="w-5 h-5 flex-shrink-0 text-slate-900" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        <span><strong>Koneksi Database Belum Dikonfigurasi:</strong> Silakan buka file <code>config/database.php</code> dan masukkan nama host, user, password, dan nama database MySQL Anda.</span>
      </div>
      <span class="text-[11px] font-mono bg-amber-400 px-2 py-0.5 rounded"><?= htmlspecialchars($db_error) ?></span>
    </div>
  </div>
  <?php endif; ?>


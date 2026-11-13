<?php
/**
 * =========================================================================
 * HALAMAN DATA ARSIP - SIDA-KB
 * =========================================================================
 */
$activePage = 'arsip';
$pageTitle = 'Data Arsip | SIDA-KB';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

  <!-- HEADER HALAMAN DATA ARSIP -->
  <div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4">
    <div>
      <h1 class="text-2xl font-black text-slate-900 tracking-tight">Manajemen Data Arsip KB</h1>
      <p class="text-xs text-slate-500 mt-1">Daftar inventaris arsip fisik, lokasi simpan, klasifikasi, dan kontrol masa retensi berkas.</p>
    </div>
    <div class="flex items-center gap-2">
      <button onclick="openAddModal()" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 text-white font-semibold text-xs shadow-sm transition-all transform active:scale-95">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        <span>+ Tambah Berkas Baru</span>
      </button>
      <a href="rekapitulasi.php" class="inline-flex items-center gap-2 px-3.5 py-2.5 rounded-xl border border-slate-300 bg-white hover:bg-slate-50 text-slate-700 font-semibold text-xs shadow-sm transition-colors">
        <svg class="w-4 h-4 text-slate-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        <span>Cetak Rekap</span>
      </a>
    </div>
  </div>

  <!-- BAR PENCARIAN & FILTER CONTROLS -->
  <section class="glass-panel p-4 rounded-xl border border-slate-200 shadow-sm filter-controls space-y-3">
    <div class="flex flex-col lg:flex-row items-stretch lg:items-center justify-between gap-3">
      
      <!-- Search Input -->
      <div class="relative flex-1">
        <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none text-slate-400">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/></svg>
        </div>
        <input type="text" id="search-input" placeholder="Cari nomor arsip, judul berkas, sub-kategori, lokasi, atau deskripsi..." class="w-full pl-10 pr-4 py-2.5 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:border-brand-500 text-sm bg-white placeholder-slate-400 transition-shadow">
      </div>

      <!-- Dropdowns & Reset Filter -->
      <div class="flex flex-wrap items-center gap-2">
        
        <!-- Filter Kategori -->
        <div class="flex items-center gap-1.5">
          <label for="filter-kategori" class="text-xs font-semibold text-slate-600 whitespace-nowrap">Kategori:</label>
          <select id="filter-kategori" class="px-3 py-2 rounded-lg border border-slate-300 bg-white text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
            <option value="Semua">Semua Kategori</option>
            <option value="Pelayanan Medik">Pelayanan Medik</option>
            <option value="Pendataan & KIE">Pendataan & KIE</option>
            <option value="Logistik Alokon">Logistik Alokon</option>
            <option value="Administrasi & Laporan">Administrasi & Laporan</option>
          </select>
        </div>

        <!-- Filter Status Retensi -->
        <div class="flex items-center gap-1.5">
          <label for="filter-status" class="text-xs font-semibold text-slate-600 whitespace-nowrap">Status:</label>
          <select id="filter-status" class="px-3 py-2 rounded-lg border border-slate-300 bg-white text-xs font-medium text-slate-700 focus:outline-none focus:ring-2 focus:ring-brand-500">
            <option value="Semua">Semua Status</option>
            <option value="Aktif">Aktif</option>
            <option value="Inaktif">Inaktif</option>
            <option value="Siap Musnah">Siap Musnah</option>
          </select>
        </div>

        <!-- Reset Filter Button -->
        <button id="btn-reset-filter" class="px-3 py-2 rounded-lg border border-slate-300 bg-slate-100 hover:bg-slate-200 text-slate-600 text-xs font-medium transition-colors" title="Reset semua filter">
          Reset
        </button>

      </div>

    </div>

    <div class="flex items-center justify-between text-xs text-slate-500 pt-1 border-t border-slate-100">
      <span id="table-count-badge" class="font-medium">Memuat data...</span>
      <span class="text-slate-400">Pembaruan kearsipan realtime otomatis</span>
    </div>
  </section>

  <!-- TABEL DATA ARSIP -->
  <section class="glass-panel rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse">
        <thead>
          <tr class="bg-slate-100/80 border-b border-slate-200 text-[11px] font-bold text-slate-600 uppercase tracking-wider">
            <th class="py-3 px-4 text-center w-12">No</th>
            <th class="py-3 px-4 w-36">No. Arsip</th>
            <th class="py-3 px-4">Judul &amp; Sub-Kategori</th>
            <th class="py-3 px-4 w-44">Kategori</th>
            <th class="py-3 px-4 w-32">Tanggal</th>
            <th class="py-3 px-4 w-36">Lokasi Fisik</th>
            <th class="py-3 px-4 w-28">Status Retensi</th>
            <th class="py-3 px-4 text-right w-28">Aksi</th>
          </tr>
        </thead>
        <tbody id="arsip-table-body" class="divide-y divide-slate-100 bg-white">
          <!-- Dynamically populated rows via JS -->
        </tbody>
      </table>
    </div>

    <!-- Table Loading Indicator -->
    <div id="table-loading" class="hidden p-8 text-center text-slate-400">
      <div class="inline-block animate-spin w-6 h-6 border-2 border-brand-600 border-t-transparent rounded-full mb-2"></div>
      <p class="text-xs">Memuat data kearsipan...</p>
    </div>

    <!-- Empty State -->
    <div id="table-empty" class="hidden p-12 text-center">
      <div class="w-16 h-16 mx-auto mb-3 rounded-full bg-slate-100 flex items-center justify-center text-slate-400">
        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 13h6m-3-3v6m-9 1V7a2 2 0 012-2h6l2 2h6a2 2 0 012 2v8a2 2 0 01-2 2H5a2 2 0 01-2-2z"/></svg>
      </div>
      <h4 class="text-base font-bold text-slate-700">Tidak ada arsip ditemukan</h4>
      <p class="text-xs text-slate-500 max-w-sm mx-auto mt-1">Coba sesuaikan kata kunci pencarian atau bersihkan filter yang aktif.</p>
      <button onclick="openAddModal()" class="mt-4 px-4 py-2 bg-brand-600 text-white rounded-lg text-xs font-semibold hover:bg-brand-700 transition-colors">
        + Tambah Arsip Baru
      </button>
    </div>
  </section>

</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


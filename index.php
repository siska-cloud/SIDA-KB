<?php
/**
 * =========================================================================
 * HALAMAN DASHBOARD - SIDA-KB
 * =========================================================================
 */
$activePage = 'dashboard';
$pageTitle = 'Dashboard | SIDA-KB';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

  <!-- BANNER SELAMAT DATANG -->
  <div class="glass-panel p-6 rounded-2xl border border-brand-200 bg-gradient-to-r from-emerald-900 to-brand-800 text-white relative overflow-hidden shadow-sm">
    <div class="relative z-10 flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
      <div>
        <span class="px-2.5 py-1 rounded bg-brand-700/80 text-[11px] font-bold uppercase tracking-wider text-brand-200 border border-brand-600">
          Sistem Informasi & Digitalisasi Kearsipan
        </span>
        <h1 class="text-2xl md:text-3xl font-black mt-2">Selamat Datang di Portal SIDA-KB</h1>
        <p class="text-xs text-emerald-100 max-w-2xl mt-1.5 leading-relaxed">
          Pengelolaan arsip program Keluarga Berencana berstandar BKKBN dan ANRI. Pantau retensi berkas aktif, inaktif, hingga penilaian pemusnahan secara akurat dan terpadu.
        </p>
      </div>
      <div class="flex items-center gap-2.5 flex-shrink-0">
        <a href="arsip.php" class="px-4 py-2.5 rounded-xl bg-white text-emerald-900 hover:bg-emerald-50 text-xs font-bold shadow-md transition-all flex items-center gap-2">
          <svg class="w-4 h-4 text-emerald-700" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
          <span>Buka Data Arsip</span>
        </a>
      </div>
    </div>
  </div>

  <!-- STATISTIK RINGKASAN CARDS -->
  <section class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 dashboard-cards">
    
    <!-- Total Arsip -->
    <div class="glass-panel p-5 rounded-2xl shadow-sm border border-slate-200/80 hover:shadow-md transition-shadow relative overflow-hidden">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold uppercase tracking-wider text-slate-500">Total Berkas Terdaftar</p>
          <h3 id="stat-total" class="text-3xl font-extrabold text-slate-900 mt-1">0</h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-slate-100 text-slate-700 flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 4H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2h-2m-4-1v8m0 0l3-3m-3 3L9 8m-5 5h2.586a1 1 0 01.707.293l2.414 2.414a1 1 0 00.707.293h3.172a1 1 0 00.707-.293l2.414-2.414a1 1 0 01.707-.293H20"/></svg>
        </div>
      </div>
      <div class="mt-3 flex items-center gap-1.5 text-xs text-slate-500">
        <span class="inline-block w-2 h-2 rounded-full bg-slate-400"></span>
        Semua kategori kearsipan KB
      </div>
      <div class="absolute bottom-0 left-0 right-0 h-1 bg-slate-400"></div>
    </div>

    <!-- Arsip Aktif -->
    <div class="glass-panel p-5 rounded-2xl shadow-sm border border-emerald-200 hover:shadow-md transition-shadow relative overflow-hidden bg-gradient-to-br from-white to-emerald-50/50">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold uppercase tracking-wider text-emerald-700">Arsip Aktif</p>
          <h3 id="stat-aktif" class="text-3xl font-extrabold text-emerald-800 mt-1">0</h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-emerald-100 text-emerald-700 flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
      </div>
      <div class="mt-3 flex items-center gap-1.5 text-xs text-emerald-700 font-medium">
        <span class="inline-block w-2 h-2 rounded-full bg-emerald-500"></span>
        Masih dalam masa guna operasional
      </div>
      <div class="absolute bottom-0 left-0 right-0 h-1 bg-emerald-500"></div>
    </div>

    <!-- Arsip Inaktif -->
    <div class="glass-panel p-5 rounded-2xl shadow-sm border border-amber-200 hover:shadow-md transition-shadow relative overflow-hidden bg-gradient-to-br from-white to-amber-50/40">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold uppercase tracking-wider text-amber-700">Arsip Inaktif</p>
          <h3 id="stat-inaktif" class="text-3xl font-extrabold text-amber-800 mt-1">0</h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-amber-100 text-amber-700 flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
      </div>
      <div class="mt-3 flex items-center gap-1.5 text-xs text-amber-700 font-medium">
        <span class="inline-block w-2 h-2 rounded-full bg-amber-500"></span>
        Siap disimpan di depo/gudang simpan
      </div>
      <div class="absolute bottom-0 left-0 right-0 h-1 bg-amber-500"></div>
    </div>

    <!-- Siap Musnah -->
    <div class="glass-panel p-5 rounded-2xl shadow-sm border border-rose-200 hover:shadow-md transition-shadow relative overflow-hidden bg-gradient-to-br from-white to-rose-50/40">
      <div class="flex items-center justify-between">
        <div>
          <p class="text-xs font-semibold uppercase tracking-wider text-rose-700">Siap Musnah</p>
          <h3 id="stat-siap-musnah" class="text-3xl font-extrabold text-rose-800 mt-1">0</h3>
        </div>
        <div class="w-12 h-12 rounded-xl bg-rose-100 text-rose-700 flex items-center justify-center">
          <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
        </div>
      </div>
      <div class="mt-3 flex items-center gap-1.5 text-xs text-rose-700 font-semibold">
        <span class="inline-block w-2 h-2 rounded-full bg-rose-500 badge-pulse"></span>
        Melampaui JRA & perlu dinilai
      </div>
      <div class="absolute bottom-0 left-0 right-0 h-1 bg-rose-500"></div>
    </div>

  </section>

  <!-- KATEGORI PROGRESS SUMMARY STRIP -->
  <section class="glass-panel p-5 rounded-2xl border border-slate-200">
    <div class="text-xs font-bold uppercase tracking-wider text-slate-500 mb-3 flex items-center gap-2">
      <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 11h.01M7 15h.01M10 7h10M10 11h10M10 15h10"/></svg>
      Distribusi Berkas Berdasarkan 4 Pilar Kearsipan Program KB
    </div>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-xs">
      <a href="arsip.php?kategori=Pelayanan+Medik" class="p-4 bg-teal-50/70 hover:bg-teal-100/60 transition-colors border border-teal-200 rounded-xl group">
        <div class="font-bold text-teal-900 group-hover:text-teal-950">Pelayanan Medik KB</div>
        <div id="stat-cat-pelayanan" class="text-xl font-black text-teal-800 mt-1">0 Berkas</div>
        <div class="text-[11px] text-teal-600 mt-1">Kartu K/I/KB & Informed Consent</div>
      </a>
      <a href="arsip.php?kategori=Pendataan+%26+KIE" class="p-4 bg-sky-50/70 hover:bg-sky-100/60 transition-colors border border-sky-200 rounded-xl group">
        <div class="font-bold text-sky-900 group-hover:text-sky-950">Pendataan & KIE</div>
        <div id="stat-cat-kie" class="text-xl font-black text-sky-800 mt-1">0 Berkas</div>
        <div class="text-[11px] text-sky-600 mt-1">Basis Data Keluarga & Poktan</div>
      </a>
      <a href="arsip.php?kategori=Logistik+Alokon" class="p-4 bg-emerald-50/70 hover:bg-emerald-100/60 transition-colors border border-emerald-200 rounded-xl group">
        <div class="font-bold text-emerald-900 group-hover:text-emerald-950">Logistik Alokon</div>
        <div id="stat-cat-alokon" class="text-xl font-black text-emerald-800 mt-1">0 Berkas</div>
        <div class="text-[11px] text-emerald-600 mt-1">BAST & Mutasi Stok Gudang</div>
      </a>
      <a href="arsip.php?kategori=Administrasi+%26+Laporan" class="p-4 bg-indigo-50/70 hover:bg-indigo-100/60 transition-colors border border-indigo-200 rounded-xl group">
        <div class="font-bold text-indigo-900 group-hover:text-indigo-950">Administrasi & Laporan</div>
        <div id="stat-cat-laporan" class="text-xl font-black text-indigo-800 mt-1">0 Berkas</div>
        <div class="text-[11px] text-indigo-600 mt-1">Laporan F/II/KB & SPJ Dinas</div>
      </a>
    </div>
  </section>

  <!-- PANDUAN PENGOPERASIAN CEPAT -->
  <section class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
    <div class="glass-panel p-5 rounded-2xl border border-slate-200 flex flex-col justify-between">
      <div>
        <div class="w-10 h-10 rounded-xl bg-brand-100 text-brand-700 flex items-center justify-center font-bold mb-3">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        </div>
        <h4 class="font-bold text-slate-900 text-sm mb-1">Registrasi Berkas Baru</h4>
        <p class="text-slate-600 leading-relaxed">
          Input berkas fisik baru dengan sistem auto-nomor kearsipan dinas dan kalkulasi masa retensi otomatis.
        </p>
      </div>
      <button onclick="openAddModal()" class="mt-4 px-4 py-2 bg-brand-600 hover:bg-brand-700 text-white rounded-lg font-semibold text-center transition-colors">
        + Tambah Arsip Sekarang
      </button>
    </div>

    <div class="glass-panel p-5 rounded-2xl border border-slate-200 flex flex-col justify-between">
      <div>
        <div class="w-10 h-10 rounded-xl bg-sky-100 text-sky-700 flex items-center justify-center font-bold mb-3">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
        </div>
        <h4 class="font-bold text-slate-900 text-sm mb-1">Pedoman Jadwal Retensi (JRA)</h4>
        <p class="text-slate-600 leading-relaxed">
          Pelajari aturan masa aktif dan inaktif berkas pelayanan KB serta tata cara pemusnahan resmi sesuai ANRI.
        </p>
      </div>
      <a href="panduan.php" class="mt-4 px-4 py-2 bg-sky-600 hover:bg-sky-700 text-white rounded-lg font-semibold text-center transition-colors">
        Buka Panduan JRA
      </a>
    </div>

    <div class="glass-panel p-5 rounded-2xl border border-slate-200 flex flex-col justify-between">
      <div>
        <div class="w-10 h-10 rounded-xl bg-purple-100 text-purple-700 flex items-center justify-center font-bold mb-3">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
        </div>
        <h4 class="font-bold text-slate-900 text-sm mb-1">Cetak Rekapitulasi Dinas</h4>
        <p class="text-slate-600 leading-relaxed">
          Cetak format resmi daftar pertelaan arsip ber-kop surat resmi dinas (A4 Landscape) siap tanda tangan.
        </p>
      </div>
      <a href="rekapitulasi.php" class="mt-4 px-4 py-2 bg-purple-600 hover:bg-purple-700 text-white rounded-lg font-semibold text-center transition-colors">
        Cetak Laporan Resmi
      </a>
    </div>
  </section>

</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>

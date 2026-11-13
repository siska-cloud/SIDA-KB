<?php
/**
 * =========================================================================
 * HALAMAN REKAPITULASI & CETAK LAPORAN - SIDA-KB
 * =========================================================================
 */
$activePage = 'rekapitulasi';
$pageTitle = 'Rekapitulasi & Cetak Laporan | SIDA-KB';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">

  <!-- Print Controls (Screen Only) -->
  <div class="no-print glass-panel p-4 rounded-xl border border-slate-200 shadow-sm flex flex-wrap items-center justify-between gap-3">
    <div class="flex flex-wrap items-center gap-3 text-xs">
      <div>
        <label class="font-semibold text-slate-600 block mb-1">Filter Kategori Laporan:</label>
        <select id="print-filter-kategori" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white font-medium text-xs">
          <option value="Semua">Semua Kategori</option>
          <option value="Pelayanan Medik">Pelayanan Medik</option>
          <option value="Pendataan & KIE">Pendataan & KIE</option>
          <option value="Logistik Alokon">Logistik Alokon</option>
          <option value="Administrasi & Laporan">Administrasi & Laporan</option>
        </select>
      </div>
      <div>
        <label class="font-semibold text-slate-600 block mb-1">Filter Status Retensi:</label>
        <select id="print-filter-status" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white font-medium text-xs">
          <option value="Semua">Semua Status</option>
          <option value="Aktif">Aktif</option>
          <option value="Inaktif">Inaktif</option>
          <option value="Siap Musnah">Siap Musnah</option>
        </select>
      </div>
    </div>

    <button id="btn-print-action" class="px-5 py-2.5 bg-brand-700 hover:bg-brand-800 text-white rounded-xl text-xs font-bold flex items-center gap-2 shadow-sm transition-all transform active:scale-95">
      <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
      <span>Cetak / Simpan PDF Laporan</span>
    </button>
  </div>

  <!-- PRINTABLE PAGE WRAPPER (Styled for pristine A4 landscape output) -->
  <div class="print-page-wrapper bg-white p-8 rounded-2xl border border-slate-200 shadow-sm">
    
    <!-- Kop Surat Resmi -->
    <div class="print-kop text-center border-b-2 border-slate-900 pb-3 mb-6">
      <p class="text-xs uppercase tracking-widest font-bold text-slate-600">Pemerintah Kabupaten / Kota • Dinas Pengendalian Penduduk dan KB</p>
      <h2 class="text-xl font-extrabold uppercase tracking-tight text-slate-900 mt-1">Balai Penyuluhan Keluarga Berencana (KB)</h2>
      <p class="text-xs text-slate-600">Sistem Informasi &amp; Digitalisasi Kearsipan Program KB (SIDA-KB)</p>
      <div class="h-0.5 bg-slate-900 mt-2"></div>
    </div>

    <!-- Judul Laporan -->
    <div class="text-center mb-6">
      <h3 class="text-base font-black text-slate-900 uppercase">DAFTAR PERTELAAN DAN REKAPITULASI ARSIP PROGRAM KB</h3>
      <p class="text-xs text-slate-600 mt-0.5">Dicetak pada tanggal: <span id="print-date-report" class="font-semibold">-</span> • Total: <span id="print-total-count" class="font-bold">0</span> Berkas</p>
    </div>

    <!-- Tabel Formal Rekapitulasi -->
    <div class="overflow-x-auto">
      <table class="w-full text-left border-collapse border border-slate-300 text-xs">
        <thead>
          <tr class="bg-slate-100 text-slate-800 font-bold uppercase text-[10px]">
            <th class="border border-slate-300 p-2 text-center w-8">No</th>
            <th class="border border-slate-300 p-2 w-28">No. Arsip</th>
            <th class="border border-slate-300 p-2">Uraian / Judul Berkas</th>
            <th class="border border-slate-300 p-2 w-36">Kategori &amp; Sub</th>
            <th class="border border-slate-300 p-2 text-center w-24">Tgl Berkas</th>
            <th class="border border-slate-300 p-2 w-32">Lokasi Simpan</th>
            <th class="border border-slate-300 p-2 text-center w-16">Retensi</th>
            <th class="border border-slate-300 p-2 text-center w-24">Status</th>
          </tr>
        </thead>
        <tbody id="print-table-body" class="text-slate-800">
          <!-- Dynamically populated rows for print via JS -->
        </tbody>
      </table>
    </div>

    <!-- Lembar Tanda Tangan Formal -->
    <div class="print-signatures grid grid-cols-2 gap-8 text-center text-xs mt-12 pt-6">
      <div>
        <p class="text-slate-600">Mengetahui,</p>
        <p class="font-bold text-slate-900 mt-0.5">Koordinator Penyuluh KB / Ka. Balai</p>
        <div class="h-20"></div>
        <p class="font-bold underline text-slate-900">( .................................................... )</p>
        <p class="text-slate-500 text-[11px] mt-0.5">NIP. ....................................................</p>
      </div>
      <div>
        <p class="text-slate-600">Dibuat oleh,</p>
        <p class="font-bold text-slate-900 mt-0.5">Pengelola Arsip &amp; Dokumentasi KB</p>
        <div class="h-20"></div>
        <p class="font-bold underline text-slate-900">( .................................................... )</p>
        <p class="text-slate-500 text-[11px] mt-0.5">NIP. ....................................................</p>
      </div>
    </div>

  </div>

</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


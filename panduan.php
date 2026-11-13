<?php
/**
 * =========================================================================
 * HALAMAN PANDUAN KEARSIPAN KB (JRA) - SIDA-KB
 * =========================================================================
 */
$activePage = 'panduan';
$pageTitle = 'Panduan Kearsipan KB (JRA) | SIDA-KB';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">
  
  <!-- Header Banner Panduan -->
  <div class="glass-panel p-6 rounded-2xl border border-brand-200 bg-gradient-to-r from-emerald-900 to-brand-800 text-white shadow-sm">
    <div class="flex flex-col md:flex-row items-start md:items-center justify-between gap-4">
      <div>
        <span class="px-2.5 py-1 rounded bg-brand-700/80 text-[11px] font-bold uppercase tracking-wider text-brand-200 border border-brand-600">
          Standar Pedoman BKKBN &amp; ANRI
        </span>
        <h1 class="text-2xl font-black mt-2">Jadwal Retensi Arsip (JRA) Urusan Pengendalian Penduduk &amp; KB</h1>
        <p class="text-xs text-emerald-100 max-w-2xl mt-1 leading-relaxed">
          Panduan masa simpan aktif, inaktif, dan penentuan nasib akhir berkas kearsipan Program Keluarga Berencana pada Balai Penyuluhan KB, Puskesmas, dan Faskes Pelayanan KB.
        </p>
      </div>
      <div class="p-3 bg-white/10 rounded-xl backdrop-blur border border-white/20 text-center flex-shrink-0">
        <span class="block text-2xl font-black text-emerald-300">4 Pilar</span>
        <span class="text-[11px] text-emerald-100">Klasifikasi Arsip KB</span>
      </div>
    </div>
  </div>

  <!-- 4 Pilar Kearsipan Cards -->
  <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

    <!-- Pilar 1: Pelayanan Medik KB -->
    <div class="glass-panel p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-teal-100 text-teal-800 flex items-center justify-center font-bold">1</div>
        <div>
          <h3 class="font-bold text-slate-900 text-base">Pelayanan Medik KB</h3>
          <p class="text-xs text-slate-500">Masa Retensi: Aktif 5 Tahun, Inaktif 5 Tahun (Musnah/Permanen)</p>
        </div>
      </div>
      <p class="text-xs text-slate-600 leading-relaxed">
        Berkas rekam medis akseptor KB, dokumen informed consent tindakan operatif (Tubektomi/MOW &amp; Vasektomi/MOP), serta pemasangan alat kontrasepsi jangka panjang (MKJP: IUD &amp; Implan).
      </p>
      <div class="bg-teal-50/70 p-3 rounded-lg border border-teal-200 text-xs space-y-1.5">
        <div class="font-semibold text-teal-900">Jenis Dokumen Kunci:</div>
        <ul class="list-disc list-inside text-teal-800 space-y-0.5 text-[11px]">
          <li>Kartu Peserta KB (Formulir K/I/KB) &amp; Register Faskes (K/IV/KB)</li>
          <li>Surat Persetujuan Tindakan Medis Kontrasepsi (Informed Consent)</li>
          <li>Catatan Komplikasi Berat &amp; Kegagalan Kontrasepsi</li>
          <li>Surat Rujukan Akseptor ke Rumah Sakit Umum/Faskes Rujukan</li>
        </ul>
      </div>
    </div>

    <!-- Pilar 2: Pendataan & KIE -->
    <div class="glass-panel p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-sky-100 text-sky-800 flex items-center justify-center font-bold">2</div>
        <div>
          <h3 class="font-bold text-slate-900 text-base">Pendataan &amp; Komunikasi KIE</h3>
          <p class="text-xs text-slate-500">Masa Retensi: Aktif 3-5 Tahun, Inaktif 3 Tahun (Musnah/Statis)</p>
        </div>
      </div>
      <p class="text-xs text-slate-600 leading-relaxed">
        Arsip pendataan keluarga, profil Pasangan Usia Subur (PUS), kelompok kegiatan (Poktan BKB, BKR, BKL, UPPKA), serta data intervensi percepatan penurunan stunting (1000 HPK).
      </p>
      <div class="bg-sky-50/70 p-3 rounded-lg border border-sky-200 text-xs space-y-1.5">
        <div class="font-semibold text-sky-900">Jenis Dokumen Kunci:</div>
        <ul class="list-disc list-inside text-sky-800 space-y-0.5 text-[11px]">
          <li>Formulir Pemutakhiran Basis Data Keluarga Indonesia (R/I/KS &amp; PBDKI)</li>
          <li>Notulen Kegiatan Penyuluhan &amp; Daftar Hadir Pembinaan Poktan</li>
          <li>Rekapitulasi Sasaran Ibu Hamil &amp; Baduta Terindikasi Risiko Stunting</li>
          <li>Materi Modul Edukasi Kesehatan Reproduksi &amp; Pencegahan Pernikahan Dini</li>
        </ul>
      </div>
    </div>

    <!-- Pilar 3: Logistik Alokon -->
    <div class="glass-panel p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-emerald-100 text-emerald-800 flex items-center justify-center font-bold">3</div>
        <div>
          <h3 class="font-bold text-slate-900 text-base">Logistik &amp; Alat Kontrasepsi (Alokon)</h3>
          <p class="text-xs text-slate-500">Masa Retensi: Aktif 5 Tahun, Inaktif 5 Tahun (Musnah)</p>
        </div>
      </div>
      <p class="text-xs text-slate-600 leading-relaxed">
        Dokumentasi rantai pasok alokon program, penerimaan dari Gudang Farmasi Kabupaten/Kota, distribusi ke Faskes/Bidan Praktik Mandiri, serta berita acara penghapusan alokon kedaluwarsa.
      </p>
      <div class="bg-emerald-50/70 p-3 rounded-lg border border-emerald-200 text-xs space-y-1.5">
        <div class="font-semibold text-emerald-900">Jenis Dokumen Kunci:</div>
        <ul class="list-disc list-inside text-emerald-800 space-y-0.5 text-[11px]">
          <li>Berita Acara Serah Terima (BAST) Alokon DAK &amp; APBN</li>
          <li>Surat Bukti Barang Keluar/Masuk (SBBK) Gudang Balai KB</li>
          <li>Kartu Kendali Stok Fisik (Pil, Kondom, Suntik, IUD, Implan)</li>
          <li>Berita Acara Pemusnahan Alokon Rusak atau Kedaluwarsa</li>
        </ul>
      </div>
    </div>

    <!-- Pilar 4: Administrasi & Pelaporan -->
    <div class="glass-panel p-5 rounded-2xl border border-slate-200 shadow-sm space-y-3">
      <div class="flex items-center gap-3">
        <div class="w-10 h-10 rounded-lg bg-indigo-100 text-indigo-800 flex items-center justify-center font-bold">4</div>
        <div>
          <h3 class="font-bold text-slate-900 text-base">Administrasi &amp; Laporan Kearsipan</h3>
          <p class="text-xs text-slate-500">Masa Retensi: Aktif 5 Tahun, Inaktif 5-10 Tahun (Musnah)</p>
        </div>
      </div>
      <p class="text-xs text-slate-600 leading-relaxed">
        Laporan bulanan pelayanan kontrasepsi tingkat kecamatan, berkas pertanggungjawaban operasional BOKB, SK pembentukan Tim Pendamping Keluarga (TPK), dan evaluasi capaian Program Bangga Kencana.
      </p>
      <div class="bg-indigo-50/70 p-3 rounded-lg border border-indigo-200 text-xs space-y-1.5">
        <div class="font-semibold text-indigo-900">Jenis Dokumen Kunci:</div>
        <ul class="list-disc list-inside text-indigo-800 space-y-0.5 text-[11px]">
          <li>Formulir F/II/KB (Laporan Bulanan Pelayanan Kontrasepsi Kecamatan)</li>
          <li>Surat Pertanggungjawaban (SPJ) Belanja Operasional KB &amp; KIE Keliling</li>
          <li>SK Tim Pendamping Keluarga (Bidan, Kader PKK, Kader KB)</li>
          <li>Laporan Tahunan Evaluasi Capaian Program Bangga Kencana</li>
        </ul>
      </div>
    </div>

  </div>

  <!-- Prosedur Pemusnahan Arsip Standar ANRI -->
  <div class="glass-panel p-6 rounded-2xl border border-slate-200 space-y-4 shadow-sm">
    <h3 class="text-base font-bold text-slate-900 flex items-center gap-2">
      <svg class="w-5 h-5 text-rose-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
      Prosedur Pemusnahan Arsip Program KB yang Berstatus "Siap Musnah"
    </h3>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-4 text-xs">
      <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
        <div class="font-bold text-slate-800 mb-1 text-sm">Langkah 1: Penilaian &amp; Pertelaan</div>
        <p class="text-slate-600 leading-relaxed">
          Unit pengelola kearsipan menyusun Daftar Pertelaan Arsip yang telah habis masa retensinya dan tidak memiliki nilai guna primer maupun sekunder.
        </p>
      </div>
      <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
        <div class="font-bold text-slate-800 mb-1 text-sm">Langkah 2: Pembentukan Tim &amp; SK</div>
        <p class="text-slate-600 leading-relaxed">
          Kepala Dinas/Instansi menerbitkan SK Tim Penilai dan Pemusnah Arsip yang beranggotakan pengelola arsip, unsur hukum, dan pengawas internal.
        </p>
      </div>
      <div class="p-4 bg-slate-50 rounded-xl border border-slate-200">
        <div class="font-bold text-slate-800 mb-1 text-sm">Langkah 3: BAPA &amp; Pencacahan</div>
        <p class="text-slate-600 leading-relaxed">
          Pemusnahan dilakukan dengan cara dicacah/dilebur total, disaksikan oleh para saksi dan dituangkan dalam Berita Acara Pemusnahan Arsip (BAPA).
        </p>
      </div>
    </div>
  </div>

</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


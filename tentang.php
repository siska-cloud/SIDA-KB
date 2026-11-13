<?php
/**
 * =========================================================================
 * HALAMAN TENTANG APLIKASI - SIDA-KB
 * =========================================================================
 */
$activePage = 'tentang';
$pageTitle = 'Tentang SIDA-KB | SIDA-KB';
require_once __DIR__ . '/includes/header.php';
require_once __DIR__ . '/includes/navbar.php';
?>

<main class="flex-1 max-w-7xl w-full mx-auto px-4 sm:px-6 lg:px-8 py-6 space-y-6">
  
  <div class="glass-panel p-6 sm:p-8 rounded-2xl border border-slate-200 space-y-6 shadow-sm">
    
    <div class="flex items-center gap-4">
      <div class="w-14 h-14 rounded-2xl bg-gradient-to-tr from-brand-700 to-emerald-500 text-white flex items-center justify-center font-black text-2xl shadow-md shadow-brand-500/20 ring-2 ring-brand-100 flex-shrink-0">
        KB
      </div>
      <div>
        <div class="flex items-center gap-2">
          <h1 class="text-2xl font-black text-slate-900">Tentang Aplikasi SIDA-KB</h1>
          <span class="px-2 py-0.5 text-[10px] font-bold tracking-wider uppercase bg-brand-100 text-brand-800 rounded-md border border-brand-200">BKKBN Standard</span>
        </div>
        <p class="text-xs text-slate-500 mt-0.5">Sistem Informasi &amp; Digitalisasi Kearsipan Program Keluarga Berencana</p>
      </div>
    </div>

    <div class="text-xs text-slate-600 leading-relaxed space-y-3 border-t border-b border-slate-100 py-4">
      <p>
        <strong>SIDA-KB</strong> merupakan aplikasi kearsipan mandiri yang dirancang khusus untuk memfasilitasi pendataan, penataan fisik, pengendalian masa retensi, dan digitalisasi kearsipan program Keluarga Berencana di lingkungan Dinas PPKB, Balai Penyuluhan KB, Puskesmas, dan Faskes jejaring.
      </p>
      <p>
        Aplikasi ini dibangun dengan arsitektur <strong>PHP Native</strong> murni yang ringan, terstruktur rapi, dan siap diunggah langsung ke berbagai layanan shared hosting seperti <strong>InfinityFree</strong> atau cPanel tanpa memerlukan dependensi Node.js, Composer, ataupun perintah terminal di server hosting.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
      <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs space-y-1.5">
        <div class="w-8 h-8 rounded-lg bg-emerald-100 text-emerald-700 flex items-center justify-center font-bold mb-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 12h14M12 5l7 7-7 7"/></svg>
        </div>
        <span class="font-bold text-slate-800 block text-sm">Teknologi Backend</span>
        <p class="text-slate-600 leading-relaxed">
          PHP Native (PDO MySQL), arsitektur modular tanpa framework rumit, ringan, dan kompatibel penuh dengan InfinityFree &amp; cPanel.
        </p>
      </div>

      <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs space-y-1.5">
        <div class="w-8 h-8 rounded-lg bg-sky-100 text-sky-700 flex items-center justify-center font-bold mb-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.75 17L9 20l-1 1h8l-1-1-.75-3M3 13h18M5 17h14a2 2 0 002-2V5a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
        </div>
        <span class="font-bold text-slate-800 block text-sm">Teknologi Frontend</span>
        <p class="text-slate-600 leading-relaxed">
          HTML5 Semantic, Vanilla JavaScript Native SPA/MPA, Tailwind CSS via CDN dengan palet Emerald Green &amp; Slate Grey.
        </p>
      </div>

      <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 text-xs space-y-1.5">
        <div class="w-8 h-8 rounded-lg bg-indigo-100 text-indigo-700 flex items-center justify-center font-bold mb-2">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
        </div>
        <span class="font-bold text-slate-800 block text-sm">Kepatuhan Standar</span>
        <p class="text-slate-600 leading-relaxed">
          Mengacu pada Jadwal Retensi Arsip (JRA) Urusan Pengendalian Penduduk &amp; KB, standar resmi ANRI dan BKKBN.
        </p>
      </div>
    </div>

  </div>

</main>

<?php require_once __DIR__ . '/includes/footer.php'; ?>


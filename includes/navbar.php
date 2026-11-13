<?php
/**
 * =========================================================================
 * NAVBAR TEMPLATE - SIDA-KB
 * =========================================================================
 */
if (!isset($activePage)) {
    $activePage = 'dashboard';
}

function getNavLinkClass($pageName, $activePage) {
    if ($pageName === $activePage) {
        return 'bg-brand-700 text-white shadow-sm';
    }
    return 'text-slate-600 hover:bg-slate-100';
}
?>
  <!-- ================= TOP HEADER & NAVBAR ================= -->
  <header class="glass-nav sticky top-0 z-30 shadow-sm border-b border-slate-200">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
      <div class="flex items-center justify-between h-20">
        
        <!-- Logo & Branding -->
        <a href="index.php" class="flex items-center gap-3.5 group">
          <div class="w-12 h-12 rounded-xl bg-gradient-to-tr from-brand-700 to-emerald-500 flex items-center justify-center text-white shadow-md shadow-brand-500/20 ring-2 ring-brand-100 flex-shrink-0 transition-transform group-hover:scale-105">
            <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/>
            </svg>
          </div>
          <div>
            <div class="flex items-center gap-2">
              <span class="text-2xl font-black tracking-tight text-slate-900">SIDA<span class="text-brand-600">-KB</span></span>
              <span class="px-2 py-0.5 text-[10px] font-bold tracking-wider uppercase bg-brand-100 text-brand-800 rounded-md border border-brand-200">BKKBN</span>
            </div>
            <p class="text-xs font-medium text-slate-500 leading-tight">Sistem Informasi & Digitalisasi Kearsipan Program KB</p>
          </div>
        </a>

        <!-- Live Clock -->
        <div class="hidden lg:flex items-center gap-4 text-xs">
          <div class="flex items-center gap-2 px-3 py-1.5 rounded-lg bg-slate-100 text-slate-700 font-medium border border-slate-200">
            <svg class="w-4 h-4 text-brand-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span id="live-clock">Memuat jam...</span>
          </div>
        </div>

        <!-- Primary Action Button -->
        <div class="flex items-center gap-2.5">
          <button id="btn-quick-add" class="inline-flex items-center gap-2 px-4 py-2.5 rounded-xl bg-brand-600 hover:bg-brand-700 active:bg-brand-800 text-white font-semibold text-sm shadow-sm shadow-brand-600/30 transition-all transform active:scale-95 focus:outline-none focus:ring-2 focus:ring-brand-500 focus:ring-offset-2">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            <span>Tambah Arsip</span>
          </button>
        </div>

      </div>

      <!-- Navigation Tabs Bar -->
      <nav class="flex items-center space-x-1 border-t border-slate-200 pt-1 pb-2 overflow-x-auto no-scrollbar">
        <a href="index.php" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold rounded-lg transition-colors <?= getNavLinkClass('dashboard', $activePage) ?>">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
          <span>Dashboard</span>
        </a>
        <a href="arsip.php" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold rounded-lg transition-colors <?= getNavLinkClass('arsip', $activePage) ?>">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
          <span>Data Arsip</span>
        </a>
        <a href="panduan.php" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold rounded-lg transition-colors <?= getNavLinkClass('panduan', $activePage) ?>">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
          <span>Panduan Kearsipan KB (JRA)</span>
        </a>
        <a href="rekapitulasi.php" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold rounded-lg transition-colors <?= getNavLinkClass('rekapitulasi', $activePage) ?>">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
          <span>Rekapitulasi & Cetak Laporan</span>
        </a>
        <a href="tentang.php" class="flex items-center gap-2 px-4 py-2 text-xs font-semibold rounded-lg transition-colors <?= getNavLinkClass('tentang', $activePage) ?>">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          <span>Tentang SIDA-KB</span>
        </a>
      </nav>

    </div>
  </header>


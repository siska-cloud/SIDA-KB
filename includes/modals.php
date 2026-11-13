<?php
/**
 * =========================================================================
 * MODALS & TOAST CONTAINER - SIDA-KB
 * =========================================================================
 */
?>
  <!-- ================= MODAL: TAMBAH / EDIT ARSIP ================= -->
  <div id="modal-arsip" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <!-- Backdrop -->
    <div class="modal-overlay fixed inset-0 bg-slate-900/60 backdrop-blur-sm opacity-0 transition-opacity"></div>

    <!-- Modal Container -->
    <div class="modal-container relative bg-white w-full max-w-2xl mx-4 rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform scale-95 opacity-0 transition-all max-h-[92vh] flex flex-col z-10">
      
      <!-- Modal Header -->
      <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
        <div class="flex items-center gap-2.5">
          <div class="p-2 bg-brand-100 text-brand-700 rounded-lg">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
          </div>
          <h3 id="modal-arsip-title" class="text-base font-bold text-slate-900">Tambah Arsip KB Baru</h3>
        </div>
        <button id="btn-close-modal-arsip" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-200 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <!-- Modal Body (Form) -->
      <form id="form-arsip" class="p-6 overflow-y-auto space-y-4 text-xs">
        
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <!-- No Arsip -->
          <div>
            <label class="block font-semibold text-slate-700 mb-1">No. Arsip / Berkas</label>
            <input type="text" id="form-no-arsip" placeholder="contoh: KB/2026/001" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 font-mono font-semibold text-emerald-800">
            <span class="text-[11px] text-slate-400">Kosongkan jika ingin auto-generate</span>
          </div>

          <!-- Tanggal Berkas -->
          <div>
            <label class="block font-semibold text-slate-700 mb-1">Tanggal Arsip <span class="text-rose-500">*</span></label>
            <input type="date" id="form-tanggal" required class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500">
          </div>
        </div>

        <!-- Judul Berkas -->
        <div>
          <label class="block font-semibold text-slate-700 mb-1">Judul / Uraian Berkas Arsip <span class="text-rose-500">*</span></label>
          <input type="text" id="form-judul" required placeholder="contoh: Kartu Peserta KB (K/I/KB) Implan Ny. Rahmawati" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 text-sm">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
          <!-- Kategori -->
          <div>
            <label class="block font-semibold text-slate-700 mb-1">Kategori Arsip <span class="text-rose-500">*</span></label>
            <select id="form-kategori" required class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white">
              <option value="Pelayanan Medik">Pelayanan Medik</option>
              <option value="Pendataan & KIE">Pendataan & KIE</option>
              <option value="Logistik Alokon">Logistik Alokon</option>
              <option value="Administrasi & Laporan">Administrasi & Laporan</option>
            </select>
          </div>

          <!-- Sub-Kategori -->
          <div>
            <label class="block font-semibold text-slate-700 mb-1">Sub-Kategori</label>
            <select id="form-sub-kategori" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white">
              <!-- Dynamically populated based on Kategori -->
            </select>
          </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
          <!-- Lokasi Fisik Simpan -->
          <div>
            <label class="block font-semibold text-slate-700 mb-1">Lokasi Fisik <span class="text-rose-500">*</span></label>
            <input type="text" id="form-lokasi" required placeholder="contoh: Rak A1 - Boks 02" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500">
          </div>

          <!-- Masa Retensi (Tahun) -->
          <div>
            <label class="block font-semibold text-slate-700 mb-1">Masa Retensi (Tahun)</label>
            <input type="number" id="form-masa-retensi" min="1" max="50" value="5" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500">
          </div>

          <!-- Status Retensi -->
          <div>
            <label class="block font-semibold text-slate-700 mb-1">Status Retensi</label>
            <select id="form-status-retensi" class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500 bg-white">
              <option value="Aktif">Aktif</option>
              <option value="Inaktif">Inaktif</option>
              <option value="Siap Musnah">Siap Musnah</option>
            </select>
          </div>
        </div>

        <!-- Intelligent Auto-Suggestion Hint -->
        <div id="retensi-suggestion-hint"></div>

        <!-- Deskripsi / Ringkasan Isi -->
        <div>
          <label class="block font-semibold text-slate-700 mb-1">Deskripsi / Ringkasan Isi Berkas</label>
          <textarea id="form-deskripsi" rows="3" placeholder="Uraikan rincian berkas, keterangan kondisi fisik, jumlah lembar, atau catatan penting lainnya..." class="w-full px-3 py-2 rounded-lg border border-slate-300 focus:outline-none focus:ring-2 focus:ring-brand-500"></textarea>
        </div>

        <!-- Form Actions -->
        <div class="pt-4 border-t border-slate-200 flex items-center justify-end gap-2">
          <button type="button" id="btn-cancel-arsip" class="px-4 py-2 rounded-lg border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 font-medium transition-colors">
            Batal
          </button>
          <button type="submit" class="px-5 py-2 rounded-lg bg-brand-600 hover:bg-brand-700 text-white font-semibold shadow-sm transition-colors flex items-center gap-2">
            <span>Simpan Data Arsip</span>
          </button>
        </div>

      </form>

    </div>
  </div>

  <!-- ================= MODAL: DETAIL ARSIP ================= -->
  <div id="modal-detail" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="modal-overlay fixed inset-0 bg-slate-900/60 backdrop-blur-sm opacity-0 transition-opacity"></div>
    <div class="modal-container relative bg-white w-full max-w-xl mx-4 rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform scale-95 opacity-0 transition-all max-h-[90vh] flex flex-col z-10">
      
      <div class="px-6 py-4 bg-slate-50 border-b border-slate-200 flex items-center justify-between">
        <div class="flex items-center gap-2">
          <span class="px-2.5 py-0.5 rounded bg-brand-100 text-brand-800 text-xs font-mono font-bold" id="detail-no-arsip">-</span>
          <span id="detail-status-badge"></span>
        </div>
        <button id="btn-close-detail" class="p-1 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-200 transition-colors">
          <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
      </div>

      <div class="p-6 overflow-y-auto space-y-5 text-xs">
        <div>
          <h3 id="detail-judul" class="text-base font-bold text-slate-900 leading-snug">-</h3>
          <p id="detail-sub-kategori" class="text-xs text-brand-700 font-semibold mt-1">-</p>
        </div>

        <!-- Barcode Label Simulator for physical filing box -->
        <div class="p-4 rounded-xl bg-slate-50 border border-slate-200 flex flex-col items-center justify-center text-center">
          <div class="barcode-box mb-2"></div>
          <div id="detail-barcode-text" class="font-mono text-xs font-bold text-slate-800 tracking-wider">KB/2026/001</div>
          <span class="text-[10px] text-slate-400 mt-0.5">Label Kearsipan Fisik Balai KB</span>
        </div>

        <div class="grid grid-cols-2 gap-3 p-4 rounded-xl bg-slate-50 border border-slate-200">
          <div>
            <span class="text-slate-400 block text-[11px]">Kategori Dokumen:</span>
            <span id="detail-kategori" class="font-semibold text-slate-800">-</span>
          </div>
          <div>
            <span class="text-slate-400 block text-[11px]">Tanggal Berkas:</span>
            <span id="detail-tanggal" class="font-semibold text-slate-800">-</span>
          </div>
          <div>
            <span class="text-slate-400 block text-[11px]">Lokasi Simpan Fisik:</span>
            <span id="detail-lokasi" class="font-semibold text-slate-800">-</span>
          </div>
          <div>
            <span class="text-slate-400 block text-[11px]">Masa Retensi:</span>
            <span id="detail-masa-retensi" class="font-semibold text-slate-800">-</span>
          </div>
          <div class="col-span-2">
            <span class="text-slate-400 block text-[11px]">Waktu Digitalisasi Sistem:</span>
            <span id="detail-created-at" class="font-medium text-slate-600">-</span>
          </div>
        </div>

        <div>
          <span class="font-semibold text-slate-700 block mb-1">Uraian / Ringkasan Isi Berkas:</span>
          <div id="detail-deskripsi" class="p-3 bg-slate-50 border border-slate-200 rounded-lg text-slate-700 leading-relaxed whitespace-pre-wrap">
            -
          </div>
        </div>

      </div>

      <div class="px-6 py-3 bg-slate-50 border-t border-slate-200 flex items-center justify-between">
        <button id="btn-print-label" class="px-3 py-1.5 rounded-lg border border-slate-300 bg-white text-slate-700 hover:bg-slate-100 font-medium text-xs flex items-center gap-1.5 transition-colors">
          <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 17h2a2 2 0 002-2v-4a2 2 0 00-2-2H5a2 2 0 00-2 2v4a2 2 0 002 2h2m2 4h6a2 2 0 002-2v-4a2 2 0 00-2-2H9a2 2 0 00-2 2v4a2 2 0 002 2zm8-12V5a2 2 0 00-2-2H9a2 2 0 00-2 2v4h10z"/></svg>
          <span>Cetak Label Berkas</span>
        </button>

        <button id="btn-edit-from-detail" class="px-4 py-1.5 rounded-lg bg-blue-600 hover:bg-blue-700 text-white font-semibold text-xs flex items-center gap-1.5 transition-colors">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
          <span>Edit Arsip Ini</span>
        </button>
      </div>

    </div>
  </div>

  <!-- ================= MODAL: KONFIRMASI HAPUS ================= -->
  <div id="modal-delete" class="fixed inset-0 z-50 flex items-center justify-center hidden">
    <div class="modal-overlay fixed inset-0 bg-slate-900/60 backdrop-blur-sm opacity-0 transition-opacity"></div>
    <div class="modal-container relative bg-white w-full max-w-md mx-4 rounded-2xl shadow-2xl border border-slate-200 overflow-hidden transform scale-95 opacity-0 transition-all p-6 text-center z-10">
      
      <div class="w-14 h-14 mx-auto rounded-full bg-rose-100 text-rose-600 flex items-center justify-center mb-4">
        <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
      </div>

      <h3 class="text-base font-bold text-slate-900 mb-1">Konfirmasi Penghapusan Arsip</h3>
      <p class="text-xs text-slate-500 mb-3">Apakah Anda yakin ingin menghapus data arsip berikut dari sistem?</p>

      <div class="p-3 bg-slate-50 border border-slate-200 rounded-lg text-xs font-semibold text-slate-800 mb-5 break-words">
        <span id="delete-item-title">-</span>
      </div>

      <div class="flex items-center justify-center gap-3 text-xs">
        <button id="btn-cancel-delete" class="px-4 py-2 rounded-lg border border-slate-300 bg-white text-slate-700 hover:bg-slate-50 font-medium transition-colors">
          Batal
        </button>
        <button id="btn-confirm-delete" class="px-5 py-2 rounded-lg bg-rose-600 hover:bg-rose-700 text-white font-semibold transition-colors shadow-sm">
          Ya, Hapus Arsip
        </button>
      </div>

    </div>
  </div>

  <!-- ================= FLOATING TOAST CONTAINER ================= -->
  <div id="toast-container" class="fixed bottom-5 right-5 z-50 flex flex-col gap-2 max-w-sm w-full pointer-events-none *:pointer-events-auto"></div>


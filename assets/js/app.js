/**
 * Application Controller for SIDA-KB (Sistem Informasi & Digitalisasi Kearsipan Program KB)
 */

document.addEventListener('DOMContentLoaded', () => {
  // Global State
  const state = {
    arsipList: [],
    stats: null,
    filters: {
      search: '',
      kategori: 'Semua',
      status_retensi: 'Semua'
    },
    activeTab: 'arsip',
    editingId: null,
    deletingId: null,
    searchDebounceTimer: null
  };

  // Sub-category dictionary based on BKKBN archive classification
  const SUB_KATEGORI_MAP = {
    'Pelayanan Medik': [
      'Kartu Peserta KB (K/I/KB)',
      'Informed Consent',
      'Rekam Medik & Tindakan Alokon',
      'Surat Rujukan Medis KB',
      'Laporan Komplikasi & Efek Samping'
    ],
    'Pendataan & KIE': [
      'Basis Data Keluarga (R/I/KS)',
      'Materi & Notulen KIE',
      'Laporan Poktan BKB / BKR / BKL / UPPKA',
      'Data Sasaran 1000 HPK & Stunting',
      'Dokumentasi Penyuluhan KB'
    ],
    'Logistik Alokon': [
      'BAST Alokon',
      'Kartu Stok Alokon',
      'Surat Bukti Barang Keluar/Masuk (SBBK)',
      'Laporan Distribusi Alokon Faskes',
      'Berita Acara Alokon Kedaluwarsa'
    ],
    'Administrasi & Laporan': [
      'Laporan Bulanan (F/II/KB)',
      'SPJ Operasional',
      'SK Tim Pendamping Keluarga (TPK)',
      'Surat Keputusan (SK) Balai KB',
      'Laporan Tahunan Kearsipan'
    ]
  };

  // DOM Elements
  const el = {
    // Navigation Tabs
    tabButtons: document.querySelectorAll('.nav-tab-btn'),
    tabContents: document.querySelectorAll('.tab-content'),

    // Live Clock & Status
    liveClock: document.getElementById('live-clock'),
    systemStatusBadge: document.getElementById('system-status-badge'),

    // Stats Counters
    statTotal: document.getElementById('stat-total'),
    statAktif: document.getElementById('stat-aktif'),
    statInaktif: document.getElementById('stat-inaktif'),
    statSiapMusnah: document.getElementById('stat-siap-musnah'),
    statCatPelayanan: document.getElementById('stat-cat-pelayanan'),
    statCatKie: document.getElementById('stat-cat-kie'),
    statCatAlokon: document.getElementById('stat-cat-alokon'),
    statCatLaporan: document.getElementById('stat-cat-laporan'),

    // Filters & Search
    searchInput: document.getElementById('search-input'),
    filterKategori: document.getElementById('filter-kategori'),
    filterStatus: document.getElementById('filter-status'),
    btnResetFilter: document.getElementById('btn-reset-filter'),
    tableCountBadge: document.getElementById('table-count-badge'),

    // Table
    arsipTableBody: document.getElementById('arsip-table-body'),
    tableLoading: document.getElementById('table-loading'),
    tableEmpty: document.getElementById('table-empty'),

    // Buttons
    btnOpenAddModal: document.getElementById('btn-open-add-modal'),
    btnQuickAdd: document.getElementById('btn-quick-add'),
    btnOpenPrintTab: document.getElementById('btn-open-print-tab'),

    // Form Modal
    modalArsip: document.getElementById('modal-arsip'),
    modalTitle: document.getElementById('modal-arsip-title'),
    formArsip: document.getElementById('form-arsip'),
    btnCancelArsip: document.getElementById('btn-cancel-arsip'),
    btnCloseModalArsip: document.getElementById('btn-close-modal-arsip'),
    formNoArsip: document.getElementById('form-no-arsip'),
    formJudul: document.getElementById('form-judul'),
    formKategori: document.getElementById('form-kategori'),
    formSubKategori: document.getElementById('form-sub-kategori'),
    formTanggal: document.getElementById('form-tanggal'),
    formLokasi: document.getElementById('form-lokasi'),
    formMasaRetensi: document.getElementById('form-masa-retensi'),
    formStatusRetensi: document.getElementById('form-status-retensi'),
    formDeskripsi: document.getElementById('form-deskripsi'),
    retensiSuggestionHint: document.getElementById('retensi-suggestion-hint'),

    // Detail Modal
    modalDetail: document.getElementById('modal-detail'),
    btnCloseDetail: document.getElementById('btn-close-detail'),
    btnEditFromDetail: document.getElementById('btn-edit-from-detail'),
    detailNoArsip: document.getElementById('detail-no-arsip'),
    detailJudul: document.getElementById('detail-judul'),
    detailKategori: document.getElementById('detail-kategori'),
    detailSubKategori: document.getElementById('detail-sub-kategori'),
    detailTanggal: document.getElementById('detail-tanggal'),
    detailLokasi: document.getElementById('detail-lokasi'),
    detailMasaRetensi: document.getElementById('detail-masa-retensi'),
    detailStatusBadge: document.getElementById('detail-status-badge'),
    detailDeskripsi: document.getElementById('detail-deskripsi'),
    detailCreatedAt: document.getElementById('detail-created-at'),
    detailBarcodeText: document.getElementById('detail-barcode-text'),
    btnPrintLabel: document.getElementById('btn-print-label'),

    // Delete Modal
    modalDelete: document.getElementById('modal-delete'),
    btnCancelDelete: document.getElementById('btn-cancel-delete'),
    btnConfirmDelete: document.getElementById('btn-confirm-delete'),
    deleteItemTitle: document.getElementById('delete-item-title'),

    // Print & Report Section
    printFilterKategori: document.getElementById('print-filter-kategori'),
    printFilterStatus: document.getElementById('print-filter-status'),
    btnPrintAction: document.getElementById('btn-print-action'),
    printTableBody: document.getElementById('print-table-body'),
    printTotalCount: document.getElementById('print-total-count'),
    printDateReport: document.getElementById('print-date-report'),

    // Toast Container
    toastContainer: document.getElementById('toast-container')
  };

  // Toast Notification System
  function showToast(message, type = 'success') {
    const toast = document.createElement('div');
    const bgColors = {
      success: 'bg-emerald-600 text-white border-emerald-700',
      error: 'bg-rose-600 text-white border-rose-700',
      info: 'bg-slate-800 text-white border-slate-900',
      warning: 'bg-amber-600 text-white border-amber-700'
    };

    const icons = {
      success: `<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>`,
      error: `<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>`,
      info: `<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>`,
      warning: `<svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>`
    };

    toast.className = `flex items-center gap-3 px-4 py-3 rounded-lg shadow-lg border text-sm transition-all duration-300 transform translate-y-2 opacity-0 ${bgColors[type] || bgColors.info}`;
    toast.innerHTML = `
      ${icons[type] || icons.info}
      <span class="flex-1 font-medium">${message}</span>
      <button class="text-white hover:opacity-75 focus:outline-none" onclick="this.parentElement.remove()">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
      </button>
    `;

    el.toastContainer.appendChild(toast);

    // Animation in
    requestAnimationFrame(() => {
      toast.classList.remove('translate-y-2', 'opacity-0');
    });

    // Auto dismiss after 4 seconds
    setTimeout(() => {
      toast.classList.add('opacity-0', 'translate-y-2');
      setTimeout(() => toast.remove(), 300);
    }, 4000);
  }

  // Realtime Indonesian Clock
  function initClock() {
    function update() {
      const now = new Date();
      const options = {
        weekday: 'long',
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      };
      const dateStr = now.toLocaleDateString('id-ID', options);
      const timeStr = now.toLocaleTimeString('id-ID', { hour12: false });
      if (el.liveClock) {
        el.liveClock.textContent = `${dateStr} • ${timeStr} WIB`;
      }
      if (el.printDateReport) {
        el.printDateReport.textContent = dateStr;
      }
    }
    update();
    setInterval(update, 1000);
  }

  // Tab Navigation Handling
  function initTabs() {
    el.tabButtons.forEach(btn => {
      btn.addEventListener('click', () => {
        const targetTab = btn.getAttribute('data-tab');
        switchTab(targetTab);
      });
    });
  }

  function switchTab(tabId) {
    state.activeTab = tabId;
    el.tabButtons.forEach(btn => {
      const isTarget = btn.getAttribute('data-tab') === tabId;
      if (isTarget) {
        btn.classList.add('bg-emerald-700', 'text-white', 'shadow-sm');
        btn.classList.remove('text-slate-600', 'hover:bg-slate-100');
      } else {
        btn.classList.remove('bg-emerald-700', 'text-white', 'shadow-sm');
        btn.classList.add('text-slate-600', 'hover:bg-slate-100');
      }
    });

    el.tabContents.forEach(content => {
      if (content.id === `tab-${tabId}`) {
        content.classList.add('active');
      } else {
        content.classList.remove('active');
      }
    });

    if (tabId === 'rekap') {
      renderPrintTable();
    }
  }

  // Load Statistics
  async function loadStats() {
    try {
      const res = await API.getStats();
      if (res && res.success) {
        state.stats = res.data;
        updateStatsUI(res.data);
      }
    } catch (err) {
      console.error('Failed to load stats:', err);
    }
  }

  function updateStatsUI(stats) {
    if (!stats) return;

    if (el.statTotal) el.statTotal.textContent = stats.total || 0;
    if (el.statAktif) el.statAktif.textContent = stats.aktifCount || 0;
    if (el.statInaktif) el.statInaktif.textContent = stats.inaktifCount || 0;
    if (el.statSiapMusnah) el.statSiapMusnah.textContent = stats.siapMusnahCount || 0;

    const perKategori = stats.perKategori || {};
    if (el.statCatPelayanan) el.statCatPelayanan.textContent = `${perKategori['Pelayanan Medik'] || 0} Berkas`;
    if (el.statCatKie) el.statCatKie.textContent = `${perKategori['Pendataan & KIE'] || 0} Berkas`;
    if (el.statCatAlokon) el.statCatAlokon.textContent = `${perKategori['Logistik Alokon'] || 0} Berkas`;
    if (el.statCatLaporan) el.statCatLaporan.textContent = `${perKategori['Administrasi & Laporan'] || 0} Berkas`;
  }

  // Load and Render Archive List
  async function loadArsip() {
    if (!el.arsipTableBody) return;
    try {
      if (el.tableLoading) el.tableLoading.classList.remove('hidden');
      if (el.tableEmpty) el.tableEmpty.classList.add('hidden');
      el.arsipTableBody.innerHTML = '';

      const res = await API.getArsip(state.filters);
      if (res && res.success) {
        state.arsipList = res.data || [];
        renderTable(state.arsipList);
        if (el.tableCountBadge) {
          el.tableCountBadge.textContent = `Menampilkan ${state.arsipList.length} arsip`;
        }
      }
    } catch (err) {
      showToast('Gagal memuat data arsip: ' + err.message, 'error');
    } finally {
      if (el.tableLoading) el.tableLoading.classList.add('hidden');
    }
  }

  // Render Table Rows
  function renderTable(items) {
    el.arsipTableBody.innerHTML = '';

    if (!items || items.length === 0) {
      if (el.tableEmpty) el.tableEmpty.classList.remove('hidden');
      return;
    }

    if (el.tableEmpty) el.tableEmpty.classList.add('hidden');

    items.forEach((item, index) => {
      const tr = document.createElement('tr');
      tr.className = 'border-b border-slate-100 hover:bg-emerald-50/40 transition-colors text-sm';

      // Status Badge Style
      let statusBadge = '';
      if (item.status_retensi === 'Aktif') {
        statusBadge = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-emerald-100 text-emerald-800 border border-emerald-300">
          <span class="w-1.5 h-1.5 mr-1.5 bg-emerald-600 rounded-full"></span>Aktif
        </span>`;
      } else if (item.status_retensi === 'Inaktif') {
        statusBadge = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-amber-100 text-amber-800 border border-amber-300">
          <span class="w-1.5 h-1.5 mr-1.5 bg-amber-600 rounded-full"></span>Inaktif
        </span>`;
      } else {
        statusBadge = `<span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-semibold bg-rose-100 text-rose-800 border border-rose-300 badge-pulse">
          <span class="w-1.5 h-1.5 mr-1.5 bg-rose-600 rounded-full"></span>Siap Musnah
        </span>`;
      }

      // Category Pill Style
      const catColors = {
        'Pelayanan Medik': 'text-teal-700 bg-teal-50 border-teal-200',
        'Pendataan & KIE': 'text-sky-700 bg-sky-50 border-sky-200',
        'Logistik Alokon': 'text-emerald-700 bg-emerald-50 border-emerald-200',
        'Administrasi & Laporan': 'text-indigo-700 bg-indigo-50 border-indigo-200'
      };
      const catClass = catColors[item.kategori] || 'text-slate-700 bg-slate-50 border-slate-200';

      // Format Date
      const dateFormatted = formatDate(item.tanggal_arsip);

      tr.innerHTML = `
        <td class="py-3.5 px-4 text-center font-medium text-slate-400">${index + 1}</td>
        <td class="py-3.5 px-4 font-mono font-semibold text-emerald-800 tracking-tight whitespace-nowrap">
          ${item.no_arsip}
        </td>
        <td class="py-3.5 px-4">
          <div class="font-semibold text-slate-800 leading-snug">${escapeHtml(item.judul)}</div>
          <div class="text-xs text-slate-500 mt-0.5 flex items-center gap-1.5">
            <span class="inline-block w-1.5 h-1.5 rounded-full bg-slate-400"></span>
            ${escapeHtml(item.sub_kategori || '-')}
          </div>
        </td>
        <td class="py-3.5 px-4 whitespace-nowrap">
          <span class="px-2 py-0.5 rounded text-xs font-medium border ${catClass}">
            ${item.kategori}
          </span>
        </td>
        <td class="py-3.5 px-4 text-slate-600 whitespace-nowrap">
          <div class="flex items-center gap-1">
            <svg class="w-3.5 h-3.5 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            ${dateFormatted}
          </div>
        </td>
        <td class="py-3.5 px-4 text-slate-700 whitespace-nowrap">
          <div class="flex items-center gap-1.5">
            <span class="p-1 rounded bg-slate-100 text-slate-500">
              <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
            </span>
            <span class="font-medium text-xs">${escapeHtml(item.lokasi_fisik)}</span>
          </div>
        </td>
        <td class="py-3.5 px-4 whitespace-nowrap">
          <div>${statusBadge}</div>
          <div class="text-[11px] text-slate-400 mt-1">Retensi: ${item.masa_retensi} Thn</div>
        </td>
        <td class="py-3.5 px-4 text-right whitespace-nowrap">
          <div class="flex items-center justify-end gap-1.5">
            <button class="btn-detail-row p-1.5 text-slate-500 hover:text-emerald-700 hover:bg-emerald-50 rounded-lg transition-colors" title="Lihat Detail" data-id="${item.id}">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
            </button>
            <button class="btn-edit-row p-1.5 text-slate-500 hover:text-blue-700 hover:bg-blue-50 rounded-lg transition-colors" title="Edit Arsip" data-id="${item.id}">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
            </button>
            <button class="btn-delete-row p-1.5 text-slate-500 hover:text-rose-700 hover:bg-rose-50 rounded-lg transition-colors" title="Hapus Arsip" data-id="${item.id}" data-no="${item.no_arsip}" data-judul="${escapeHtml(item.judul)}">
              <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
            </button>
          </div>
        </td>
      `;

      el.arsipTableBody.appendChild(tr);
    });

    // Attach Row Action Listeners
    el.arsipTableBody.querySelectorAll('.btn-detail-row').forEach(btn => {
      btn.addEventListener('click', () => openDetailModal(btn.getAttribute('data-id')));
    });

    el.arsipTableBody.querySelectorAll('.btn-edit-row').forEach(btn => {
      btn.addEventListener('click', () => openEditModal(btn.getAttribute('data-id')));
    });

    el.arsipTableBody.querySelectorAll('.btn-delete-row').forEach(btn => {
      btn.addEventListener('click', () => {
        const id = btn.getAttribute('data-id');
        const no = btn.getAttribute('data-no');
        const judul = btn.getAttribute('data-judul');
        openDeleteModal(id, `${no} - ${judul}`);
      });
    });
  }

  // Filter Listeners
  function initFilters() {
    if (el.searchInput) {
      el.searchInput.addEventListener('input', (e) => {
        clearTimeout(state.searchDebounceTimer);
        state.searchDebounceTimer = setTimeout(() => {
          state.filters.search = e.target.value;
          loadArsip();
        }, 250);
      });
    }

    if (el.filterKategori) {
      el.filterKategori.addEventListener('change', (e) => {
        state.filters.kategori = e.target.value;
        loadArsip();
      });
    }

    if (el.filterStatus) {
      el.filterStatus.addEventListener('change', (e) => {
        state.filters.status_retensi = e.target.value;
        loadArsip();
      });
    }

    if (el.btnResetFilter) {
      el.btnResetFilter.addEventListener('click', () => {
        state.filters.search = '';
        state.filters.kategori = 'Semua';
        state.filters.status_retensi = 'Semua';
        if (el.searchInput) el.searchInput.value = '';
        if (el.filterKategori) el.filterKategori.value = 'Semua';
        if (el.filterStatus) el.filterStatus.value = 'Semua';
        loadArsip();
        showToast('Filter pencarian telah direset.', 'info');
      });
    }

    if (el.btnOpenPrintTab) {
      el.btnOpenPrintTab.addEventListener('click', () => {
        window.location.href = 'rekapitulasi.php';
      });
    }
  }

  // Populate Sub-Category Options based on Selected Category
  function updateSubKategoriOptions(selectedCategory, preselectedValue = '') {
    const list = SUB_KATEGORI_MAP[selectedCategory] || [];
    el.formSubKategori.innerHTML = '<option value="">-- Pilih Sub Kategori --</option>';

    list.forEach(sub => {
      const opt = document.createElement('option');
      opt.value = sub;
      opt.textContent = sub;
      if (sub === preselectedValue) opt.selected = true;
      el.formSubKategori.appendChild(opt);
    });

    // If preselected value is custom and not in default list, append it
    if (preselectedValue && !list.includes(preselectedValue)) {
      const opt = document.createElement('option');
      opt.value = preselectedValue;
      opt.textContent = `${preselectedValue} (Kustom)`;
      opt.selected = true;
      el.formSubKategori.appendChild(opt);
    }
  }

  // Smart Retention Calculator & Auto-Suggestion
  function calculateRetentionSuggestion() {
    const dateVal = el.formTanggal.value;
    const retensiVal = parseInt(el.formMasaRetensi.value) || 5;

    if (!dateVal) {
      if (el.retensiSuggestionHint) el.retensiSuggestionHint.textContent = '';
      return;
    }

    const archiveYear = new Date(dateVal).getFullYear();
    const currentYear = new Date().getFullYear();
    const elapsed = currentYear - archiveYear;

    let suggestedStatus = 'Aktif';
    let explanation = '';

    if (elapsed < retensiVal) {
      suggestedStatus = 'Aktif';
      explanation = `Tersimpan ~${elapsed} thn (Kurang dari masa retensi ${retensiVal} thn: Aktif)`;
    } else if (elapsed >= retensiVal && elapsed < retensiVal + 3) {
      suggestedStatus = 'Inaktif';
      explanation = `Tersimpan ~${elapsed} thn (Melewati ${retensiVal} thn: Rekomendasi Inaktif)`;
    } else {
      suggestedStatus = 'Siap Musnah';
      explanation = `Tersimpan ~${elapsed} thn (Melampaui JRA & Inaktif: Rekomendasi Siap Musnah)`;
    }

    if (el.retensiSuggestionHint) {
      el.retensiSuggestionHint.innerHTML = `
        <span class="text-xs text-emerald-700 bg-emerald-50 px-2 py-0.5 rounded border border-emerald-200 inline-flex items-center gap-1">
          <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
          Saran Sistem: <strong>${suggestedStatus}</strong> (${explanation})
        </span>
      `;
    }
  }

  // Add & Edit Modal Handlers
  function openAddModal() {
    state.editingId = null;
    el.modalTitle.textContent = 'Tambah Arsip KB Baru';
    el.formArsip.reset();

    // Default values
    const today = new Date().toISOString().slice(0, 10);
    el.formTanggal.value = today;
    el.formKategori.value = 'Pelayanan Medik';
    updateSubKategoriOptions('Pelayanan Medik');
    el.formMasaRetensi.value = 5;
    el.formStatusRetensi.value = 'Aktif';
    el.formLokasi.value = 'Rak A1 - Boks 01';

    // Suggest next archive number
    const year = new Date().getFullYear();
    const nextSeq = String(state.arsipList.length + 1).padStart(3, '0');
    el.formNoArsip.value = `KB/${year}/${nextSeq}`;

    calculateRetentionSuggestion();
    showModal(el.modalArsip);
  }

  async function openEditModal(id) {
    try {
      const res = await API.getArsipById(id);
      if (!res || !res.success) throw new Error('Data arsip tidak ditemukan.');

      const item = res.data;
      state.editingId = id;
      el.modalTitle.textContent = 'Edit Data Arsip KB';

      el.formNoArsip.value = item.no_arsip || '';
      el.formJudul.value = item.judul || '';
      el.formKategori.value = item.kategori || 'Pelayanan Medik';
      updateSubKategoriOptions(item.kategori, item.sub_kategori);
      el.formTanggal.value = item.tanggal_arsip || '';
      el.formLokasi.value = item.lokasi_fisik || '';
      el.formMasaRetensi.value = item.masa_retensi || 5;
      el.formStatusRetensi.value = item.status_retensi || 'Aktif';
      el.formDeskripsi.value = item.deskripsi || '';

      calculateRetentionSuggestion();
      hideModal(el.modalDetail);
      showModal(el.modalArsip);
    } catch (err) {
      showToast('Gagal memuat arsip untuk diedit: ' + err.message, 'error');
    }
  }

  async function handleFormSubmit(e) {
    e.preventDefault();

    const payload = {
      no_arsip: el.formNoArsip.value.trim(),
      judul: el.formJudul.value.trim(),
      kategori: el.formKategori.value,
      sub_kategori: el.formSubKategori.value.trim(),
      tanggal_arsip: el.formTanggal.value,
      lokasi_fisik: el.formLokasi.value.trim(),
      masa_retensi: parseInt(el.formMasaRetensi.value) || 5,
      status_retensi: el.formStatusRetensi.value,
      deskripsi: el.formDeskripsi.value.trim()
    };

    if (!payload.judul) {
      showToast('Judul arsip wajib diisi!', 'warning');
      return;
    }

    try {
      const submitBtn = el.formArsip.querySelector('button[type="submit"]');
      const originalText = submitBtn.innerHTML;
      submitBtn.disabled = true;
      submitBtn.innerHTML = `
        <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline-block" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg>
        Menyimpan...
      `;

      if (state.editingId) {
        // Update
        const res = await API.updateArsip(state.editingId, payload);
        if (res && res.success) {
          showToast(`Arsip '${payload.no_arsip}' berhasil diperbarui!`, 'success');
        }
      } else {
        // Create
        const res = await API.createArsip(payload);
        if (res && res.success) {
          showToast(`Arsip '${res.data.no_arsip}' berhasil ditambahkan!`, 'success');
        }
      }

      hideModal(el.modalArsip);
      submitBtn.disabled = false;
      submitBtn.innerHTML = originalText;

      if (!el.arsipTableBody && !el.statTotal) {
        setTimeout(() => { window.location.href = 'arsip.php'; }, 1000);
      } else {
        await loadStats();
        await loadArsip();
      }
    } catch (err) {
      showToast('Gagal menyimpan arsip: ' + err.message, 'error');
    }
  }

  // Detail Modal Handler
  async function openDetailModal(id) {
    try {
      const res = await API.getArsipById(id);
      if (!res || !res.success) throw new Error('Data tidak ditemukan.');
      const item = res.data;

      el.detailNoArsip.textContent = item.no_arsip;
      el.detailJudul.textContent = item.judul;
      el.detailKategori.textContent = item.kategori;
      el.detailSubKategori.textContent = item.sub_kategori || '-';
      el.detailTanggal.textContent = formatDate(item.tanggal_arsip, true);
      el.detailLokasi.textContent = item.lokasi_fisik;
      el.detailMasaRetensi.textContent = `${item.masa_retensi} Tahun`;
      el.detailDeskripsi.textContent = item.deskripsi || 'Tidak ada uraian deskripsi tambahan.';
      el.detailCreatedAt.textContent = new Date(item.created_at).toLocaleString('id-ID');
      el.detailBarcodeText.textContent = item.no_arsip;

      // Status badge in detail
      let statusBadge = '';
      if (item.status_retensi === 'Aktif') {
        statusBadge = '<span class="px-3 py-1 bg-emerald-100 text-emerald-800 rounded-full font-semibold text-xs border border-emerald-300">Aktif (Dinamis Aktif)</span>';
      } else if (item.status_retensi === 'Inaktif') {
        statusBadge = '<span class="px-3 py-1 bg-amber-100 text-amber-800 rounded-full font-semibold text-xs border border-amber-300">Inaktif (Depo Simpan)</span>';
      } else {
        statusBadge = '<span class="px-3 py-1 bg-rose-100 text-rose-800 rounded-full font-semibold text-xs border border-rose-300">Siap Musnah (Melampaui JRA)</span>';
      }
      el.detailStatusBadge.innerHTML = statusBadge;

      el.btnEditFromDetail.onclick = () => openEditModal(item.id);

      // Print Label action
      el.btnPrintLabel.onclick = () => {
        printArchiveLabel(item);
      };

      showModal(el.modalDetail);
    } catch (err) {
      showToast('Gagal membuka detail arsip: ' + err.message, 'error');
    }
  }

  function printArchiveLabel(item) {
    const printWindow = window.open('', '_blank', 'width=500,height=400');
    printWindow.document.write(`
      <!DOCTYPE html>
      <html>
      <head>
        <title>Label Berkas - ${item.no_arsip}</title>
        <style>
          body { font-family: monospace; padding: 20px; text-align: center; margin: 0; }
          .label-card { border: 2px dashed #333; padding: 16px; border-radius: 8px; max-width: 380px; margin: 0 auto; }
          .instansi { font-size: 11px; font-weight: bold; text-transform: uppercase; margin-bottom: 6px; letter-spacing: 0.5px; }
          .no-arsip { font-size: 20px; font-weight: bold; color: #047857; margin: 8px 0; border-top: 1px solid #ddd; border-bottom: 1px solid #ddd; padding: 4px 0; }
          .judul { font-size: 13px; font-weight: bold; margin-bottom: 8px; }
          .meta { font-size: 11px; text-align: left; margin-top: 8px; line-height: 1.6; }
          .barcode { height: 32px; background: repeating-linear-gradient(90deg, #000 0px, #000 2px, #fff 2px, #fff 4px, #000 4px, #000 7px, #fff 7px, #fff 9px); margin: 10px auto; width: 220px; }
        </style>
      </head>
      <body>
        <div class="label-card">
          <div class="instansi">BALAI PENYULUHAN KB - SIDA-KB</div>
          <div class="barcode"></div>
          <div class="no-arsip">${item.no_arsip}</div>
          <div class="judul">${escapeHtml(item.judul)}</div>
          <div class="meta">
            <div><strong>Kategori:</strong> ${item.kategori} (${item.sub_kategori || '-'})</div>
            <div><strong>Lokasi Simpan:</strong> ${item.lokasi_fisik}</div>
            <div><strong>Tgl Berkas:</strong> ${item.tanggal_arsip} | <strong>Status:</strong> ${item.status_retensi}</div>
          </div>
        </div>
        <script>
          window.onload = function() { window.print(); window.close(); }
        </script>
      </body>
      </html>
    `);
    printWindow.document.close();
  }

  // Delete Confirmation Handlers
  function openDeleteModal(id, title) {
    state.deletingId = id;
    el.deleteItemTitle.textContent = title;
    showModal(el.modalDelete);
  }

  async function handleConfirmDelete() {
    if (!state.deletingId) return;

    try {
      const res = await API.deleteArsip(state.deletingId);
      if (res && res.success) {
        showToast(res.message || 'Arsip berhasil dihapus.', 'success');
      }
      hideModal(el.modalDelete);
      state.deletingId = null;
      await loadStats();
      await loadArsip();
    } catch (err) {
      showToast('Gagal menghapus arsip: ' + err.message, 'error');
    }
  }

  // Print & Report Section Handlers
  async function renderPrintTable() {
    const filterCat = el.printFilterKategori.value;
    const filterStat = el.printFilterStatus.value;

    let list = [];
    try {
      const res = await API.getArsip({
        kategori: filterCat,
        status_retensi: filterStat,
        all: true
      });
      if (res && res.success && Array.isArray(res.data)) {
        list = res.data;
      } else {
        list = [...state.arsipList];
      }
    } catch {
      list = [...state.arsipList];
    }

    if (filterCat && filterCat !== 'Semua') {
      list = list.filter(item => item.kategori === filterCat);
    }

    if (filterStat && filterStat !== 'Semua') {
      list = list.filter(item => item.status_retensi === filterStat);
    }

    el.printTableBody.innerHTML = '';
    if (el.printTotalCount) {
      el.printTotalCount.textContent = list.length;
    }

    if (list.length === 0) {
      el.printTableBody.innerHTML = `
        <tr>
          <td colspan="8" class="text-center py-6 text-slate-400 italic">
            Tidak ada arsip yang cocok dengan kriteria cetak laporan.
          </td>
        </tr>
      `;
      return;
    }

    list.forEach((item, index) => {
      const tr = document.createElement('tr');
      tr.className = 'border-b border-slate-300 text-xs';
      tr.innerHTML = `
        <td class="py-2 px-2 text-center font-medium">${index + 1}</td>
        <td class="py-2 px-2 font-mono font-semibold text-slate-900">${item.no_arsip}</td>
        <td class="py-2 px-2">
          <div class="font-bold text-slate-900">${escapeHtml(item.judul)}</div>
          <div class="text-[11px] text-slate-600">${escapeHtml(item.deskripsi || '-')}</div>
        </td>
        <td class="py-2 px-2">${item.kategori}<br><span class="text-[10px] text-slate-500">${item.sub_kategori || ''}</span></td>
        <td class="py-2 px-2 text-center whitespace-nowrap">${item.tanggal_arsip}</td>
        <td class="py-2 px-2 font-medium">${escapeHtml(item.lokasi_fisik)}</td>
        <td class="py-2 px-2 text-center">${item.masa_retensi} Thn</td>
        <td class="py-2 px-2 text-center font-semibold ${item.status_retensi === 'Siap Musnah' ? 'text-rose-700' : (item.status_retensi === 'Inaktif' ? 'text-amber-700' : 'text-emerald-700')}">
          ${item.status_retensi}
        </td>
      `;
      el.printTableBody.appendChild(tr);
    });
  }

  function initPrintSection() {
    if (el.printFilterKategori) el.printFilterKategori.addEventListener('change', renderPrintTable);
    if (el.printFilterStatus) el.printFilterStatus.addEventListener('change', renderPrintTable);

    if (el.btnPrintAction) {
      el.btnPrintAction.addEventListener('click', async () => {
        await renderPrintTable();
        window.print();
      });
    }

    // Auto-render print table jika sedang berada di halaman rekapitulasi
    if (el.printTableBody) {
      renderPrintTable();
    }
  }

  // Modal Visibility Helpers
  function showModal(modalEl) {
    if (!modalEl) return;
    modalEl.classList.remove('hidden');
    setTimeout(() => {
      const overlay = modalEl.querySelector('.modal-overlay');
      const container = modalEl.querySelector('.modal-container');
      if (overlay) overlay.classList.remove('opacity-0');
      if (container) {
        container.classList.remove('opacity-0', 'scale-95');
        container.classList.add('opacity-100', 'scale-100');
      }
    }, 10);
  }

  function hideModal(modalEl) {
    if (!modalEl) return;
    const overlay = modalEl.querySelector('.modal-overlay');
    const container = modalEl.querySelector('.modal-container');
    if (overlay) overlay.classList.add('opacity-0');
    if (container) {
      container.classList.remove('opacity-100', 'scale-100');
      container.classList.add('opacity-0', 'scale-95');
    }
    setTimeout(() => {
      modalEl.classList.add('hidden');
    }, 200);
  }

  // Utilities
  function formatDate(dateStr, includeDay = false) {
    if (!dateStr) return '-';
    try {
      const d = new Date(dateStr);
      if (isNaN(d.getTime())) return dateStr;
      const options = {
        year: 'numeric',
        month: 'short',
        day: 'numeric'
      };
      if (includeDay) options.weekday = 'long';
      return d.toLocaleDateString('id-ID', options);
    } catch {
      return dateStr;
    }
  }

  function escapeHtml(text) {
    if (!text) return '';
    return String(text)
      .replace(/&/g, '&amp;')
      .replace(/</g, '&lt;')
      .replace(/>/g, '&gt;')
      .replace(/"/g, '&quot;')
      .replace(/'/g, '&#039;');
  }

  // Check Backend Connection Health
  async function checkServerHealth() {
    try {
      await API.getHealth();
    } catch (err) {
      console.warn('Database health check:', err);
    }
  }

  // Event Listeners Binding
  function bindEvents() {
    // Buttons for modal open
    if (el.btnOpenAddModal) el.btnOpenAddModal.addEventListener('click', openAddModal);
    if (el.btnQuickAdd) el.btnQuickAdd.addEventListener('click', openAddModal);

    // Modal close buttons
    if (el.btnCancelArsip) el.btnCancelArsip.addEventListener('click', () => hideModal(el.modalArsip));
    if (el.btnCloseModalArsip) el.btnCloseModalArsip.addEventListener('click', () => hideModal(el.modalArsip));
    if (el.btnCloseDetail) el.btnCloseDetail.addEventListener('click', () => hideModal(el.modalDetail));
    if (el.btnCancelDelete) el.btnCancelDelete.addEventListener('click', () => hideModal(el.modalDelete));
    if (el.btnConfirmDelete) el.btnConfirmDelete.addEventListener('click', handleConfirmDelete);

    // Close on backdrop click
    [el.modalArsip, el.modalDetail, el.modalDelete].forEach(modal => {
      if (modal) {
        const overlay = modal.querySelector('.modal-overlay');
        if (overlay) {
          overlay.addEventListener('click', () => hideModal(modal));
        }
      }
    });

    // Form inputs change
    if (el.formKategori) {
      el.formKategori.addEventListener('change', (e) => {
        updateSubKategoriOptions(e.target.value);
      });
    }

    if (el.formTanggal) el.formTanggal.addEventListener('change', calculateRetentionSuggestion);
    if (el.formMasaRetensi) el.formMasaRetensi.addEventListener('input', calculateRetentionSuggestion);

    // Form submit
    if (el.formArsip) el.formArsip.addEventListener('submit', handleFormSubmit);

    // Global keyboard Escape to close modal
    document.addEventListener('keydown', (e) => {
      if (e.key === 'Escape') {
        hideModal(el.modalArsip);
        hideModal(el.modalDetail);
        hideModal(el.modalDelete);
      }
    });
  }

  // Initialization
  async function init() {
    initClock();
    initTabs();
    initFilters();
    initPrintSection();
    bindEvents();
    checkServerHealth();
    await loadStats();
    await loadArsip();
  }

  init();
});

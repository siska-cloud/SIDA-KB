/**
 * =========================================================================
 * API CLIENT FOR SIDA-KB (PHP NATIVE)
 * Sistem Informasi & Digitalisasi Kearsipan Program KB
 * Kompatibel untuk Localhost (Laragon/XAMPP) & Hosting InfinityFree
 * =========================================================================
 */

const API = {
  // Menggunakan proses/api.php secara relatif agar fleksibel di semua domain & subdirektori
  baseUrl: 'proses/api.php',

  /**
   * Helper function to execute fetch requests with JSON parsing and error handling
   */
  async request(endpoint, options = {}) {
    let url = this.baseUrl;

    // Bersihkan slash di awal
    const cleanEndpoint = endpoint.replace(/^\//, '');
    const [pathPart, queryPart] = cleanEndpoint.split('?');
    const segments = pathPart.split('/');

    const action = segments[0] || 'stats';
    const idParam = segments[1] ? `&id=${encodeURIComponent(segments[1])}` : '';
    const queryParam = queryPart ? `&${queryPart}` : '';

    url = `${this.baseUrl}?action=${encodeURIComponent(action)}${idParam}${queryParam}`;

    const defaultHeaders = {
      'Content-Type': 'application/json',
      'Accept': 'application/json'
    };

    const config = {
      ...options,
      headers: {
        ...defaultHeaders,
        ...(options.headers || {})
      }
    };

    try {
      const response = await fetch(url, config);
      const data = await response.json();

      if (!response.ok) {
        throw new Error(data.message || `HTTP Error ${response.status}: Terjadi kesalahan pada server`);
      }

      return data;
    } catch (error) {
      console.error(`[API Error] ${options.method || 'GET'} ${url}:`, error.message);
      throw error;
    }
  },

  /**
   * GET /api/stats - Ringkasan statistik arsip
   */
  async getStats() {
    return this.request('/stats');
  },

  /**
   * GET /api/arsip - Daftar data arsip dengan query search, kategori, status_retensi
   */
  async getArsip({ search = '', kategori = '', status_retensi = '', all = false } = {}) {
    const params = new URLSearchParams();
    if (search && search.trim() !== '') params.append('search', search.trim());
    if (kategori && kategori !== 'Semua') params.append('kategori', kategori);
    if (status_retensi && status_retensi !== 'Semua') params.append('status_retensi', status_retensi);
    if (all) params.append('all', '1');

    const query = params.toString() ? `?${params.toString()}` : '';
    return this.request(`/arsip${query}`);
  },

  /**
   * GET /api/arsip/:id - Detail 1 arsip
   */
  async getArsipById(id) {
    return this.request(`/arsip/${id}`);
  },

  /**
   * POST /api/arsip - Tambah data arsip baru
   */
  async createArsip(data) {
    return this.request('/arsip', {
      method: 'POST',
      body: JSON.stringify(data)
    });
  },

  /**
   * PUT /api/arsip/:id - Perbarui data arsip
   */
  async updateArsip(id, data) {
    return this.request(`/arsip/${id}`, {
      method: 'PUT',
      body: JSON.stringify(data)
    });
  },

  /**
   * DELETE /api/arsip/:id - Hapus data arsip
   */
  async deleteArsip(id) {
    return this.request(`/arsip/${id}`, {
      method: 'DELETE'
    });
  },

  /**
   * GET /api/health - Cek koneksi server
   */
  async getHealth() {
    return this.request('/health');
  }
};

window.API = API;

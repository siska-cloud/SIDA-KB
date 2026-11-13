<?php
/**
 * =========================================================================
 * REST API & PROSES CRUD (PHP NATIVE) - SIDA-KB
 * =========================================================================
 */

header('Content-Type: application/json; charset=utf-8');
header('Access-Control-Allow-Origin: *');
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type, Authorization, X-Requested-With');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

require_once __DIR__ . '/../config/database.php';
$pdo = getDB();

$action = isset($_GET['action']) ? $_GET['action'] : '';
$method = $_SERVER['REQUEST_METHOD'];

if (empty($action) && isset($_SERVER['PATH_INFO'])) {
    $path = trim($_SERVER['PATH_INFO'], '/');
    $parts = explode('/', $path);
    $action = $parts[0] ?? '';
    if (isset($parts[1]) && is_numeric($parts[1])) {
        $_GET['id'] = (int) $parts[1];
    }
}

$rawInput = file_get_contents('php://input');
$jsonInput = json_decode($rawInput, true);
$inputData = is_array($jsonInput) ? $jsonInput : $_POST;

try {
    switch ($action) {
        case 'health':
            handleHealth($pdo);
            break;

        case 'stats':
            handleStats($pdo);
            break;

        case 'arsip':
            if ($method === 'GET') {
                if (isset($_GET['id']) && is_numeric($_GET['id'])) {
                    handleDetail($pdo, (int)$_GET['id']);
                } else {
                    handleList($pdo);
                }
            } elseif ($method === 'POST') {
                handleCreate($pdo, $inputData);
            } elseif ($method === 'PUT') {
                $id = isset($_GET['id']) ? (int)$_GET['id'] : ($inputData['id'] ?? 0);
                handleUpdate($pdo, $id, $inputData);
            } elseif ($method === 'DELETE') {
                $id = isset($_GET['id']) ? (int)$_GET['id'] : ($inputData['id'] ?? 0);
                handleDelete($pdo, $id);
            } else {
                sendResponse(false, 'Metode HTTP tidak didukung.', null, 405);
            }
            break;

        case 'detail':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
            handleDetail($pdo, $id);
            break;

        case 'tambah':
        case 'store':
            handleCreate($pdo, $inputData);
            break;

        case 'edit':
        case 'update':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : ($inputData['id'] ?? 0);
            handleUpdate($pdo, $id, $inputData);
            break;

        case 'hapus':
        case 'delete':
            $id = isset($_GET['id']) ? (int)$_GET['id'] : ($inputData['id'] ?? 0);
            handleDelete($pdo, $id);
            break;

        default:
            sendResponse(false, 'Endpoint tidak ditemukan.', null, 404);
            break;
    }
} catch (Exception $e) {
    sendResponse(false, 'Terjadi kesalahan server: ' . $e->getMessage(), null, 500);
}

function sendResponse($success, $messageOrData, $data = null, $code = 200) {
    http_response_code($code);
    if (is_string($messageOrData)) {
        $res = ['success' => $success, 'message' => $messageOrData];
        if ($data !== null) {
            $res['data'] = $data;
        }
    } else {
        $res = ['success' => $success, 'data' => $messageOrData];
    }
    echo json_encode($res, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);
    exit;
}

function handleHealth($pdo) {
    $dbStatus = 'UP';
    try {
        $pdo->query('SELECT 1');
    } catch (Exception $e) {
        $dbStatus = 'DOWN: ' . $e->getMessage();
    }

    echo json_encode([
        'status' => 'UP',
        'framework' => 'PHP Native (InfinityFree Ready)',
        'database' => $dbStatus,
        'php_version' => PHP_VERSION,
        'timestamp' => date('c')
    ]);
    exit;
}

function handleStats($pdo) {
    $stmt = $pdo->query("SELECT COUNT(*) FROM `arsip`");
    $total = (int)$stmt->fetchColumn();

    $stmt = $pdo->query("SELECT status_retensi, COUNT(*) as cnt FROM `arsip` GROUP BY status_retensi");
    $statusRows = $stmt->fetchAll();
    $aktif = 0;
    $inaktif = 0;
    $siapMusnah = 0;

    foreach ($statusRows as $r) {
        if ($r['status_retensi'] === 'Aktif') $aktif = (int)$r['cnt'];
        if ($r['status_retensi'] === 'Inaktif') $inaktif = (int)$r['cnt'];
        if ($r['status_retensi'] === 'Siap Musnah') $siapMusnah = (int)$r['cnt'];
    }

    $categories = [
        'Pelayanan Medik',
        'Pendataan & KIE',
        'Logistik Alokon',
        'Administrasi & Laporan'
    ];
    $kategoriCounts = [];
    foreach ($categories as $cat) {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `arsip` WHERE `kategori` = ?");
        $stmt->execute([$cat]);
        $kategoriCounts[$cat] = (int)$stmt->fetchColumn();
    }

    $response = [
        'total' => $total,
        'totalCount' => $total,
        'status' => [
            'aktif' => $aktif,
            'inaktif' => $inaktif,
            'siap_musnah' => $siapMusnah,
        ],
        'aktifCount' => $aktif,
        'inaktifCount' => $inaktif,
        'siapMusnahCount' => $siapMusnah,
        'kategori' => $kategoriCounts,
        'perKategori' => $kategoriCounts
    ];

    sendResponse(true, $response);
}

function handleList($pdo) {
    $search = isset($_GET['search']) ? trim($_GET['search']) : '';
    $kategori = isset($_GET['kategori']) ? trim($_GET['kategori']) : '';
    $statusRetensi = isset($_GET['status_retensi']) ? trim($_GET['status_retensi']) : '';
    $isAll = isset($_GET['all']) && ($_GET['all'] === 'true' || $_GET['all'] === '1');
    $page = isset($_GET['page']) ? max(1, (int)$_GET['page']) : 1;
    $perPage = isset($_GET['per_page']) ? max(1, (int)$_GET['per_page']) : 10;

    $where = [];
    $params = [];

    if ($search !== '') {
        $where[] = "(`no_arsip` LIKE ? OR `judul` LIKE ? OR `sub_kategori` LIKE ? OR `lokasi_fisik` LIKE ? OR `deskripsi` LIKE ?)";
        $searchParam = "%{$search}%";
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
        $params[] = $searchParam;
    }

    if ($kategori !== '' && $kategori !== 'Semua') {
        $where[] = "`kategori` = ?";
        $params[] = $kategori;
    }

    if ($statusRetensi !== '' && $statusRetensi !== 'Semua') {
        $where[] = "`status_retensi` = ?";
        $params[] = $statusRetensi;
    }

    $whereSql = count($where) > 0 ? "WHERE " . implode(" AND ", $where) : "";

    $countSql = "SELECT COUNT(*) FROM `arsip` {$whereSql}";
    $stmtCount = $pdo->prepare($countSql);
    $stmtCount->execute($params);
    $totalFiltered = (int)$stmtCount->fetchColumn();

    if ($isAll) {
        $sql = "SELECT * FROM `arsip` {$whereSql} ORDER BY `tanggal_arsip` DESC, `id` DESC";
        $stmt = $pdo->prepare($sql);
        $stmt->execute($params);
        $items = $stmt->fetchAll();

        foreach ($items as &$it) {
            if (!isset($it['masa_retensi'])) $it['masa_retensi'] = 5;
            $it['masa_retensi'] = (int)$it['masa_retensi'];
        }

        echo json_encode([
            'success' => true,
            'data' => $items,
            'total' => count($items)
        ]);
        exit;
    }

    $offset = ($page - 1) * $perPage;
    $sql = "SELECT * FROM `arsip` {$whereSql} ORDER BY `tanggal_arsip` DESC, `id` DESC LIMIT {$perPage} OFFSET {$offset}";
    $stmt = $pdo->prepare($sql);
    $stmt->execute($params);
    $items = $stmt->fetchAll();

    foreach ($items as &$it) {
        if (!isset($it['masa_retensi'])) $it['masa_retensi'] = 5;
        $it['masa_retensi'] = (int)$it['masa_retensi'];
    }

    $lastPage = max(1, (int)ceil($totalFiltered / $perPage));

    echo json_encode([
        'success' => true,
        'data' => $items,
        'pagination' => [
            'total' => $totalFiltered,
            'per_page' => $perPage,
            'current_page' => $page,
            'last_page' => $lastPage,
            'from' => count($items) > 0 ? $offset + 1 : 0,
            'to' => $offset + count($items)
        ]
    ]);
    exit;
}

function handleDetail($pdo, $id) {
    if ($id <= 0) {
        sendResponse(false, 'ID arsip tidak valid.', null, 400);
    }

    $stmt = $pdo->prepare("SELECT * FROM `arsip` WHERE `id` = ?");
    $stmt->execute([$id]);
    $item = $stmt->fetch();

    if (!$item) {
        sendResponse(false, "Arsip dengan ID {$id} tidak ditemukan.", null, 404);
    }

    if (!isset($item['masa_retensi'])) $item['masa_retensi'] = 5;
    $item['masa_retensi'] = (int)$item['masa_retensi'];

    sendResponse(true, $item);
}

function handleCreate($pdo, $data) {
    $judul = trim($data['judul'] ?? '');
    $kategori = trim($data['kategori'] ?? '');
    $subKategori = trim($data['sub_kategori'] ?? '');
    $tanggal = trim($data['tanggal_arsip'] ?? '');
    $lokasi = trim($data['lokasi_fisik'] ?? '');
    $status = trim($data['status_retensi'] ?? '');
    $masaRetensi = isset($data['masa_retensi']) ? (int)$data['masa_retensi'] : 5;
    $deskripsi = trim($data['deskripsi'] ?? '');
    $noArsip = trim($data['no_arsip'] ?? '');

    if (empty($judul)) sendResponse(false, 'Judul arsip wajib diisi.', null, 422);
    if (empty($kategori)) sendResponse(false, 'Kategori arsip wajib dipilih.', null, 422);
    if (empty($tanggal)) sendResponse(false, 'Tanggal arsip wajib diisi.', null, 422);
    if (empty($lokasi)) sendResponse(false, 'Lokasi fisik wajib diisi.', null, 422);
    if (empty($status)) sendResponse(false, 'Status retensi wajib dipilih.', null, 422);

    if (empty($noArsip)) {
        $year = date('Y', strtotime($tanggal));
        if (!$year || $year == '1970') $year = date('Y');

        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `arsip` WHERE YEAR(`tanggal_arsip`) = ?");
        $stmt->execute([$year]);
        $count = (int)$stmt->fetchColumn() + 1;
        $noArsip = sprintf('KB/%s/%03d', $year, $count);

        $checkStmt = $pdo->prepare("SELECT COUNT(*) FROM `arsip` WHERE `no_arsip` = ?");
        while (true) {
            $checkStmt->execute([$noArsip]);
            if ((int)$checkStmt->fetchColumn() === 0) break;
            $count++;
            $noArsip = sprintf('KB/%s/%03d', $year, $count);
        }
    } else {
        $stmt = $pdo->prepare("SELECT COUNT(*) FROM `arsip` WHERE `no_arsip` = ?");
        $stmt->execute([$noArsip]);
        if ((int)$stmt->fetchColumn() > 0) {
            sendResponse(false, "Nomor arsip '{$noArsip}' sudah terdaftar di sistem.", null, 422);
        }
    }

    $sql = "INSERT INTO `arsip` 
        (`no_arsip`, `judul`, `kategori`, `sub_kategori`, `tanggal_arsip`, `lokasi_fisik`, `masa_retensi`, `status_retensi`, `deskripsi`, `created_at`, `updated_at`) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, NOW(), NOW())";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $noArsip, $judul, $kategori, $subKategori, $tanggal, $lokasi, $masaRetensi, $status, $deskripsi
    ]);

    $newId = (int)$pdo->lastInsertId();
    $stmtFetch = $pdo->prepare("SELECT * FROM `arsip` WHERE `id` = ?");
    $stmtFetch->execute([$newId]);
    $created = $stmtFetch->fetch();

    sendResponse(true, 'Data arsip berhasil ditambahkan.', $created, 201);
}

function handleUpdate($pdo, $id, $data) {
    if ($id <= 0) {
        sendResponse(false, 'ID arsip tidak valid.', null, 400);
    }

    $checkStmt = $pdo->prepare("SELECT * FROM `arsip` WHERE `id` = ?");
    $checkStmt->execute([$id]);
    $existing = $checkStmt->fetch();
    if (!$existing) {
        sendResponse(false, "Arsip dengan ID {$id} tidak ditemukan.", null, 404);
    }

    $judul = trim($data['judul'] ?? $existing['judul']);
    $kategori = trim($data['kategori'] ?? $existing['kategori']);
    $subKategori = trim($data['sub_kategori'] ?? $existing['sub_kategori']);
    $tanggal = trim($data['tanggal_arsip'] ?? $existing['tanggal_arsip']);
    $lokasi = trim($data['lokasi_fisik'] ?? $existing['lokasi_fisik']);
    $status = trim($data['status_retensi'] ?? $existing['status_retensi']);
    $masaRetensi = isset($data['masa_retensi']) ? (int)$data['masa_retensi'] : (int)($existing['masa_retensi'] ?? 5);
    $deskripsi = isset($data['deskripsi']) ? trim($data['deskripsi']) : $existing['deskripsi'];
    $noArsip = trim($data['no_arsip'] ?? $existing['no_arsip']);

    if (empty($judul)) sendResponse(false, 'Judul arsip wajib diisi.', null, 422);

    $stmtCheck = $pdo->prepare("SELECT COUNT(*) FROM `arsip` WHERE `no_arsip` = ? AND `id` != ?");
    $stmtCheck->execute([$noArsip, $id]);
    if ((int)$stmtCheck->fetchColumn() > 0) {
        sendResponse(false, "Nomor arsip '{$noArsip}' sudah digunakan oleh berkas lain.", null, 422);
    }

    $sql = "UPDATE `arsip` SET 
        `no_arsip` = ?, 
        `judul` = ?, 
        `kategori` = ?, 
        `sub_kategori` = ?, 
        `tanggal_arsip` = ?, 
        `lokasi_fisik` = ?, 
        `masa_retensi` = ?, 
        `status_retensi` = ?, 
        `deskripsi` = ?, 
        `updated_at` = NOW() 
        WHERE `id` = ?";
    
    $stmt = $pdo->prepare($sql);
    $stmt->execute([
        $noArsip, $judul, $kategori, $subKategori, $tanggal, $lokasi, $masaRetensi, $status, $deskripsi, $id
    ]);

    $stmtFetch = $pdo->prepare("SELECT * FROM `arsip` WHERE `id` = ?");
    $stmtFetch->execute([$id]);
    $updated = $stmtFetch->fetch();

    sendResponse(true, 'Data arsip berhasil diperbarui.', $updated);
}

function handleDelete($pdo, $id) {
    if ($id <= 0) {
        sendResponse(false, 'ID arsip tidak valid.', null, 400);
    }

    $checkStmt = $pdo->prepare("SELECT * FROM `arsip` WHERE `id` = ?");
    $checkStmt->execute([$id]);
    $item = $checkStmt->fetch();
    if (!$item) {
        sendResponse(false, "Arsip dengan ID {$id} tidak ditemukan.", null, 404);
    }

    $stmt = $pdo->prepare("DELETE FROM `arsip` WHERE `id` = ?");
    $stmt->execute([$id]);

    sendResponse(true, "Arsip '{$item['no_arsip']}' ({$item['judul']}) berhasil dihapus.");
}


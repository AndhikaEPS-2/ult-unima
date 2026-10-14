<?php
require_once __DIR__ . '/includes/functions.php';
$pdo = getDB();  
/**
 * Ambil teks nomor tiket dari satu baris tabel antrian.
 * Mencoba beberapa kemungkinan nama kolom supaya tidak error.
 */
function nomorDariRow(array $r): string
{
    foreach (['nomor_tiket', 'nomor_antrian', 'no_tiket', 'nomor'] as $k) {
        if (!empty($r[$k])) {
            return (string) $r[$k];
        }
    }
    return '#' . ($r['id'] ?? '?');
}

/**
 * Nomor yang sedang dipanggil/dilayani hari ini (terbaru dulu).
 */
function getDipanggilHariIni(PDO $pdo, int $limit = 3): array
{
    $stmt = $pdo->query(
        "SELECT a.* FROM antrian a
         WHERE a.status IN ('dipanggil', 'dilayani')
           AND a.tanggal_antrian = CURDATE()
         ORDER BY a.dipanggil_at DESC
         LIMIT " . (int) $limit
    );
    return array_map('nomorDariRow', $stmt->fetchAll());
}

/* ---------- MODE API (dipanggil oleh JavaScript tiap 3 detik) ---------- */
if (isset($_GET['api'])) {
    header('Content-Type: application/json; charset=utf-8');
    header('Cache-Control: no-store');
    echo json_encode([
        'dipanggil' => getDipanggilHariIni($pdo),
        'menunggu'  => getTotalMenunggu($pdo),
    ]);
    exit;
}

/* ---------- MODE HALAMAN ---------- */
$dipanggil = getDipanggilHariIni($pdo);
$menunggu  = getTotalMenunggu($pdo);

$pageTitle = 'Beranda';
include __DIR__ . '/includes/header.php';
?>

<style>
  .now-serving {
    margin: 0 0 8px;
    padding: 16px 20px;
    background: #fff;
    border-left: 6px solid var(--indigo);
    border-radius: 14px;
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
    display: inline-block;
  }
  .now-serving[hidden] { display: none; }
  .now-label {
    display: block;
    font-size: .75rem;
    font-weight: 700;
    letter-spacing: 1.5px;
    color: #6b7280;
    margin-bottom: 8px;
  }
  .now-chips { display: flex; gap: 10px; flex-wrap: wrap; }
  .now-chips .chip {
    background: var(--navy-dark);
    color: #fff;
    font-weight: 800;
    font-size: 1.6rem;
    padding: 6px 18px;
    border-radius: 12px;
  }
  .stat-box .value.flash { animation: flashVal .8s ease; }
  @keyframes flashVal {
    0%   { transform: scale(1.15); color: #fde68a; }
    100% { transform: scale(1); }
  }
  @media (max-width: 860px) {
    .now-serving { display: block; }
    .now-serving[hidden] { display: none; }
    .now-chips .chip { font-size: 1.2rem; padding: 5px 14px; }
  }
</style>

<section class="hero">
  <p class="greet">Selamat Datang,</p>
  <h1>Di Sistem Informasi Layanan Digital</h1>
  <p class="tagline">Layanan Lebih Mudah, Antrian Lebih Teratur.</p>

  <!-- Panel nomor yang sedang dipanggil (muncul otomatis jika ada) -->
  <div class="now-serving" id="nowServing" <?= $dipanggil ? '' : 'hidden' ?>>
    <span class="now-label">SEDANG DIPANGGIL</span>
    <div class="now-chips" id="nowChips">
      <?php foreach ($dipanggil as $nomor): ?>
        <span class="chip"><?= e($nomor) ?></span>
      <?php endforeach; ?>
    </div>
  </div>
</section>

<div class="cta-wrap">
  <a href="ambil.php" class="btn-cta">Ambil Nomor Antrian</a>
</div>

<div class="stats-bar">
  <div class="stat-box">
    <h4>JAM LAYANAN</h4>
    <div class="value">08:00-16:00</div>
  </div>
  <div class="stat-box">
    <h4>SEDANG DI LAYANI</h4>
    <div class="value" id="stat-dilayani"><?= $dipanggil ? e($dipanggil[0]) : '-' ?></div>
  </div>
  <div class="stat-box">
    <h4>Total Menunggu</h4>
    <div class="value" id="stat-menunggu"><?= (int) $menunggu ?></div>
  </div>
</div>

<script>
const elDilayani = document.getElementById('stat-dilayani');
const elMenunggu = document.getElementById('stat-menunggu');
const elPanel    = document.getElementById('nowServing');
const elChips    = document.getElementById('nowChips');

// Ubah teks, dan beri efek berkedip hanya kalau nilainya benar-benar berubah
function setText(el, val) {
  val = String(val);
  if (el.textContent === val) return;
  el.textContent = val;
  el.classList.remove('flash');
  void el.offsetWidth;
  el.classList.add('flash');
}

async function refreshStatus() {
  try {
    const res = await fetch('index.php?api=1', { cache: 'no-store' });
    if (!res.ok) return;
    const d = await res.json();

    setText(elDilayani, d.dipanggil.length ? d.dipanggil[0] : '-');
    setText(elMenunggu, d.menunggu);

    elChips.replaceChildren(...d.dipanggil.map(n => {
      const s = document.createElement('span');
      s.className = 'chip';
      s.textContent = n;
      return s;
    }));
    elPanel.hidden = d.dipanggil.length === 0;
  } catch (e) { /* abaikan gangguan jaringan sesaat */ }
}

setInterval(refreshStatus, 3000);   // update tiap 3 detik
</script>

<?php include __DIR__ . '/includes/footer.php'; ?>

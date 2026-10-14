<?php
require_once __DIR__ . '/includes/functions.php';

$pageTitle = 'Tentang';
include __DIR__ . '/includes/header.php';

$layanan = [
    ['icon' => 'bi-info-circle', 'nama' => 'Layanan Informasi Umum',        'ket' => 'Informasi kampus dan pengaduan umum'],
    ['icon' => 'bi-mortarboard', 'nama' => 'Layanan Akademik',              'ket' => 'KRS, KHS, transkrip, dan surat akademik'],
    ['icon' => 'bi-people',      'nama' => 'Layanan Kemahasiswaan',         'ket' => 'Beasiswa, organisasi, dan kegiatan mahasiswa'],
    ['icon' => 'bi-cash-coin',   'nama' => 'Layanan Keuangan & UKT',        'ket' => 'Pembayaran UKT dan keringanan biaya'],
    ['icon' => 'bi-hdd-network', 'nama' => 'Layanan Sistem Informasi & TIK', 'ket' => 'Akun SIAKAD, e-learning, dan jaringan'],
];
?>

<style>
  .tentang-page { max-width: 1100px; margin: 0 auto; padding: 50px 30px 70px; }
  .tentang-head { display: flex; align-items: center; justify-content: space-between; gap: 30px; margin-bottom: 30px; }
  .tentang-head h1 {
    font-size: 2.1rem; font-weight: 800; margin: 0;
    border-bottom: 3px solid var(--indigo); display: inline-block; padding-bottom: 10px;
  }
  .tentang-head .head-icon { font-size: 4.5rem; color: var(--blue-cyan); line-height: 1; }
  .tentang-intro { font-size: 1.05rem; line-height: 1.75; color: #374151; max-width: 820px; margin-bottom: 40px; }

  .tentang-grid { display: grid; grid-template-columns: 1.6fr 1fr; gap: 28px; align-items: start; }
  .section-title { font-size: 1.15rem; font-weight: 800; margin: 0 0 16px; }

  .svc-list { display: grid; gap: 12px; }
  .svc-item {
    display: flex; align-items: center; gap: 16px;
    background: #fff; border-radius: 14px; padding: 14px 18px;
    border-left: 5px solid var(--indigo);
    box-shadow: 0 4px 14px rgba(0,0,0,0.06);
  }
  .svc-item .ico {
    flex-shrink: 0; width: 46px; height: 46px; border-radius: 12px;
    background: var(--navy-dark); color: #fff;
    display: flex; align-items: center; justify-content: center; font-size: 1.4rem;
  }
  .svc-item .nama { font-weight: 700; }
  .svc-item .ket  { font-size: .85rem; color: #6b7280; }

  .jam-card { background: var(--navy-dark); color: #fff; border-radius: 20px; padding: 26px; box-shadow: var(--shadow-hard); }
  .jam-card h3 { margin: 0 0 16px; font-size: 1.05rem; letter-spacing: .5px; }
  .jam-row { display: flex; justify-content: space-between; gap: 12px; padding: 10px 0; border-bottom: 1px solid rgba(255,255,255,0.15); font-size: .92rem; }
  .jam-row:last-child { border-bottom: none; }
  .jam-row .waktu { font-weight: 700; color: #7dd3fc; text-align: right; }
  .jam-row .tutup { font-weight: 700; color: #fca5a5; text-align: right; }

  .tentang-cta { text-align: center; margin-top: 50px; }
  .tentang-cta p { color: #4b5563; margin-bottom: 16px; }

  @media (max-width: 860px) {
    .tentang-page { padding: 30px 18px 50px; }
    .tentang-head h1 { font-size: 1.4rem; }
    .tentang-head .head-icon { font-size: 3rem; }
    .tentang-grid { grid-template-columns: 1fr; }
  }
</style>

<main class="tentang-page">

  <div class="tentang-head">
    <h1>TENTANG UNIT LAYANAN TERPADU</h1>
    <i class="bi bi-headset head-icon"></i>
  </div>

  <p class="tentang-intro">
    Unit Layanan Terpadu (ULT) Universitas Negeri Manado adalah pusat pelayanan administrasi
    dan informasi terpadu satu pintu. ULT hadir untuk mempermudah civitas akademika dan
    masyarakat dalam mengurus berbagai kebutuhan kampus secara efisien, transparan, dan akuntabel.
  </p>

  <div class="tentang-grid">

    <section>
      <h2 class="section-title">Pelayanan</h2>
      <div class="svc-list">
        <?php foreach ($layanan as $l): ?>
          <div class="svc-item">
            <div class="ico"><i class="bi <?= e($l['icon']) ?>"></i></div>
            <div>
              <div class="nama"><?= e($l['nama']) ?></div>
              <div class="ket"><?= e($l['ket']) ?></div>
            </div>
          </div>
        <?php endforeach; ?>
      </div>
    </section>

    <aside>
      <div class="jam-card">
        <h3><i class="bi bi-clock"></i> JAM LAYANAN</h3>
        <div class="jam-row"><span>Senin &ndash; Kamis</span><span class="waktu">08.00 &ndash; 16.00 WITA</span></div>
        <div class="jam-row"><span>Jumat</span><span class="waktu">08.00 &ndash; 16.30 WITA</span></div>
        <div class="jam-row"><span>Sabtu, Minggu &amp; Libur Nasional</span><span class="tutup">Tutup</span></div>
      </div>
    </aside>

  </div>


  OPSIONAL: Bagian kontak. Hapus tanda komentar ini lalu isi data yang benar.

  <section style="margin-top:40px;">
    <h2 class="section-title">Kontak &amp; Lokasi</h2>
    <p><i class="bi bi-geo-alt"></i> ISI ALAMAT KANTOR ULT</p>
    <p><i class="bi bi-telephone"></i> ISI NOMOR TELEPON</p>
    <p><i class="bi bi-envelope"></i> ISI EMAIL</p>
  </section>
  -->



</main>

<?php include __DIR__ . '/includes/footer.php'; ?>

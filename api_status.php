<?php
require_once __DIR__ . '/includes/functions.php';

header('Content-Type: application/json; charset=utf-8');
header('Cache-Control: no-store');

// Nomor yang sedang dipanggil/dilayani hari ini (maksimal 3, terbaru dulu)
$stmt = $pdo->query(
    "SELECT a.nomor_tiket              -- GANTI jika nama kolom berbeda
     FROM antrian a
     WHERE a.status IN ('dipanggil','dilayani')
       AND a.tanggal_antrian = CURDATE()
     ORDER BY a.dipanggil_at DESC
     LIMIT 3"
);
$dipanggil = array_column($stmt->fetchAll(), 'nomor_tiket');   // GANTI jika berbeda

echo json_encode([
    'dipanggil' => $dipanggil,
    'menunggu'  => getTotalMenunggu($pdo),
]);

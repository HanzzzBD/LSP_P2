<?php
session_start();

$file = __DIR__ . '/data/data_pemesanan.json';

//Instruksi 2d Pembuatan Array
$jenis_barang = [
    "Buku",
    "Pulpen",
    "Pensil",
    "Penghapus",
];


//Instruksi 2e mengurutkan array
sort($jenis_barang);

//Instruksi 2g dan 2h untuk membuat fungsi hitung_total_tagihan dan perhitungan diskon
function hitung_total_tagihan($harga_satuan, $jumlah_barang)
{
    $total = $harga_satuan * $jumlah_barang;

    if ($total > 50000) {
        $total_diskon = $total - ($total * 0.1); // Menghitung diskon 10%
        return $total_diskon;
    }
    return $total;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['pesan'])) {
    $nama = $_POST["nama"];
    $no_hp = $_POST["no_hp"];
    $barang_pesanan = $_POST["barang"];
    $jumlah_barang = (int)$_POST["jumlah"];

    //Instruksi 2f penentuan $harga_satuan berdasarkan jenis barang menggunakan kontrol percabangan
    switch ($barang_pesanan) {
        case "Buku":
            $harga_satuan = 5000;
            break;
        case "Pulpen":
            $harga_satuan = 3000;
            break;
        case "Pensil":
            $harga_satuan = 2000;
            break;
        case "Penghapus":
            $harga_satuan = 1500;
            break;
        default:
            $harga_satuan = 0;
    }

    $total_biaya = hitung_total_tagihan($harga_satuan, $jumlah_barang);
    $data = [
        "Nama_Pemesan" => $nama,
        "No_Hp" => $no_hp,
        "Jenis Barang" => $barang_pesanan,
        "Jumlah" => $jumlah_barang,
        "Total_Biaya" => $total_biaya
    ];

    //Instruksi 3a menyimpan data pemesanan ke dalam file JSON
    $data_lama = [];
    if (file_exists($file)) {
        $data_lama = json_decode(file_get_contents($file), true) ?? [];
    }
    $data_lama[] = $data;
    file_put_contents($file, json_encode($data_lama, JSON_PRETTY_PRINT));

    // Mengirimkan ke GET agar refresh tidak mengirim ulang pemesanan.
    $_SESSION['pemesanan_berhasil'] = $data;
    header('Location: index.php', true, 303);
    exit;
}

$pemesanan_berhasil = $_SESSION['pemesanan_berhasil'] ?? null;
unset($_SESSION['pemesanan_berhasil']);
?>

<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Pemesanan Alat Tulis Kantor</title>
    <!-- Instruksi 1a menghubungkan file css dengan halaman website -->
    <link rel="stylesheet" href="css/bootstrap.css">
    <link rel="stylesheet" href="css/pemesanan.css">
</head>

<body>
    <div class="container mt-5">
        <div class="header mb-4 ">
            <!-- instruksi 1b menambahkan logo -->
            <img src="img/logo.png" alt="" class="w-100 h-100 me-3" style="max-width: 80px; max-height: 80px;">
            <h1 class="size-3">Pemesanan Alat Tulis Kantor</h1>
        </div>
        <form action="" method="POST">

            <div class="mb-3">
                <label for="nama" class="uiverse-pixel-input-wrapper">Nama Pelanggan</label>
                <input type="text" autocomplete="off" id="nama" name="nama" class="input" placeholder="Masukan Nama Anda" required>
            </div>

            <div class="mb-3">
                <label for="no_hp" class="uiverse-pixel-input-wrapper">No Hp</label>
                <!-- jangan ada lebih dari 14 angka dan jangan kurang dari 10 angka dan number ketika di scroll tidak berubah -->
                <input type="number" autocomplete="off" id="no_hp" name="no_hp" class="input" placeholder="Masukan No Hp" required>
            </div>

            <div class="mb-3">
                <label for="barang" class="uiverse-pixel-input-wrapper">Jenis Barang</label>
                <!-- instruksi 2c, menampilkan pilihan nama jenis barang -->
                <select class="form-select" id="barang" name="barang">
                    <?php foreach ($jenis_barang as $barang) : ?>
                        <option value="<?= $barang ?>"><?= $barang ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <div class="mb-3">
                <label for="jumlah" class="uiverse-pixel-input-wrapper">Jumlah Barang</label>
                <input type="number" autocomplete="off" id="jumlah" name="jumlah" class="input" placeholder="Masukan Jumlah Barang" min="0" oninput="this.value = Math.abs(this.value)">
            </div>

            <button type="submit" class="btn btn-primary" name="pesan">Kirim Pemesanan</button>
        </form>

        <?php
        if ($pemesanan_berhasil !== null) {
            echo "<div class='alert alert-success mt-4'>
        <h5>Pemesanan Berhasil:</h5>
        <strong>Nama Pelanggan:</strong> " . htmlspecialchars($pemesanan_berhasil['Nama_Pemesan']) . "<br>
        <strong>No Hp:</strong> " . htmlspecialchars($pemesanan_berhasil['No_Hp']) . "<br>
        <strong>Jenis Barang:</strong> " . htmlspecialchars($pemesanan_berhasil['Jenis Barang']) . "<br>
        <strong>Jumlah Barang:</strong> " . htmlspecialchars($pemesanan_berhasil['Jumlah']) . " <br>
        <strong>Total Tagihan:</strong> Rp " . number_format($pemesanan_berhasil['Total_Biaya'], 0, ',', '.') . "<br>
        </div>";
        }
        //Instruksi 3b menampilkan data pemesanan dari file JSON
        $data_pemesanan = file_exists($file)
            ? (json_decode(file_get_contents($file), true) ?? [])
            : [];
        ?>

        <section class="mt-5 mb-5" aria-labelledby="judul-pemesanan">
            <div class="d-flex align-items-center justify-content-between gap-3 mb-3">
                <h2 id="judul-pemesanan" class="h4 mb-0">Data Pemesanan</h2>
                <span class="small text-body-secondary text-nowrap"><?= count($data_pemesanan) ?> pesanan</span>
            </div>

            <div class="table-responsive orders-table-wrapper" role="region" aria-labelledby="judul-pemesanan" tabindex="0">
                <table class="table table-hover align-middle orders-table">
                    <caption class="visually-hidden">Daftar pemesanan alat tulis kantor</caption>
                    <thead>
                        <tr>
                            <th scope="col">Nama Pelanggan</th>
                            <th scope="col">No. HP</th>
                            <th scope="col">Jenis Barang</th>
                            <th scope="col" class="text-end">Jumlah</th>
                            <th scope="col" class="text-end">Total Biaya</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if ($data_pemesanan === []) : ?>
                            <tr>
                                <td colspan="5" class="text-center text-body-secondary py-4">Belum ada pemesanan.</td>
                            </tr>
                        <?php else : ?>
                            <?php foreach ($data_pemesanan as $pemesanan) : ?>
                                <tr>
                                    <td><?= htmlspecialchars($pemesanan['Nama_Pemesan']) ?></td>
                                    <td class="text-nowrap"><?= htmlspecialchars($pemesanan['No_Hp']) ?></td>
                                    <td><?= htmlspecialchars($pemesanan['Jenis Barang']) ?></td>
                                    <td class="text-end orders-number"><?= htmlspecialchars($pemesanan['Jumlah']) ?></td>
                                    <td class="text-end text-nowrap fw-semibold orders-number">Rp <?= number_format($pemesanan['Total_Biaya'], 0, ',', '.') ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</body>

</html>

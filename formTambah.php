<?php
include('config/db.php');
include('classes/DB.php');
include('classes/Peminjam.php');
include('classes/Transaksi.php');
include('classes/Buku.php');
include('classes/Template.php');

// Create instances for transactions and borrowers
$transaksi = new Transaksi($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$transaksi->open();
$transaksi->getTransaksi();

$peminjam = new Peminjam($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$peminjam->open();
$peminjam->getPeminjam();

$listBuku = new Buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$listBuku->open();
$listBuku->getBuku();

if (isset($_POST['btn-simpan'])) {
    $data = [
        'fileName' => $_FILES['fileName']['name'],
        'judul' => $_POST['judul'],
        'penulis' => $_POST['penulis'],
        'status' => $_POST['status'],
    ];
    if (isset($_FILES['fileName'])) {
        echo 'berhasil';
    } else {
        // Variabel $_FILES['fileName'] tidak ada
        // Tampilkan pesan kesalahan
        echo 'gagal';
    }

    $file = $_FILES['fileName'];

    $result = $listBuku->addBuku($data, $file);

    if ($result > 0) {
        echo "<script>
        alert('Data berhasil ditambahkan');
        document.location.href = 'index.php';
        </script>";
    } else {
        echo '<script> alert("Data gagal ditambahkan!");</script>';
    }
}

$peminjamData = '';
while ($pjam = $peminjam->getResult()) {
    $peminjamData .= '<option value="' . $pjam['peminjam_id'] . '">' . $pjam['peminjam_nama'] . '</option>';
}

$transaksiData = '';
while ($tsk = $transaksi->getResult()) {
    $transaksiData .= '<option value="' . $tsk['transaksi_id'] . '">' . $tsk['transaksi_id'] . '</option>';
}
$title = 'Tambah';
$formData = '
<label for="judul">Judul Buku</label>
<input type="text" id="judul" name="judul" placeholder="Judul buku..">

<label for="penulis">Penulis</label>
<input type="text" id="penulis" name="penulis" placeholder="Nama penulis..">

<label for="uploadFoto">Foto Buku</label>
<input type="file" id="uploadFoto" name="uploadFoto" placeholder="filefoto.jpg/png">
<br>

<label for="status">Status</label>
<select id="status" name="status">
    <option value="tersedia">Tersedia</option>
    <option value="dipinjam">Dipinjam</option>
</select>
';

// Load the template
$view = new Template('templates/skinform.html');
$view->replace('DATA_FORM', $formData);
$view->replace('TITLE', $title);

// Close connections
$listBuku->close();
$peminjam->close();
$transaksi->close();

$view->write();

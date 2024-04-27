<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Transaksi.php');
include('classes/Template.php');

$transaksi = new Transaksi($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$transaksi->open();
$transaksi->getTransaksi();

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($divisi->addTransaksi($_POST) > 0) { 
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'transaksi.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'transaksi.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Transaksi';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Transaksi ID</th>
<th scope="row">Tanggal Pinjam</th>
<th scope="row">Tanggal Kembali</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'transaksi';

while ($div = $transaksi->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['transaksi_id'] . '</td>
    <td>' . $div['tanggal_pinjam'] . '</td> 
    <td>' . $div['tanggal_kembali'] . '</td> 
    
    <td style="font-size: 22px;">
    <a href="transaksi.php?id=' . $div['transaksi_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="transaksi.php?hapus=' . $div['transaksi_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($transaksi->updateTransaksi($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'transaksi.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'transaksi.php';
            </script>";
            }
        }

        $transaksi->getTransaksiById($id);
        $row = $transaksi->getResult();

        $dataUpdate = $row['transaksi_id'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($transaksi->deleteTransaksi($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'transaksi.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'transaksi.php';
            </script>";
        }
    }
}

$transaksi->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();

<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Peminjam.php');
include('classes/Template.php');

$peminjam = new Peminjam($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$peminjam->open();
$peminjam->getPeminjam();

if (!isset($_GET['id'])) {
    if (isset($_POST['submit'])) {
        if ($divisi->addPeminjam($_POST) > 0) { 
            echo "<script>
                alert('Data berhasil ditambah!');
                document.location.href = 'peminjam.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal ditambah!');
                document.location.href = 'peminjam.php';
            </script>";
        }
    }

    $btn = 'Tambah';
    $title = 'Tambah';
}

$view = new Template('templates/skintabel.html');

$mainTitle = 'Peminjam';
$header = '<tr>
<th scope="row">No.</th>
<th scope="row">Nama Anggota</th>
<th scope="row">Alamat</th>
<th scope="row">No Telepon</th>
<th scope="row">Aksi</th>
</tr>';
$data = null;
$no = 1;
$formLabel = 'peminjam';

while ($div = $peminjam->getResult()) {
    $data .= '<tr>
    <th scope="row">' . $no . '</th>
    <td>' . $div['peminjam_nama'] . '</td>
    <td>' . $div['peminjam_alamat'] . '</td> 
    <td>' . $div['peminjam_telp'] . '</td> 
    
    <td style="font-size: 22px;">
    <a href="peminjam.php?id=' . $div['peminjam_id'] . '" title="Edit Data"><i class="bi bi-pencil-square text-warning"></i></a>&nbsp;<a href="peminjam.php?hapus=' . $div['peminjam_id'] . '" title="Delete Data"><i class="bi bi-trash-fill text-danger"></i></a>
        </td>
    </tr>';
    $no++;
}

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        if (isset($_POST['submit'])) {
            if ($peminjam->updatePeminjam($id, $_POST) > 0) {
                echo "<script>
                alert('Data berhasil diubah!');
                document.location.href = 'peminjam.php';
            </script>";
            } else {
                echo "<script>
                alert('Data gagal diubah!');
                document.location.href = 'peminjam.php';
            </script>";
            }
        }

        $peminjam->getPeminjamById($id);
        $row = $peminjam->getResult();

        $dataUpdate = $row['peminjam_nama'];
        $btn = 'Simpan';
        $title = 'Ubah';

        $view->replace('DATA_VAL_UPDATE', $dataUpdate);
    }
}

if (isset($_GET['hapus'])) {
    $id = $_GET['hapus'];
    if ($id > 0) {
        if ($peminjam->deletePeminjam($id) > 0) {
            echo "<script>
                alert('Data berhasil dihapus!');
                document.location.href = 'peminjam.php';
            </script>";
        } else {
            echo "<script>
                alert('Data gagal dihapus!');
                document.location.href = 'peminjam.php';
            </script>";
        }
    }
}

$peminjam->close();

$view->replace('DATA_MAIN_TITLE', $mainTitle);
$view->replace('DATA_TABEL_HEADER', $header);
$view->replace('DATA_TITLE', $title);
$view->replace('DATA_BUTTON', $btn);
$view->replace('DATA_FORM_LABEL', $formLabel);
$view->replace('DATA_TABEL', $data);
$view->write();

<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Peminjam.php');
include('classes/Transaksi.php');
include('classes/Buku.php');
include('classes/Template.php');

$buku = new Buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$buku->open();

$data = nulL;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    if ($id > 0) {
        $buku->getBukuById($id);
        $row = $buku->getResult();
            $data .= '<div class="card-header text-center">
            <h3 class="my-0">Detail Buku ' . $row['buku_judul'] . '</h3>
            </div>
            <div class="card-body text-end">
                <div class="row mb-5">
                    <div class="col-3">
                        <div class="row justify-content-center">
                            <img src="assets/images/' . $row['buku_foto'] . '" class="img-thumbnail" alt="' . $row['buku_foto'] . '" width="60">
                            </div>
                        </div>
                        <div class="col-9">
                            <div class="card px-3">
                                <table border="0" class="text-start">
                                    <tr>
                                        <td>Judul</td>
                                        <td>:</td>
                                        <td>' . $row['buku_judul'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>Penulis</td>
                                        <td>:</td>
                                        <td>' . $row['buku_penulis'] . '</td>
                                    </tr>
                                    <tr>
                                        <td>Status</td>
                                        <td>:</td>
                                        <td>' . $row['buku_status'] . '</td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer text-end">
                    <a href="formEdit.php"><button type="button" class="btn btn-success text-white">Ubah Data</button></a>
                    <a href="#"><button type="button" class="btn btn-danger">Hapus Data</button></a>
                </div>';
    }
}


$buku->close();
$detail = new Template('templates/skindetail.html');
$detail->replace('DATA_DETAIL_PENGURUS', $data);
$detail->write();

<?php

include('config/db.php');
include('classes/DB.php');
include('classes/Peminjam.php');
include('classes/Transaksi.php');
include('classes/Buku.php');
include('classes/Template.php');

// buat instance pengurus
$listBukuPunya = new Buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
$listBukuSedia = new Buku($DB_HOST, $DB_USERNAME, $DB_PASSWORD, $DB_NAME);
// buka koneksi
$listBukuPunya->open();
$listBukuSedia->open();
// tampilkan data pengurus
$listBukuPunya->getBukuJoin();
$listBukuSedia->getBuku();


// cari pengurus
if (isset($_POST['btn-cari'])) {
    // methode mencari data pengurus
    $listBukuSedia->searchBuku($_POST['cari']);
} else {
    // method menampilkan data pengurus
    $listBukuPunya->getBukuJoin();
    $listBukuSedia->getBuku();
}

$data = null;

// ambil data pengurus
// gabungkan dgn tag html
// untuk di passing ke skin/template
while (($rowSedia = $listBukuSedia->getResult()) && ($rowPunya = $listBukuPunya->getResult())) {
    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 pengurus-thumbnail">
        <a href="detail.php?id=' . $rowPunya['buku_id'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $rowPunya['buku_foto'] . '" class="card-img-top" alt="' . $rowPunya['buku_foto'] . '">
            </div>
            <div class="card-body">
                <p class="card-text pengurus-nama my-0">' . $rowPunya['buku_judul'] . '</p>
                <p class="card-text divisi-nama">' . $rowPunya['buku_penulis'] . '</p>
                <p class="card-text jabatan-nama my-0">' . $rowPunya['buku_status'] . '</p>
            </div>
        </a>
    </div>    
    </div>'; 

    $data .= '<div class="col gx-2 gy-3 justify-content-center">' .
        '<div class="card pt-4 px-2 pengurus-thumbnail">
        <a href="detail.php?id=' . $rowSedia['buku_id'] . '">
            <div class="row justify-content-center">
                <img src="assets/images/' . $rowSedia['buku_foto'] . '" class="card-img-top" alt="' . $rowSedia['buku_foto'] . '">
            </div>
            <div class="card-body">
                <p class="card-text pengurus-nama my-0">' . $rowSedia['buku_judul'] . '</p>
                <p class="card-text divisi-nama">' . $rowSedia['buku_penulis'] . '</p>
                <p class="card-text jabatan-nama my-0">' . $rowSedia['buku_status'] . '</p>
            </div>
        </a>
    </div>    
    </div>';
}

// tutup koneksi
$listBukuSedia->close();
$listBukuPunya->close();

// buat instance template
$home = new Template('templates/skin.html');

// simpan data ke template
$home->replace('DATA_PENGURUS', $data);
$home->write();

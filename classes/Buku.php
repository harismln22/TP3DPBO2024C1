<?php

// pengurus menjadi buku
class Buku extends DB
{
    function getBukuJoin()
    {
        $query = "SELECT * FROM buku JOIN peminjam ON buku.peminjam_id=peminjam.peminjam_id JOIN transaksi ON buku.transaksi_id=transaksi.transaksi_id ORDER BY buku.buku_id";
        //$query = "SELECT * FROM pengurus JOIN divisi ON pengurus.divisi_id=divisi.divisi_id JOIN jabatan ON pengurus.jabatan_id=jabatan.jabatan_id ORDER BY pengurus.pengurus_id";
        return $this->execute($query);
    }

    function getBuku()
    {
        $query = "SELECT * FROM buku";
        return $this->execute($query);
    }

    function getBukuById($id)
    {
        $query = "SELECT * FROM buku WHERE buku_id=$id";
        return $this->execute($query);
    }

    function searchBuku($keyword)
    {
        $query = "SELECT * FROM buku WHERE buku_judul LIKE '%$keyword%'";
        return $this->execute($query);
    }

    function addBuku($data, $file)
    {
        $judul = $data['judul'];
        $penulis = $data['penulis'];
        $status = $data['status'];
        $file = $data['fileName'];
        
        $sql = "INSERT INTO buku (buku_foto, buku_judul, buku_penulis, buku_status, transaksi_id, peminjam_id)
                VALUES ('$file', '$judul', '$penulis', '$status', 1, 1)";

        if ($this->executeAffected($sql)) {
            return true;
        } else {
            return false;
        }
    }



    function updateBuku($id, $data, $file)
    {
        $query = "UPDATE buku SET buku_judul='$data[buku_judul]', buku_penulis='$data[buku_penulis]', buku_status='$data[buku_status]', buku_foto='$file[buku_foto] WHERE buku_id=$id";
        if ($this->execute($query)) {
            return true; 
        } else {
            return false;
        }
    }

    function deleteBuku($id)
    {
        $query = "DELETE FROM buku WHERE buku_id=$id";
        return $this->execute($query);
    }
}


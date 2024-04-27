<?php
// divisi 
class Peminjam extends DB
{
    function getPeminjam()
    {
        $query = "SELECT * FROM peminjam";
        return $this->execute($query);
    }

    function getPeminjamById($id)
    {
        $query = "SELECT * FROM peminjam WHERE peminjam_id=$id";
        return $this->execute($query);
    }

    function addPeminjam($data)
    {
        $nama = $data['peminjam_nama'];
        $alamat = $data['peminjam_alamat'];
        $telepon = $data['peminjam_telp'];
        $query = "INSERT INTO divisi VALUES('', '$nama', '$alamat', '$telepon')";
        return $this->executeAffected($query);
    }

    function updatePeminjam($id, $data)
    {
        $nama = $data['peminjam_nama'];
        $alamat = $data['peminjam_alamat'];
        $telepon = $data['peminjam_telp'];
        $query = "UPDATE peminjam SET peminjam_nama='$nama', peminjam_alamat='$alamat', peminjam_telp='$telepon' WHERE peminjam_id=$id";
        return $this->executeAffected($query);
    }

    function deletePeminjam($id)
    {
        $query = "DELETE FROM peminjam WHERE peminjam_id=$id";
        return $this->executeAffected($query);
    }

}

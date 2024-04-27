<?php

class Transaksi extends DB
{
    function getTransaksi()
    {
        $query = "SELECT * FROM transaksi";
        return $this->execute($query);
    }

    function getTransaksiById($id)
    {
        $query = "SELECT * FROM transaksi WHERE transaksi_id=$id";
        return $this->execute($query);
    }

    function addTransaksi($data)
    {
        $peminjam_id = $data["peminjam_id"];
        $tl_pinjam = $data["tanggal_pinjam"];
        $tl_kembali = $data["tanggal_kembali"];
        $query = "INSERT INTO transaksi ('', tanggal_pinjam, tanggal_kembali) VALUES('', '$tl_pinjam', '$tl_kembali')";
        return $this->executeAffected($query);
    }

    function updateTransaksi($id, $data)
    {
        $transaksi_id = $data['transaksi_id'];
        //$buku_id = $data["buku_id"];
        //$peminjam_id = $data["peminjam_id"];
        $tl_pinjam = $data["tanggal_pinjam"];
        $tl_kembali = $data["tanggal_kembali"];
        $query = "UPDATE transaksi SET transaksi_id='$transaksi_id', tanggal_pinjam='$tl_pinjam', tanggal_kembali='$tl_kembali' WHERE transaksi_id='$id'";
        return $this->executeAffected($query);
    }

    function deleteTransaksi($id)
    {
        $query = "DELETE FROM transaksi WHERE transaksi_id=$id";
        return $this->executeAffected($query);
    }
}
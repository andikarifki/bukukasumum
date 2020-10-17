<?php
$conn = mysqli_connect("localhost", "root", "", "project_andhika");

function query($query)
{
    global $conn;
    $result = mysqli_query($conn, $query);
    $row = [];
    while ($row = mysqli_fetch_assoc($result)){
        $rows[] = $row;
    }
    return $rows;
}

function tambah($data)
{
    global $conn;

    $kd_rek      = $data['kd_rek'];
    $nama_bagian = $data['nama_bagian'];

    $query = "INSERT INTO kode_rekening VALUES
            ('$kd_rek','$nama_bagian')
    ";

    mysqli_query($conn, $query);

    return mysqli_affected_rows($conn);
}

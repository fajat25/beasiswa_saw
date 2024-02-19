<?php
session_start();
$conn = mysqli_connect("localhost","root","","beasiswa");
//  coding test koneksi
// if ($conn) {
//     echo "sukses!";
// }

if(isset($_POST["addbeasiswa"])){
    $userid = $_POST["beasiswa"];
    $ser = $_POST["kode"];
    $j = $_POST["jenis"];
    $s = $_POST["syarat"];
    $l = $_POST["line"];

    $addtotable = mysqli_query($conn,"insert into data_beasiswa (nama_beasiswa, kode_beasiswa, jenisb, syaratb, lineb) values('$userid','$ser','$j','$s','$l')");
    if($addtotable){
        echo "berhasil gaes";
        header("location:data_beasiswa.php");
    } else{
        echo "Gagal";
        header("location:index.html");
    }
}
// Periksa apakah data dikirim melalui metode POST dengan nama variabel "nor"
if (isset($_POST["nor"])) {
    // Ambil id_beasiswa dari form yang dikirim oleh pengguna
    $selected_beasiswa_id = $_POST["id_beasiswa"];

    // Ambil semua data siswa yang mengikuti beasiswa yang dipilih
    $query = mysqli_query($conn, "SELECT * FROM data_siswa WHERE id_beasiswa='$selected_beasiswa_id'");

    // Inisialisasi array untuk menyimpan nilai maksimum tiap kriteria berdasarkan id_siswa
    $max_values = array();

    // Menghitung nilai maksimum dari setiap kriteria di antara semua siswa yang mengikuti beasiswa tersebut
    while ($row = mysqli_fetch_assoc($query)) {
        $id_siswa = $row['id_siswa'];
        $p_ortu = $row['p_ortu'];
        $t_ortu = $row['t_ortu'];
        $s_kandung = $row['s_kandung'];
        $n_sem = $row['n_sem'];
        $p_kelas = $row['p_kelas'];

        // Lakukan perhitungan nilai total kriteria untuk setiap siswa
        $nilai_total = max($p_ortu, $t_ortu, $s_kandung, $n_sem, $p_kelas);

        // Simpan nilai total kriteria ke dalam array berdasarkan id_siswa
        $max_values[$id_siswa] = $nilai_total;
    }

    // Kembali ke awal hasil query
    mysqli_data_seek($query, 0);

    // Normalisasi setiap nilai di setiap kriteria (kolom) berdasarkan nilai maksimum
    while ($row = mysqli_fetch_assoc($query)) {
        $id_siswa = $row['id_siswa'];
        $id_user = $row['id_user'];

        // Ambil nilai maksimum untuk id_siswa tertentu
        $max = $max_values[$id_siswa];

        // Normalisasi setiap nilai kriteria (kolom) berdasarkan nilai maksimum
        $p_ortuu = $row['p_ortu'] / $max;
        $t_ortuu = $row['t_ortu'] / $max;
        $s_kandungg = $row['s_kandung'] / $max;
        $n_semm = $row['n_sem'] / $max;
        $p_kelass = $row['p_kelas'] / $max;

        // Simpan nilai normalisasi ke dalam tabel normalisasi
        $addtotable = mysqli_query($conn, "INSERT INTO normalisasi (id_siswa, id_beasiswa, id_user, p_ortu, t_ortu, s_kandung, n_sem, p_kelas) 
                                          VALUES ('$id_siswa','$selected_beasiswa_id', '$id_user','$p_ortuu', '$t_ortuu', '$s_kandungg', '$n_semm', '$p_kelass')");
    }

    if ($addtotable) {
        echo "Berhasil menghitung dan melakukan normalisasi untuk siswa yang mengikuti beasiswa tersebut.";
        header("location:normalisasi.php");
    } else {
        echo "Gagal melakukan normalisasi.";
        header("location:index.html");
    }
}




if (isset($_POST[""])) {
    // Ambil semua data siswa dan nilai beasiswa dari tabel data_siswa
    $query = mysqli_query($conn, "SELECT * FROM data_siswa");
    
    // Inisialisasi array untuk menyimpan nilai maksimum dari setiap kolom untuk setiap beasiswa
    $max_values = array();

    // Menghitung nilai maksimum dari setiap kolom berdasarkan beasiswa yang diikuti
    while ($row = mysqli_fetch_assoc($query)) {
        $id_beasiswa = $row['id_beasiswa'];
        
        if (!isset($max_values[$id_beasiswa])) {
            // Inisialisasi nilai maksimum untuk setiap beasiswa
            $max_values[$id_beasiswa] = array(
                'p_ortu' => 0,
                't_ortu' => 0,
                's_kandung' => 0,
                'n_sem' => 0,
                'p_kelas' => 0
            );
        }

        // Update nilai maksimum untuk setiap beasiswa
        $max_values[$id_beasiswa]['p_ortu'] = max($max_values[$id_beasiswa]['p_ortu'], $row['p_ortu']);
        $max_values[$id_beasiswa]['t_ortu'] = max($max_values[$id_beasiswa]['t_ortu'], $row['t_ortu']);
        $max_values[$id_beasiswa]['s_kandung'] = max($max_values[$id_beasiswa]['s_kandung'], $row['s_kandung']);
        $max_values[$id_beasiswa]['n_sem'] = max($max_values[$id_beasiswa]['n_sem'], $row['n_sem']);
        $max_values[$id_beasiswa]['p_kelas'] = max($max_values[$id_beasiswa]['p_kelas'], $row['p_kelas']);
    }
    
    // Kembali ke awal hasil query
    mysqli_data_seek($query, 0);
    
    // Normalisasi setiap nilai di setiap kolom berdasarkan nilai maksimum untuk setiap beasiswa
    while ($row = mysqli_fetch_assoc($query)) {
        $id_beasiswa = $row['id_beasiswa'];
        $id_siswa = $row['id_siswa'];

        // Mengambil nilai maksimum untuk beasiswa yang diikuti siswa tersebut
        $max_p_ortu = $max_values[$id_beasiswa]['p_ortu'];
        $max_t_ortu = $max_values[$id_beasiswa]['t_ortu'];
        $max_s_kandung = $max_values[$id_beasiswa]['s_kandung'];
        $max_n_sem = $max_values[$id_beasiswa]['n_sem'];
        $max_p_kelas = $max_values[$id_beasiswa]['p_kelas'];

        // Normalisasi setiap nilai berdasarkan nilai maksimum beasiswa
        $p_ortuu = $row['p_ortu'] / $max_p_ortu;
        $t_ortuu = $row['t_ortu'] / $max_t_ortu;
        $s_kandungg = $row['s_kandung'] / $max_s_kandung;
        $n_semm = $row['n_sem'] / $max_n_sem;
        $p_kelass = $row['p_kelas'] / $max_p_kelas;

        // Simpan nilai normalisasi ke dalam tabel normalisasi
        $addtotable = mysqli_query($conn, "INSERT INTO normalisasi (id_siswa, p_ortu, t_ortu, s_kandung, n_sem, p_kelas) 
                                          VALUES ('$id_siswa', '$p_ortuu', '$t_ortuu', '$s_kandungg', '$n_semm', '$p_kelass')");
        
        // Perbarui nilai-nilai di tabel data_siswa dengan nilai ternormalisasi
        $updatestockmasuk = mysqli_query($conn, "UPDATE data_siswa 
                                                 SET p_ortu='$p_ortuu', t_ortu='$t_ortuu', s_kandung='$s_kandungg', 
                                                     n_sem='$n_semm', p_kelas='$p_kelass' 
                                                 WHERE id_siswa='$id_siswa'");
    }

    if ($addtotable && $updatestockmasuk) {
        echo "Berhasil menghitung dan melakukan normalisasi untuk semua siswa berdasarkan beasiswa yang diikuti.";
        header("location:normalisasi.php");
    } else {
        echo "Gagal melakukan normalisasi.";
        header("location:index.html");
    }
}

if (isset($_POST[""])) {
    $selected_beasiswa_id = $_POST["id_beasiswa"];

    $cekstocksekarang = mysqli_query($conn, "SELECT MAX(p_ortu) as max_p_ortu, MAX(t_ortu) as max_t_ortu, MAX(s_kandung) as max_s_kandung, MAX(n_sem) as max_n_sem, MAX(p_kelas) as max_p_kelas FROM data_siswa WHERE id_beasiswa='$selected_beasiswa_id' ORDER BY id_siswa DESC");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $p_ortu = $ambildatanya['max_p_ortu'];
    $t_ortu = $ambildatanya['max_t_ortu'];
    $s_kandung = $ambildatanya['max_s_kandung'];
    $n_sem = $ambildatanya['max_n_sem'];
    $p_kelas = $ambildatanya['max_p_kelas'];

    // Menghitung nilai maksimum dari kolom-kolom tersebut
    $stocksekarang = max($p_ortu, $t_ortu, $s_kandung, $n_sem, $p_kelas);

    mysqli_data_seek($cekstocksekarang, 0);
    // Menghindari pembagian dengan nol
    while ($row = mysqli_fetch_assoc($cekstocksekarang)) {
        $id_siswa = $row['id_siswa'];

        $p_ortuu = $row['p_ortu'] / $stocksekarang;
        $t_ortuu = $row['t_ortu'] / $stocksekarang;
        $s_kandungg = $row['s_kandung'] / $stocksekarang;
        $n_semm = $row['n_sem'] / $stocksekarang;
        $p_kelass = $row['p_kelas'] / $stocksekarang;

        $addtotable = mysqli_query($conn, "INSERT INTO normalisasi (id_siswa, p_ortu, t_ortu, s_kandung, n_sem, p_kelas) VALUES ('$seri','$p_ortuu','$t_ortuu','$s_kandungg','$n_semm','$p_kelass')");
    }
        if ($addtotable) {
            echo "Berhasil menghitung dan melakukan normalisasi untuk siswa yang mengikuti beasiswa tersebut.";
            header("location:normalisasi.php");
        } else {
            echo "Gagal";
            header("location:index.html");
        }
}


if(isset($_POST["addbobot"])){
    $userid = $_POST["nama_beasiswa"];
    $ser = $_POST["p_ortu"];
    $brandtype = $_POST["t_ortu"];
    $brand = $_POST["s_kandung"];
    $bra = $_POST["n_sem"];
    $b = $_POST["p_kelas"];
    $addtotable = mysqli_query($conn,"insert into bobot_beasiswa (id_beasiswa, p_ortu, t_ortu,  s_kandung, n_sem, p_kelas) values('$userid','$ser','$brandtype','$brand','$bra','$b')");
    if($addtotable){
        echo "berhasil gaes";
        header("location:data_bobot.php");
    } else{
        echo "Gagal";
        header("location:index.html");
    }
}


if (isset($_POST["hitung"])) {
    $id_beasiswa = $_POST["id_beasiswa"];
    $kuota = $_POST["kuota"];

    // Query untuk mengambil data bobot beasiswa berdasarkan id_beasiswa yang dipilih
    $query_bobot = mysqli_query($conn, "SELECT p_ortu, t_ortu, s_kandung, n_sem, p_kelas FROM bobot_beasiswa WHERE id_beasiswa = '$id_beasiswa'");
    if ($query_bobot && mysqli_num_rows($query_bobot) > 0) {
        $bobot_beasiswa = mysqli_fetch_array($query_bobot);

        // Query untuk mengambil data normalisasi siswa berdasarkan id_beasiswa yang dipilih
        $query_normalisasi = mysqli_query($conn, "SELECT id_siswa, p_ortu, t_ortu, s_kandung, n_sem, p_kelas FROM normalisasi WHERE id_beasiswa = '$id_beasiswa'");

        // Array untuk menyimpan nilai hasil perhitungan per siswa
        $hasil_perhitungan = array();

        while ($data_siswa = mysqli_fetch_array($query_normalisasi)) {
            // Mengambil data dari normalisasi untuk perhitungan
            $id_siswa = $data_siswa['id_siswa'];

            // Cek apakah siswa sudah tercatat dalam tabel p_akhir
            $query_cek_p_akhir = mysqli_query($conn, "SELECT * FROM p_akhir WHERE id_siswa = '$id_siswa' AND id_beasiswa = '$id_beasiswa'");
            $count_cek_p_akhir = $query_cek_p_akhir ? mysqli_num_rows($query_cek_p_akhir) : 0;

            if ($count_cek_p_akhir == 0) {
                // Jika siswa belum tercatat, lakukan perhitungan dan tambahkan ke tabel p_akhir
                $p_ortu = $data_siswa['p_ortu'];
                $t_ortu = $data_siswa['t_ortu'];
                $s_kandung = $data_siswa['s_kandung'];
                $n_sem = $data_siswa['n_sem'];
                $p_kelas = $data_siswa['p_kelas'];

                // Melakukan perhitungan berdasarkan bobot beasiswa
                $p_ortuuu = $bobot_beasiswa['p_ortu'] * $p_ortu;
                $t_ortuuu = $bobot_beasiswa['t_ortu'] * $t_ortu;
                $s_kandunggg = $bobot_beasiswa['s_kandung'] * $s_kandung;
                $n_semmm = is_numeric($bobot_beasiswa['n_sem']) && is_numeric($n_sem) ? $bobot_beasiswa['n_sem'] * $n_sem : 0;
                $p_kelasss = is_numeric($bobot_beasiswa['p_kelas']) && is_numeric($p_kelas) ? $bobot_beasiswa['p_kelas'] * $p_kelas : 0;

                $hitung = array($p_ortuuu, $t_ortuuu, $s_kandunggg, $n_semmm, $p_kelasss);
                $hasil = array_sum($hitung);

                // Menambahkan hasil perhitungan ke dalam array $hasil_perhitungan
                $hasil_perhitungan[$id_siswa] = $hasil;

                // Insert hasil perhitungan ke dalam tabel p_akhir dan tampilkan notifikasi
                if (is_numeric($hasil)) {
                    if ($hasil >= 10) {
                        $keterangan_hasil = "Dapat Beasiswa";
                        $pesan = 'Selamat, Anda berhasil mendapatkan beasiswa!';
                    } else {
                        $keterangan_hasil = "Tidak Dapat Beasiswa";
                        $pesan = 'Maaf, Anda tidak berhasil mendapatkan beasiswa.';
                    }

                    mysqli_query($conn, "INSERT INTO p_akhir (id_siswa, id_beasiswa, keterangan, hasil, pesan) VALUES ('$id_siswa', '$id_beasiswa', '$keterangan_hasil', '$hasil','$pesan')");
                } else {
                    // Tampilkan pesan kesalahan jika nilai hasil perhitungan tidak valid
                    echo '<div class="alert alert-danger alert-dismissible fade show" role="alert">';
                    echo 'Nilai hasil perhitungan tidak valid.';
                    echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
                    echo '<span aria-hidden="true">&times;</span>';
                    echo '</button>';
                    echo '</div>';
                }
            } else {
                // Jika siswa sudah tercatat, lanjut ke siswa berikutnya
                continue;
            }
        }

        // ... (Kode lainnya seperti sebelumnya)

        if ($count_cek_p_akhir > 0)  {
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            echo 'Perhitungan akhir berhasil dilakukan dan notifikasi telah dikirim';
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';
        } else {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
            echo 'Tidak ada siswa yang mendapatkan beasiswa berdasarkan perhitungan ini';
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';
        }

    } else {
        // Jika data bobot beasiswa tidak ditemukan
        echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
        echo 'Tidak ada siswa yang mendapatkan beasiswa berdasarkan perhitungan ini';
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
        echo '</div>';
    }
}


if (isset($_POST["edit_beasiswa"])) {
    $id = $_POST['id'];
    $nama = $_POST['nama'];
    $kode = $_POST['kode'];
    $sb = $_POST['sb'];
    $jb = $_POST['jb'];
    $lb = $_POST['lb'];

    // Anda dapat menggunakan tanda kutip ganda untuk menggabungkan nilai ke dalam query
    $update = mysqli_query($conn, "UPDATE data_beasiswa SET nama_beasiswa='$nama', kode_beasiswa='$kode', syaratb='$sb', jenisb='$jb', lineb='$lb' WHERE id_beasiswa='$id'");
    if ($update) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            echo 'Berhasil Di Rubah';
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';
    } else {
            echo '<div class="alert alert-warning alert-dismissible fade show" role="alert">';
            echo 'Galal Merubah Data';
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';
    }
}

if (isset($_POST["notif"])) {
    $id_beasiswa = $_POST["id_beasiswa"];

    // Query untuk mengambil data siswa yang mendapatkan beasiswa berdasarkan id_beasiswa
    $query_siswa = mysqli_query($conn, "SELECT * FROM p_akhir WHERE id_beasiswa = '$id_beasiswa'");
    while ($siswa = mysqli_fetch_array($query_siswa)) {
        $id_siswa = $siswa['id_siswa'];

        // Cek apakah siswa sudah memiliki notifikasi untuk beasiswa ini
        $query_cek_notifikasi = mysqli_query($conn, "SELECT * FROM notifikasi WHERE id_siswa = '$id_siswa' AND id_beasiswa = '$id_beasiswa'");
        $count_cek_notifikasi = mysqli_num_rows($query_cek_notifikasi);

        if ($count_cek_notifikasi == 0) {
            // Jika siswa belum memiliki notifikasi, tambahkan notifikasi baru
            $keterangan_hasil = $siswa['keterangan'];
            $pesan = ($keterangan_hasil == 'Dapat Beasiswa') ? 'Selamat, Anda berhasil mendapatkan beasiswa!' : 'Maaf, Anda tidak berhasil mendapatkan beasiswa.';
            
            // Insert notifikasi ke tabel notifikasi
            mysqli_query($conn, "INSERT INTO notifikasi (id_siswa, id_beasiswa, keterangan, pesan) VALUES ('$id_siswa', '$id_beasiswa', '$keterangan_hasil', '$pesan')");
        }
    }
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            echo "Notifikasi berhasil ditambahkan untuk siswa yang mendapatkan beasiswa.";
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';
    
}


if (isset($_POST[""])) {
    $seri = $_POST["id_siswa"];
    $id_user = $_POST['id_user'];

    $cekstocksekarang = mysqli_query($conn, "SELECT p_ortu, t_ortu, s_kandung, n_sem, p_kelas FROM normalisasi WHERE id_siswa='$seri'");
    $ambildatanya = mysqli_fetch_array($cekstocksekarang);

    $p_ortu = $ambildatanya['p_ortu'];
    $t_ortu = $ambildatanya['t_ortu'];
    $s_kandung = $ambildatanya['s_kandung'];
    $n_sem = $ambildatanya['n_sem'];
    $p_kelas = $ambildatanya['p_kelas'];

    $cekstock = mysqli_query($conn, "SELECT b.p_ortu, b.t_ortu, b.s_kandung, b.n_sem, b.p_kelas FROM bobot_beasiswa b, data_siswa d WHERE b.id_beasiswa=d.id_beasiswa AND d.id_siswa='$seri'");
    $ambildata = mysqli_fetch_array($cekstock);

    $p_ortuu = $ambildata['p_ortu'];
    $t_ortuu = $ambildata['t_ortu'];
    $s_kandungg = $ambildata['s_kandung'];
    $n_semm = $ambildata['n_sem'];
    $p_kelass = $ambildata['p_kelas'];

    $p_ortuuu = $p_ortuu * $p_ortu;
    $t_ortuuu = $t_ortuu * $t_ortu;
    $s_kandunggg = $s_kandungg * $s_kandung;
    $n_semmm = $n_semm * $n_sem;
    $p_kelasss = $p_kelass * $p_kelas;

    $hitung = array($p_ortuuu, $t_ortuuu, $s_kandunggg, $n_semmm, $p_kelasss);
    $hasil = array_sum($hitung);

    // Menambahkan keterangan berdasarkan hasil perhitungan
    if ($hasil >= 10) {
        $keterangan_hasil = "Dapat Beasiswa";
        $pesan = 'Selamat, Anda berhasil mendapatkan beasiswa!';
    } else {
        $keterangan_hasil = "Tidak Dapat Beasiswa";
        $pesan = 'Maaf, Anda tidak berhasil mendapatkan beasiswa.';
    }

    // Menyimpan hasil perhitungan dan keterangan ke dalam tabel p_akhir
    $addtotable = mysqli_query($conn, "INSERT INTO p_akhir (id_siswa, keterangan, hasil) VALUES ('$seri', '$keterangan_hasil', '$hasil')");
    $addto = mysqli_query($conn, "INSERT INTO notifikasi (id_user, pesan) VALUES ('$id_user', '$pesan')");

    if ($addtotable && $addto) {
        echo "berhasil gaes";
        header("location:hitung_akhir.php");
        exit; // Penting untuk menghentikan eksekusi skrip setelah header
    } else {
        echo "Gagal";
        header("location:index.php");
        exit; // Penting untuk menghentikan eksekusi skrip setelah header
    }
}

if (isset($_POST['rubah'])) {
    $id_user = $_GET['id'];

    // Update keterangan menjadi "Persyaratan Terpenuhi"
    $addtotable = mysqli_query($conn, "UPDATE p_akhir SET keterangan = 'Persyaratan Terpenuhi' WHERE id_siswa = $id_user");

    if ($addtotable) {
        echo "berhasil gaes";
        header("location:notif.php");
        exit; // Penting untuk menghentikan eksekusi skrip setelah header
    } else {
        echo "Gagal";
        header("location:index.php");
        exit; // Penting untuk menghentikan eksekusi skrip setelah header
    }
} 

if (isset($_POST['kirimPesan'])) {
    $id_user = $_GET['id'];
    $pesan = $_POST['nama'];

    $addtotable = mysqli_query($conn, "UPDATE notifikasi SET pesan = '$pesan' WHERE id_siswa = $id_user");
    $addto = mysqli_query($conn, "UPDATE p_akhir SET Keterangan = 'Belum Terpenuhi' WHERE id_siswa = $id_user");


    if ($addtotable&&$addto) {
        echo "berhasil gaes";
        header("location:notif.php");
        exit;
    } else {
        echo "Gagal";
        header("location:index.php");
        exit;
    }
}

if (isset($_POST["notif4"])) {
    $id_beasiswa = $_POST["id_beasiswa"];

    // Query untuk mengambil data siswa yang mendapatkan beasiswa berdasarkan id_beasiswa
    $query_siswa = mysqli_query($conn, "SELECT * FROM p_akhir WHERE id_beasiswa = '$id_beasiswa'");
    while ($siswa = mysqli_fetch_array($query_siswa)) {
        $id_siswa = $siswa['id_siswa'];

        // Cek apakah siswa sudah memiliki notifikasi untuk beasiswa ini
        $query_cek_notifikasi = mysqli_query($conn, "SELECT * FROM notifikasi WHERE id_siswa = '$id_siswa' AND id_beasiswa = '$id_beasiswa'");
        $count_cek_notifikasi = mysqli_num_rows($query_cek_notifikasi);

        if ($count_cek_notifikasi == 0) {
            // Jika siswa belum memiliki notifikasi, tambahkan notifikasi baru
            $keterangan_hasil = $siswa['keterangan'];
            $pesan = ($keterangan_hasil == 'Tidak Dapat Beasiswa') ? 'Maaf, Anda belum berhasil mendapatkan beasiswa!' : 'Maaf, Anda tidak berhasil mendapatkan beasiswa.';
            
            // Insert notifikasi ke tabel notifikasi
            mysqli_query($conn, "INSERT INTO notifikasi (id_siswa, id_beasiswa, keterangan, pesan) VALUES ('$id_siswa', '$id_beasiswa', '$keterangan_hasil', '$pesan')");
        }
    }
            echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
            echo "Notifikasi berhasil ditambahkan untuk siswa yang mendapatkan beasiswa.";
            echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
            echo '<span aria-hidden="true">&times;</span>';
            echo '</button>';
            echo '</div>';
    
}

if (isset($_POST["notif2"])) {
    $id_beasiswa = $_POST["id_beasiswa"];

    // Query untuk mengambil data siswa yang mendapatkan beasiswa berdasarkan id_beasiswa
    $query_siswa = mysqli_query($conn, "SELECT * FROM notifikasi WHERE id_beasiswa = '$id_beasiswa'");
    while ($siswa = mysqli_fetch_array($query_siswa)) 
        $id_siswa = $siswa['id_siswa'];


    // Insert notifikasi ke tabel notifikasi
    $addto = mysqli_query($conn, "UPDATE notifikasi SET keterangan='Selesai', pesan = 'Beasiswa sudah dibayarkan, Silahkah' WHERE id_siswa = '$id_siswa' AND id_beasiswa = '$id_beasiswa'");

    if ($addto) {
        echo "berhasil gaes";
        header("location:notif.php");
        exit;
    } else {
        echo "Gagal";
        header("location:index.php");
        exit;
    }
    
}

if (isset($_POST["notif3"])) {
    $id_beasiswa = $_POST["id_beasiswa"];

    // Mengambil informasi beasiswa dari data_beasiswa
    $query_bea = mysqli_query($conn, "SELECT * FROM data_beasiswa WHERE id_beasiswa = '$id_beasiswa'");
    $bea = mysqli_fetch_array($query_bea);
    $nama_beasiswa = $bea['nama_beasiswa'];
    $kode_beasiswa = $bea['kode_beasiswa'];

    // Mengambil informasi siswa yang mendapatkan beasiswa
    $query_siswa = mysqli_query($conn, "SELECT * FROM data_siswa WHERE id_beasiswa = '$id_beasiswa'");
    while ($siswa = mysqli_fetch_array($query_siswa)) {
        $id_siswa = $siswa['id_siswa'];

        // Mengambil informasi hasil dan keterangan dari p_akhir
        $query_p_akhir = mysqli_query($conn, "SELECT * FROM p_akhir WHERE id_siswa = '$id_siswa'");
        $siswaaa = mysqli_fetch_array($query_p_akhir);
        $hasil = $siswaaa['hasil'];

        $query_p_akhirr = mysqli_query($conn, "SELECT * FROM notifikasi WHERE id_siswa = '$id_siswa'");
        $siswaaaa = mysqli_fetch_array($query_p_akhirr);
        $ket = $siswaaaa['keterangan'];

        // Mengambil informasi nama siswa dari user
        $query_user = mysqli_query($conn, "SELECT * FROM user WHERE id = '$id_siswa'");
        $siswaa = mysqli_fetch_array($query_user);
        $nama = $siswaa['nama'];

        // Insert data ke tabel arsip
        $addtotable = mysqli_query($conn, "INSERT INTO arsip (id_beasiswa, nama_beasiswa, kode_beasiswa, id_siswa, nama, keterangan, hasil) VALUES ('$id_beasiswa', '$nama_beasiswa', '$kode_beasiswa', '$id_siswa', '$nama', '$ket', '$hasil')");
    }

    // Hapus data dari tabel normalisasi berdasarkan id_beasiswa
    mysqli_query($conn, "DELETE FROM normalisasi WHERE id_beasiswa = '$id_beasiswa'");

    // Hapus data dari tabel p_akhir berdasarkan id_beasiswa
    mysqli_query($conn, "DELETE FROM p_akhir WHERE id_beasiswa = '$id_beasiswa'");

    // Hapus data dari tabel data_siswa berdasarkan id_beasiswa
    mysqli_query($conn, "DELETE FROM data_siswa WHERE id_beasiswa = '$id_beasiswa'");

    // Hapus data dari tabel data_beasiswa berdasarkan id_beasiswa
    mysqli_query($conn, "DELETE FROM data_beasiswa WHERE id_beasiswa = '$id_beasiswa'");

    mysqli_query($conn, "DELETE FROM bobot_beasiswa WHERE id_beasiswa = '$id_beasiswa'");

    mysqli_query($conn, "DELETE FROM notifikasai WHERE id_beasiswa = '$id_beasiswa'");

    mysqli_query($conn, "DELETE FROM persyaratan WHERE id_beasiswa = '$id_beasiswa'");

    if ($addtotable) {
        echo '<div class="alert alert-success alert-dismissible fade show" role="alert">';
        echo "Data berhasil dihapus.";
        echo '<button type="button" class="close" data-dismiss="alert" aria-label="Close">';
        echo '<span aria-hidden="true">&times;</span>';
        echo '</button>';
        echo '</div>';

        header("location:notif.php");
        exit;
    } else {
        echo "Gagal";
        header("location:index.php");
        exit;
    }
}


if(isset($_POST["addnewbaran"])){
    $userid = $_POST["email"];
    $server = $_POST["password"];
    $serve = $_POST["nomor"]; 
    $brandtype = $_POST["brandtype"];
    $brand = $_POST["setatus"];
    $brandtyp = $_SESSION['user']['id'];

    //soal gambar
    $allowed_extension = array('png','jpg','jpeg');
    $nama = $_FILES['file']['name'];//ambil nama gambar
    $ukuran = $_FILES['file']['size']; // ambil size
    $file_tmp = $_FILES['file']['tmp_name']; //ambil lokasi

    if(in_array($allowed_extension) === true);
        if($ukuran < 15000000){
            move_uploaded_file($file_tmp, 'image/'.$nama);

            $addtotable = mysqli_query($conn,"insert into jokiml (email, nomor, password, pesanan, bukti, setatus, id_user) values('$userid','$serve','$server','$brandtype','$nama','$brand','$brandtyp')");
            if($addtotable){
                echo "berhasil gaes";
                header("location:index.php");
            } else{
                echo "Gagal";
                header("location:index.html");
            }
        } else {
            echo '
        <script>
        alert("file kebesaran");
        window.location.;index.php;
        </script>
        ';
    }
}

if(isset($_POST["addnewbara"])){
    $userid = $_POST["email"];
    $server = $_POST["password"];
    $serve = $_POST["nomor"]; 
    $brandtype = $_POST["brandtype"];
    $brand = $_POST["setatus"];
    $brandtyp = $_SESSION['user']['id'];

    //soal gambar
    $allowed_extension = array('png','jpg','jpeg');
    $nama = $_FILES['file']['name'];//ambil nama gambar
    $ukuran = $_FILES['file']['size']; // ambil size
    $file_tmp = $_FILES['file']['tmp_name']; //ambil lokasi

    if(in_array($allowed_extension) === true);
        if($ukuran < 15000000){
            move_uploaded_file($file_tmp, 'image/'.$nama);

            $addtotable = mysqli_query($conn,"insert into jokiff (fb, nomor, password, pesanan, bukti, setatus, id_user) values('$userid','$serve','$server','$brandtype','$nama','$brand','$brandtyp')");
            if($addtotable){
                echo "berhasil gaes";
                header("location:index.php");
            } else{
                echo "Gagal";
                header("location:index.html");
            }
        } else {
            echo '
        <script>
        alert("file kebesaran");
        window.location.keluar.php;
        </script>
        ';
    }
}

if(isset($_POST["rat"])){
    $qty = $_POST["rating"];
    $cekstocksekarang = mysqli_query($conn, "select * from rate where bintang");
        $ambildatanya = mysqli_fetch_array($cekstocksekarang);

        $stocksekarang = $ambildatanya['bintang'];
        $tambahkanstocksekarangdenganquantity = $stocksekarang+$qty;
        $tambahkanstocksekarangdenganquantit = $tambahkanstocksekarangdenganquantity/2;
        
        $addtomasuk = mysqli_query($conn,"insert into rating (bintang) values('$qty')");
        $updatestockmasuk = mysqli_query($conn, "update rate set bintang='$tambahkanstocksekarangdenganquantit'");
        if($addtomasuk&&$updatestockmasuk){
        echo "berhasil gaes";
        header("location:index.php");
    } else{
        echo "Gagal";
        header("location:index.html");
    }
}
?>

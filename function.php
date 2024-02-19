<?php
$conn = mysqli_connect("localhost","root","","beasiswa");
//  coding test koneksi
// if ($conn) {
//     echo "sukses!";
// }
include_once "cek.php";   
$pdo = include "koneksi.php";


if (isset($_POST["addsiswa"])) {
    // Sisipkan bagian koneksi ke database di sini
    // ...

    $userid = $_POST["nama_beasiswa"];
    $ser = $_POST["p_ortu"];
    $brandtype = $_POST["t_ortu"];
    $brand = $_POST["s_kandung"];
    $bra = $_POST["n_sem"];
    $b = $_POST["p_kelas"];
    $brandtyp = $_SESSION['user']['id'];

    if (isRegisteredDataSiswa($conn, $brandtyp, $userid)) {
        showAlert('Anda Sudah Mengikuti Beasiswa Sebelumnya', 'warning');
    } else {
        $addtotable = mysqli_query($conn, "INSERT INTO data_siswa (id_beasiswa, id_user, p_ortu, t_ortu, s_kandung, n_sem, p_kelas) VALUES ('$userid','$brandtyp','$ser','$brandtype','$brand','$bra','$b')");
        if ($addtotable) {
            echo "berhasil gaes";
            header("location:datasiswa.php");
        } else {
            echo "Gagal";
            header("location:index.html");
        }
    }
}

if(isset($_POST["addnewba"])){
    $userid = $_POST["userid"];
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

            $addtotable = mysqli_query($conn,"insert into topupff (userid, jumlahdm, pengirim,  setatus, id_user) values('$userid','$brandtype','$nama','$brand','$brandtyp')");
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

if (isset($_POST["profil"])) {
    // Get the submitted data from the form
    $id_user = $_SESSION['user']['id'];
    $foto_profil = $_FILES['foto_profil']['name'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];
    $nis = $_POST['nis'];

    // Handle the uploaded profile picture (if submitted)
    if (!empty($foto_profil)) {
        // Assuming you have a directory for storing profile pictures
        $target_dir = "profile_pictures/";
        $target_file = $target_dir . basename($_FILES['foto_profil']['name']);
        $uploadOk = 1;
        $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));

        // Check if the image file is an actual image or fake image
        $check = getimagesize($_FILES['foto_profil']['tmp_name']);
        if ($check !== false) {
            // Image is valid
            $uploadOk = 1;
        } else {
            // Image is invalid
            $uploadOk = 0;
        }

        // Check if file already exists (optional)
        if (file_exists($target_file)) {
            // You might want to decide how to handle this case
            // For example, you can overwrite the existing image or rename the new one
        }

        // Check file size (optional)
        if ($_FILES['foto_profil']['size'] > 500000) {
            // You might want to limit the maximum file size allowed
            $uploadOk = 0;
        }

        // Allow only specific image file formats (optional)
        if ($imageFileType != "jpg" && $imageFileType != "png" && $imageFileType != "jpeg" && $imageFileType != "gif") {
            // You might want to restrict the allowed image formats
            $uploadOk = 0;
        }

        // Move the uploaded file to the target directory (optional)
        if ($uploadOk) {
            if (move_uploaded_file($_FILES['foto_profil']['tmp_name'], $target_file)) {
                // Image uploaded successfully
                // You can save the file path in the database if you want to
            } else {
                // Error uploading the image
            }
        }
    }

    // Assuming you have already created the `profile_siswa` table with appropriate fields (id_user, foto_profil, nama, kelas, alamat, nis)
    $sql = "UPDATE profile_siswa SET ";
    if (!empty($foto_profil)) {
        $sql .= "foto_profil='$foto_profil', ";
    }
    $sql .= "nama='$nama', kelas='$kelas', alamat='$alamat', nis='$nis' WHERE id_user='$id_user'";

    // Perform the update query
    if (mysqli_query($conn, $sql)) {
        // Profile updated successfully
        // You might want to redirect the user back to the profile page with a success message
        header("Location: profil.php?message=success");
        exit;
    } else {
        // Error updating profile
        // You might want to redirect the user back to the profile page with an error message
        header("Location: profil.php?message=error");
        exit;
    }
}

if (isset($_POST["addper"])) {

    // Ambil nilai dari elemen input hidden
    $id_beasiswa = $_POST['id_beasiswa'];
    $id_user = $_POST['id_user'];

    // Lokasi folder penyimpanan file
    $uploadDir = 'uploads/';

    // Meng-handle unggahan file gaji
    if ($_FILES['file_gaji']['error'] == UPLOAD_ERR_OK) {
        $fileGajiName = $_FILES['file_gaji']['name'];
        $fileGajiTmpName = $_FILES['file_gaji']['tmp_name'];
        $fileGajiPath = $uploadDir . $fileGajiName;
        move_uploaded_file($fileGajiTmpName, $fileGajiPath);
    }

    // Meng-handle unggahan file kartu keluarga
    if ($_FILES['file_kk']['error'] == UPLOAD_ERR_OK) {
        $fileKKName = $_FILES['file_kk']['name'];
        $fileKKTmpName = $_FILES['file_kk']['tmp_name'];
        $fileKKPath = $uploadDir . $fileKKName;
        move_uploaded_file($fileKKTmpName, $fileKKPath);
    }

    // Meng-handle unggahan file raport nilai
    if ($_FILES['file_Raport']['error'] == UPLOAD_ERR_OK) {
        $fileRaportName = $_FILES['file_Raport']['name'];
        $fileRaportTmpName = $_FILES['file_Raport']['tmp_name'];
        $fileRaportPath = $uploadDir . $fileRaportName;
        move_uploaded_file($fileRaportTmpName, $fileRaportPath);
    }

    // Meng-handle unggahan file raport peringkat
    if ($_FILES['file_peringkat']['error'] == UPLOAD_ERR_OK) {
        $filePeringkatName = $_FILES['file_peringkat']['name'];
        $filePeringkatTmpName = $_FILES['file_peringkat']['tmp_name'];
        $filePeringkatPath = $uploadDir . $filePeringkatName;
        move_uploaded_file($filePeringkatTmpName, $filePeringkatPath);
    }

    // Di sini, Anda dapat menyimpan data file yang diunggah (misalnya, path file) ke dalam database atau melakukan tindakan lain sesuai kebutuhan.
    // Misalnya, Anda dapat menyimpan path file ke dalam tabel persyaratan.
    $query = "INSERT INTO prsyaratan (nama_beasiswa, id_siswa, slip_gaji , kartu_keluarga, raport_nilai, raport_peringkat) 
    VALUES ('$id_beasiswa','$id_user','$fileGajiName','$fileKKName','$fileRaportName','$filePeringkatName')";

    if (mysqli_query($conn, $query)) {
        echo "File berhasil diunggah dan data tersimpan.";
        // Redirect ke halaman lain setelah proses selesai
        header("location:persyaratan.php");
    } else {
        echo "Error: " . mysqli_error($conn);
        // Redirect ke halaman lain jika terjadi kesalahan
        header("location:index.html");
    }

    // Menutup koneksi
    mysqli_close($conn);
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

            $addtotable = mysqli_query($conn,"insert into jokiml (email, nomor, password, pesanan, bukti, setatus, id_user) values(''$id_beasiswa'.$userid','$serve','$server','$brandtype','$nama','$brand','$brandtyp')");
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

// Check if the form for adding profile has been submitted
if(isset($_POST['addprofil'])) {
    // Assuming you have a database connection established
    // Replace 'your_database_connection' with your actual database connection
    
    // Retrieve data from the form
    $id_user = $_SESSION['user']['id'];
    $nama = $_POST['nama'];
    $kelas = $_POST['kelas'];
    $alamat = $_POST['alamat'];
    $nis = $_POST['nis'];

    // You may want to add some validation and sanitization here
    $addtotable = mysqli_query($conn,"insert into profile_siswa
    (id_user, nama, kelas, alamat, nis) VALUES ('$id_user','$nama', '$kelas', '$alamat', '$nis')");
    if($addtotable){
        echo "berhasil gaes";
        header("location:profil.php");
    } else{
        echo "Gagal";
        header("location:index.html");
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

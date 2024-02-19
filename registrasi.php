	
<?php
    if (!empty($_POST)) {
        
        if($_POST['password2'] != $_POST['password']) {
        
            $error = 'Password dan ulang password harus sama';
        
        } else {
        
            try {
        
                $pdo = include "koneksi.php";
        
                $query = $pdo->prepare("insert into user (username, password, salt, nama, aktif) values(:username, :password,:salt,:nama,:aktif)");
        
                $string = str_shuffle('0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ');
        
                $salt = sha1(substr($string, 0, 8).time().rand());
        
                $query->execute(array(
        
                    'username' => $_POST['username'],
        
                    'password' => sha1($_POST['password'].$salt),
        
                    'salt' => $salt,
        
                    'nama' => $_POST['nama'],
        
                    'aktif' => $_POST['aktif']
        
                ));
        
                header("Location: login.php");
        
                exit;
        
            } catch (Exception $e) {
        
                $error = $e->getMessage();
        
            }
        
        }
        
    }
        
    ?>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Register - SB Admin 2</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet" crossorigin="anonymous" />
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css" rel="stylesheet" crossorigin="anonymous" />
</head>
<body class="bg-primary">
    <div id="layoutAuthentication">
        <div id="layoutAuthentication_content">
            <main>
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-lg-7">
                            <div class="card shadow-lg border-0 rounded-lg mt-5">
                                <div class="card-header"><h3 class="text-center font-weight-light my-4">Create Account</h3></div>
                                <div class="card-body">
                                    <form method="POST" action="">
                                        <div class="mb-3">
                                            <label for="inputFirstName" class="form-label">Nama</label>
                                            <input class="form-control" id="inputFirstName" name="nama" type="text" placeholder="Enter your first name" />
                                        </div>
                                        <div class="mb-3 form-check">
                                            <input type="checkbox" class="form-check-input" id="inputAktif" name="aktif" value="1">
                                            <label class="form-check-label" for="inputAktif">Aktif</label>
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputFirstName" class="form-label">Username</label>
                                            <input class="form-control" id="inputEmail" name="username" type="text" placeholder="name@example.com" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputFirstName" class="form-label">Password</label>
                                            <input class="form-control" id="inputPassword" name="password" type="password" placeholder="Create a password" />
                                        </div>
                                        <div class="mb-3">
                                            <label for="inputFirstName" class="form-label">Password2</label>
                                            <input class="form-control" id="inputPasswordConfirm" name="password2" type="password" placeholder="Confirm password" />
                                        </div>
                                        <div class="mt-4">
                                            <button type="submit" class="btn btn-primary btn-block">Simpan</button>
                                        </div>
                                    </form>
                                </div>
                                <div class="card-footer text-center py-3">
                                    <div class="small"><a href="login.html">Have an account? Go to login</a></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </main>
        </div>
    </div>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" crossorigin="anonymous"></script>
</body>
</html>
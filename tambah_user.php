<?php
// Cek session
if(empty($_SESSION['admin'])){
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    if(isset($_REQUEST['submit'])){

        // Validasi form kosong
        if(empty($_REQUEST['username']) || empty($_REQUEST['password']) || empty($_REQUEST['nama']) || empty($_REQUEST['nip']) || empty($_REQUEST['admin'])){
            $_SESSION['errEmpty'] = 'ERROR! Semua form wajib diisi!';
            header("Location: ./admin.php?page=sett&sub=usr&act=add");
            die();
        } else {
            $username = $_REQUEST['username'];
            $password = $_REQUEST['password'];
            $nama = $_REQUEST['nama'];
            $nip = $_REQUEST['nip'];
            $admin = $_REQUEST['admin'];

            // Validasi input data
            if(!preg_match("/^[a-zA-Z0-9_]*$/", $username)){
                $_SESSION['uname'] = 'Form Username hanya boleh mengandung karakter huruf, angka dan underscore (_)';
                echo '<script language="javascript">window.history.back();</script>';
            } else if(!preg_match("/^[a-zA-Z., ]*$/", $nama)){
                $_SESSION['namauser'] = 'Form Nama hanya boleh mengandung karakter huruf, spasi, titik(.) dan koma(,)';
                echo '<script language="javascript">window.history.back();</script>';
            } else if(!preg_match("/^[0-9. -]*$/", $nip)){
                $_SESSION['nipuser'] = 'Form NIP hanya boleh mengandung karakter angka, spasi dan minus(-)';
                echo '<script language="javascript">window.history.back();</script>';
            } else if(!preg_match("/^[1-3]*$/", $admin)){
                $_SESSION['tipeuser'] = 'Form Tipe User hanya boleh mengandung karakter angka 1, 2 atau 3';
                echo '<script language="javascript">window.history.back();</script>';
            } else {
                // Cek apakah username sudah ada
                $cek = mysqli_query($config, "SELECT * FROM tbl_user WHERE username='$username'");
                $result = mysqli_num_rows($cek);

                if($result > 0){
                    $_SESSION['errUsername'] = 'Username sudah terpakai, gunakan yang lain!';
                    echo '<script language="javascript">window.history.back();</script>';
                } else if(strlen($username) < 5){
                    $_SESSION['errUser5'] = 'Username minimal 5 karakter!';
                    echo '<script language="javascript">window.history.back();</script>';
                } else if(strlen($password) < 5){
                    $_SESSION['errPassword'] = 'Password minimal 5 karakter!';
                    echo '<script language="javascript">window.history.back();</script>';
                } else {
                    // Validasi untuk hanya mengizinkan Super Admin untuk menambahkan Super Admin lain
                    if($admin == 1 && $_SESSION['admin'] != 1){
                        $_SESSION['errAdmin'] = 'Hanya Super Admin yang dapat menambahkan Super Admin lain!';
                        echo '<script language="javascript">window.history.back();</script>';
                    } else {
                        // Insert ke database
                        $query = mysqli_query($config, "INSERT INTO tbl_user(username,password,nama,nip,admin) VALUES('$username',MD5('$password'),'$nama','$nip','$admin')");
                        if($query != false){
                            $_SESSION['succAdd'] = 'SUKSES! User baru berhasil ditambahkan';
                            header("Location: ./admin.php?page=sett&sub=usr");
                            die();
                        } else {
                            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
                            echo '<script language="javascript">window.history.back();</script>';
                        }
                    }
                }
            }
        }
    } else {?>

        <!-- Row Start -->
        <div class="row">
            <!-- Secondary Nav START -->
            <div class="col s12">
                <nav class="secondary-nav">
                    <div class="nav-wrapper blue-grey darken-1">
                        <ul class="left">
                            <li class="waves-effect waves-light"><a href="?page=sett&sub=usr&act=add" class="judul"><i class="material-icons">person_add</i> Tambah User</a></li>
                        </ul>
                    </div>
                </nav>
            </div>
            <!-- Secondary Nav END -->
        </div>
        <!-- Row END -->

        <?php
            // Menampilkan pesan kesalahan
            if(isset($_SESSION['errQ'])){
                echo '<div id="alert-message" class="row"><div class="col m12"><div class="card red lighten-5"><div class="card-content notif"><span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$_SESSION['errQ'].'</span></div></div></div></div>';
                unset($_SESSION['errQ']);
            }
            if(isset($_SESSION['errEmpty'])){
                echo '<div id="alert-message" class="row"><div class="col m12"><div class="card red lighten-5"><div class="card-content notif"><span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$_SESSION['errEmpty'].'</span></div></div></div></div>';
                unset($_SESSION['errEmpty']);
            }
            if(isset($_SESSION['errAdmin'])){
                echo '<div id="alert-message" class="row"><div class="col m12"><div class="card red lighten-5"><div class="card-content notif"><span class="card-title red-text"><i class="material-icons md-36">clear</i> '.$_SESSION['errAdmin'].'</span></div></div></div></div>';
                unset($_SESSION['errAdmin']);
            }
        ?>

        <!-- Row form Start -->
        <div class="row jarak-form">
            <!-- Form START -->
            <form class="col s12" method="post" action="?page=sett&sub=usr&act=add">
                <!-- Row in form START -->
                <div class="row">
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">account_circle</i>
                        <input id="username" type="text" class="validate" name="username" required>
                        <?php
                        if(isset($_SESSION['uname'])){
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$_SESSION['uname'].'</div>';
                            unset($_SESSION['uname']);
                        }
                        if(isset($_SESSION['errUsername'])){
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$_SESSION['errUsername'].'</div>';
                            unset($_SESSION['errUsername']);
                        }
                        if(isset($_SESSION['errUser5'])){
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$_SESSION['errUser5'].'</div>';
                            unset($_SESSION['errUser5']);
                        }
                        ?>
                        <label for="username">Username</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">text_fields</i>
                        <input id="nama" type="text" class="validate" name="nama" required>
                        <?php
                        if(isset($_SESSION['namauser'])){
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$_SESSION['namauser'].'</div>';
                            unset($_SESSION['namauser']);
                        }
                        ?>
                        <label for="nama">Nama</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">lock</i>
                        <input id="password" type="password" class="validate" name="password" required>
                        <?php
                        if(isset($_SESSION['errPassword'])){
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$_SESSION['errPassword'].'</div>';
                            unset($_SESSION['errPassword']);
                        }
                        ?>
                        <label for="password">Password</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">looks_one</i>
                        <input id="nip" type="text" class="validate" name="nip" required>
                        <?php
                        if(isset($_SESSION['nipuser'])){
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$_SESSION['nipuser'].'</div>';
                            unset($_SESSION['nipuser']);
                        }
                        ?>
                        <label for="nip">NIP</label>
                    </div>
                    <div class="input-field col s6">
                        <i class="material-icons prefix md-prefix">supervisor_account</i>
                        <label>Pilih Tipe User</label><br/>
                        <div class="input-field col s11 right">
                            <select class="browser-default validate" name="admin" id="admin" required>
                                <?php if ($_SESSION['admin'] == 1): ?>
                                    <option value="3">User Biasa</option>
                                    <option value="2">Administrator</option>
                                    <option value="1">Super Admin</option> <!-- Hanya Super Admin yang dapat menambah Super Admin -->
                                <?php elseif ($_SESSION['admin'] == 2): ?>
                                    <option value="3">User Biasa</option>
                                    <option value="2">Administrator</option>
                                <?php else: ?>
                                    <option value="3">User Biasa</option>
                                <?php endif; ?>
                            </select>
                        </div>
                        <?php
                        if(isset($_SESSION['tipeuser'])){
                            echo '<div id="alert-message" class="callout bottom z-depth-1 red lighten-4 red-text">'.$_SESSION['tipeuser'].'</div>';
                            unset($_SESSION['tipeuser']);
                        }
                        ?>
                    </div>
                </div>
                <br/>
                <!-- Row in form END -->
                <div class="row">
                    <div class="col 6">
                        <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                    </div>
                    <div class="col 6">
                        <a href="?page=sett&sub=usr" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                    </div>
                </div>
            </form>
            <!-- Form END -->
        </div>
        <!-- Row form END -->

<?php
    }
}
?>

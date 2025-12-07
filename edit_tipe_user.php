<?php

// Cek session
if (empty($_SESSION['admin'])) {
    $_SESSION['err'] = '<center>Anda harus login terlebih dahulu!</center>';
    header("Location: ./");
    die();
} else {
    // Ambil ID user dari permintaan
    $id_user = $_REQUEST['id_user'];

    // Ambil data user yang akan diedit
    $id_user = mysqli_real_escape_string($config, $_REQUEST['id_user']);
    $query = mysqli_query($config, "SELECT * FROM tbl_user WHERE id_user='$id_user'");
    
    if (mysqli_num_rows($query) > 0) {
        while ($row = mysqli_fetch_array($query)) { ?>

            <!-- Row Start -->
            <div class="row">
                <div class="col s12">
                    <nav class="secondary-nav">
                        <div class="nav-wrapper blue-grey darken-1">
                            <ul class="left">
                                <li class="waves-effect waves-light tooltipped" data-position="right" data-tooltip="Menu ini untuk mengedit data user"><a href="#" class="judul"><i class="material-icons">mode_edit</i> Edit Data User</a></li>
                            </ul>
                        </div>
                    </nav>
                </div>
            </div>

            <div class="row jarak-form">
                <form class="col s12" method="post" action="?page=sett&sub=usr&act=edit&id_user=<?php echo $row['id_user']; ?>">
                    <div class="row">
                        <div class="input-field col s6">
                            <input type="hidden" value="<?php echo $row['id_user']; ?>" name="id_user">
                            <i class="material-icons prefix md-prefix">account_circle</i>
                            <input id="username" type="text" value="<?php echo $row['username']; ?>" readonly class="grey-text">
                            <label for="username">Username</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">text_fields</i>
                            <input id="nama" type="text" value="<?php echo $row['nama']; ?>" name="nama" required>
                            <label for="nama">Nama</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">text_fields</i>
                            <input id="nip" type="text" value="<?php echo $row['nip']; ?>" name="nip" required>
                            <label for="nip">NIP</label>
                        </div>
                        <div class="input-field col s6">
                            <i class="material-icons prefix md-prefix">supervisor_account</i>
                            <label>Pilih tipe user</label><br/>
                            <select class="browser-default" name="admin" id="admin" required>
                                <option value="<?php echo $row['admin']; ?>">
                                    <?php
                                        if ($row['admin'] == 1) {
                                            echo 'Super Admin';
                                        } elseif ($row['admin'] == 2) {
                                            echo 'Administrator';
                                        } else {
                                            echo 'User Biasa';
                                        }
                                    ?>
                                </option>
                                <?php if ($_SESSION['admin'] == 1) { // Super Admin can edit all roles ?>
                                    <option value="1">Super Admin</option>
                                    <option value="2">Administrator</option>
                                    <option value="3">User Biasa</option>
                                <?php } elseif ($_SESSION['admin'] == 2) { // Administrator can only edit User Biasa ?>
                                    <option value="2">Administrator</option>
                                    <option value="3">User Biasa</option>
                                <?php } else { // User Biasa cannot change their own role ?>
                                    <option value="<?php echo $row['admin']; ?>">
                                        <?php
                                            if ($row['admin'] == 2) echo 'Administrator';
                                            else echo 'User Biasa';
                                        ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>
                    <br/>
                    <div class="row">
                        <div class="col 6">
                            <button type="submit" name="submit" class="btn-large blue waves-effect waves-light">SIMPAN <i class="material-icons">done</i></button>
                        </div>
                        <div class="col 6">
                            <a href="?page=sett&sub=usr" class="btn-large deep-orange waves-effect waves-light">BATAL <i class="material-icons">clear</i></a>
                        </div>
                    </div>
                </form>
            </div>
            <?php
        }
    } else {
        echo '<script language="javascript">alert("ERROR! User tidak ditemukan."); window.location.href="./admin.php?page=sett&sub=usr";</script>';
    }

    // Proses simpan data
    if (isset($_REQUEST['submit'])) {
        $admin = $_REQUEST['admin'];
        $nama = $_REQUEST['nama'];
        $nip = $_REQUEST['nip'];

        // Validasi tipe user
        if ($_SESSION['admin'] == 1) {
            // Super Admin can edit any type
            if (!preg_match("/^[1-3]*$/", $admin)) {
                $_SESSION['tipeuser'] = 'Form Tipe User hanya boleh mengandung karakter angka 1, 2, atau 3';
                echo '<script language="javascript">window.history.back();</script>';
            }
        } elseif ($_SESSION['admin'] == 2) {
            // Administrator can only change to Admin (2) or User Biasa (3)
            if (!preg_match("/^[2-3]*$/", $admin)) {
                $_SESSION['tipeuser'] = 'Form Tipe User hanya boleh mengandung karakter angka 2 atau 3';
                echo '<script language="javascript">window.history.back();</script>';
            }
        } else {
            // User Biasa cannot change their own role
            if ($id_user == $_SESSION['id_user']) {
                echo '<script language="javascript">alert("ERROR! Anda tidak diperbolehkan mengedit tipe akun Anda sendiri. Hubungi super admin untuk mengeditnya."); window.location.href="./admin.php?page=sett&sub=usr";</script>';
            }
        }

        // Update query for valid cases
        $updateQuery = mysqli_query($config, "UPDATE tbl_user SET admin='$admin', nama='$nama', nip='$nip' WHERE id_user='$id_user'");

        if ($updateQuery) {
            $_SESSION['succEdit'] = 'SUKSES! Data user berhasil diupdate';
            header("Location: ./admin.php?page=sett&sub=usr");
            die();
        } else {
            $_SESSION['errQ'] = 'ERROR! Ada masalah dengan query';
            echo '<script language="javascript">window.location.href="./admin.php?page=sett&sub=usr&act=edit&id_user='.$id_user.'";</script>';
        }
    }
}
?>

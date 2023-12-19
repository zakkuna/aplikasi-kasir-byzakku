<?php
session_start();
$conn = mysqli_connect('localhost', 'root', '', 'kasir');

//bikin login nya

if (isset($_POST['login'])) {
    //insiasi variabel
    $username = $_POST['username'];
    $password = $_POST['password'];

    $check = mysqli_query($conn, "SELECT * FROM user WHERE username='$username' AND password='$password'");
    $hitung = mysqli_num_rows($check);

    if ($hitung > 0) {
        //jika ada data username / pass di databasenya

        $_SESSION['login'] = 'True';
        header("location:index.php");
    } else {
        echo "<script>alert('Username atau Password salah!')</script>";
    }
}




if (isset($_POST['tambahbarang'])) {
    // Ensure connection is established ($conn assumed to be defined)
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Sanitize user inputs to prevent SQL injection
    $namaproduk = mysqli_real_escape_string($conn, $_POST['namaproduk']);
    $deskripsi = mysqli_real_escape_string($conn, $_POST['deskripsi']);
    $stock = mysqli_real_escape_string($conn, $_POST['stock']);
    $harga = mysqli_real_escape_string($conn, $_POST['harga']);

    // Prepare the query to avoid SQL injection
    $query = "INSERT INTO produk (namaproduk, deskripsi, stock, harga) VALUES ('$namaproduk', '$deskripsi', '$stock', '$harga')";

    // Attempt to execute the query
    if (mysqli_query($conn, $query)) {
        // On success, redirect to stok.php
        header("location: stok.php");
        exit(); // Terminate script after redirection
    } else {
        // If insertion fails, show an error message
        echo "<script>alert('Gagal input!')</script>";
    }

    // Close the database connection
    mysqli_close($conn);
}

if (isset($_POST['tambahpelanggan'])) {
    // Ensure connection is established ($conn assumed to be defined)
    if (!$conn) {
        die("Connection failed: " . mysqli_connect_error());
    }

    // Sanitize user inputs to prevent SQL injection
    $namapelanggan = mysqli_real_escape_string($conn, $_POST['namapelanggan']);
    $notelp = mysqli_real_escape_string($conn, $_POST['notelp']);
    $alamat = mysqli_real_escape_string($conn, $_POST['alamat']);


    // Prepare the query to avoid SQL injection
    $query = "INSERT INTO pelanggan (namapelanggan, notelp, alamat) VALUES ('$namapelanggan', '$notelp', '$alamat')";

    // Attempt to execute the query
    if (mysqli_query($conn, $query)) {
        // On success, redirect to stok.php
        header("location: pelanggan.php");
        exit(); // Terminate script after redirection
    } else {
        // If insertion fails, show an error message
        echo "<script>alert('Gagal input!')</script>";
    }

    // Close the database connection
    mysqli_close($conn);
}



if (isset($_POST['tambahpesanan'])) {
    // Connect to the database (use a DSN if needed)


    $idpelanggan = $_POST['idpelanggan'];

    // Prepare the SQL statement with parameter placeholders
    $insert = mysqli_query($conn, "INSERT INTO pesanan (idpelanggan) VALUES ('$idpelanggan')");

    // Bind the parameter values to the statement


    // Execute the statement
    if ($insert) {
        header('location:index.php');
    } else {
        echo 'Error';
    }
}

if (isset($_POST['addproduk'])) {
    // Connect to the database (use a DSN if needed)


    $idproduk = $_POST['idproduk']; //id produknya
    $idpesan = $_POST['idpesan']; // idpesanan
    $qty = $_POST['qty'];

    $hitung1 = mysqli_query($conn, "SELECT * FROM produk where idproduk='$idproduk'");
    $hitung2 = mysqli_fetch_array($hitung1);
    $stocksekarang = $hitung2['stock']; // stock barang alias stok saat ini

    if ($stocksekarang >= $qty) {
        // yaudaj
        // Prepare the SQL statement with parameter placeholders

        $selisih =  $stocksekarang - $qty;

        $insert = mysqli_query($conn, "INSERT INTO detailpesanan (idpesanan, idproduk, qty) VALUES ('$idpesan', '$idproduk', '$qty')");
        $update = mysqli_query($conn, "UPDATE produk set stock='$selisih' Where idproduk='$idproduk'");
        // Bind the parameter values to the statement


        // Execute the statement
        if ($insert && $update) {
            header('location:view.php?idpesan=' . $idpesan);
        } else {
            echo '<script>alert("gagal tambah pesanan");
        window.location.href="view.php?idpesan=' . $idpesan . '"</script>';
        }
    } else {
        //stock ga cukup
        echo '<script>alert("Stock tidak cukup");
        window.location.href="view.php?idpesan=' . $idpesan . '"</script>';
    }
}


if (isset($_POST['barangmasuk'])) {
    $idproduk = $_POST['idproduk'];
    $qty = $_POST['qty'];

    // Ambil stock sekarang
    $caristock = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idproduk'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    // Hitung stock yang baru setelah barang masuk
    $newstock = $stocksekarang + $qty;

    // Masukkan data barang masuk ke dalam tabel 'masuk'
    $masukb = mysqli_query($conn, "INSERT INTO masuk (idproduk, qty) VALUES ('$idproduk', '$qty')");

    // Update stock produk setelah barang masuk
    $updateb = mysqli_query($conn, "UPDATE produk SET stock='$newstock' WHERE idproduk='$idproduk'");

    if ($masukb && $updateb) {
        header("Location: masuk.php");
    } else {
        echo '<script>alert("Tidak dapat menambah barang");
        window.location.href="masuk.php"</script>';
    }
}


// hapus 

if (isset($_POST['hapusprodukpesanan'])) {
    $iddp = $_POST['iddp'];
    $idproduk = $_POST['idproduk'];
    $idpesan = $_POST['idpesan'];

    // Cek qty sekarang
    $cek1 = mysqli_query($conn, "SELECT * FROM detailpesanan WHERE iddetailpesanan='$iddp'");
    $cek2 = mysqli_fetch_array($cek1);
    $qtysekarang = $cek2['qty'];

    // Cek stok sekarang
    $cek3 = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idproduk'");
    $cek4 = mysqli_fetch_array($cek3);
    $stocksekarang = $cek4['stock'];

    $hitung = $stocksekarang + $qtysekarang;

    // Update stok
    $update = mysqli_query($conn, "UPDATE produk SET stock='$hitung' WHERE idproduk='$idproduk'");

    // Hapus item dari detailpesanan
    $hapus = mysqli_query($conn, "DELETE FROM detailpesanan WHERE idproduk='$idproduk' AND iddetailpesanan='$iddp'");

    if ($update && $hapus) {
        header("location:view.php?idpesan=$idpesan");
    } else {
        echo "error";
    }
}


if (isset($_POST['editbarang'])) {
    $np = $_POST['namaproduk'];
    $desc = $_POST['deskripsi'];
    $harga = $_POST['harga'];
    $idproduk = $_POST['idproduk'];

    $query = mysqli_query($conn, "UPDATE produk SET namaproduk='$np', deskripsi='$desc', harga='$harga' WHERE idproduk='$idproduk'");

    if ($query) {
        header("location:stok.php");
    } else {
        echo '<script>alert("Gagal");
        window.location.href="stok.php"</script>';
    }
}


if (isset($_POST['hapusbarang'])) {

    $idproduk = $_POST['idproduk'];

    $query = mysqli_query($conn, "DELETE from produk WHERE idproduk='$idproduk'");
    if ($query) {
        header("location:stok.php");
    } else {
        echo '<script>alert("Gagal Menghapus");
        window.location.href="stok.php"</script>';
    }
}

if (isset($_POST['editpelanggan'])) {
    $namapelanggan = $_POST['namapelanggan'];
    $notelp = $_POST['notelp'];
    $alamat = $_POST['alamat'];
    $idpelanggan = $_POST['idpelanggan'];

    $query = mysqli_query($conn, "UPDATE pelanggan SET namapelanggan='$namapelanggan', notelp='$notelp', alamat='$alamat' WHERE idpelanggan='$idpelanggan'");

    if ($query) {
        header("location:pelanggan.php");
    } else {
        echo '<script>alert("Gagal");
        window.location.href="pelanggan.php"</script>';
    }
}


if (isset($_POST['hapuspelanggan'])) {

    $idpelanggan = $_POST['idpelanggan'];

    $query = mysqli_query($conn, "DELETE from pelanggan WHERE idpelanggan='$idpelanggan'");
    if ($query) {
        header("location:pelanggan.php");
    } else {
        echo '<script>alert("Gagal Menghapus");
        window.location.href="pelanggan.php"</script>';
    }
}


if (isset($_POST['editdatabarangmasuk'])) {
    $qty = $_POST['qty'];
    $idmasuk = $_POST['idmasuk'];
    $idproduk = $_POST['idproduk'];

    // Mengambil qty saat ini dari tabel masuk
    $caritahu = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idmasuk'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    // Mengambil stock produk saat ini
    $caristock = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idproduk'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    // Menghitung perbedaan qty yang baru dengan yang lama
    $selisih = $qty - $qtysekarang;

    if ($selisih >= 0) {
        // Jika qty baru lebih besar dari qty lama
        $newstock = $stocksekarang + $selisih;
        $query = mysqli_query($conn, "UPDATE masuk SET qty='$qty' WHERE idmasuk='$idmasuk'");
        $query1 = mysqli_query($conn, "UPDATE produk SET stock='$newstock' WHERE idproduk='$idproduk'");
        if ($query && $query1) {
            header("location:masuk.php");
        } else {
            echo '<script>alert("Gagal edit masuk");
            window.location.href="masuk.php"</script>';
        }
    } else {
        // Jika qty baru lebih kecil dari qty lama
        $newstock = $stocksekarang - abs($selisih); // Menggunakan abs() agar selisih selalu positif
        $query = mysqli_query($conn, "UPDATE masuk SET qty='$qty' WHERE idmasuk='$idmasuk'");
        $query1 = mysqli_query($conn, "UPDATE produk SET stock='$newstock' WHERE idproduk='$idproduk'");
        if ($query && $query1) {
            header("location:masuk.php");
        } else {
            echo '<script>alert("Gagal edit masuk");
            window.location.href="masuk.php"</script>';
        }
    }
}

if (isset($_POST['hapusdatabarangmasuk'])) {
    $idmasuk = $_POST['idmasuk'];
    $idproduk = $_POST['idproduk'];

    // Mengambil qty saat ini dari tabel masuk
    $caritahu = mysqli_query($conn, "SELECT * FROM masuk WHERE idmasuk='$idmasuk'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    // Mengambil stock produk saat ini
    $caristock = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idproduk'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    // Menghitung perbedaan qty yang baru dengan yang lama
    $selisih = $qtysekarang; // Jumlah yang akan dihapus adalah qty yang ada saat ini

    // Mengurangi stock dengan jumlah yang akan dihapus
    $newstock = $stocksekarang - $selisih;

    // Hapus data dari tabel masuk
    $hapus = mysqli_query($conn, "DELETE FROM masuk WHERE idmasuk='$idmasuk'");

    // Update stock pada tabel produk setelah menghapus data barang masuk
    $updatestock = mysqli_query($conn, "UPDATE produk SET stock='$newstock' WHERE idproduk='$idproduk'");

    if ($hapus && $updatestock) {
        header("location:masuk.php");
    } else {
        echo '<script>alert("Gagal menghapus data barang masuk");
        window.location.href="masuk.php"</script>';
    }
}


if (isset($_POST['editdetailp'])) {
    $qty = $_POST['qty'];
    $iddp = $_POST['iddp'];
    $idproduk = $_POST['idproduk'];
    $idpesan = $_POST['idpesan'];

    $caritahu = mysqli_query($conn, "SELECT * FROM detailpesanan WHERE iddetailpesanan='$iddp'");
    $caritahu2 = mysqli_fetch_array($caritahu);
    $qtysekarang = $caritahu2['qty'];

    $caristock = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk='$idproduk'");
    $caristock2 = mysqli_fetch_array($caristock);
    $stocksekarang = $caristock2['stock'];

    if ($qty >= $qtysekarang) {
        $selisih = $qty - $qtysekarang;
        $newstock = $stocksekarang - $selisih;

        $query = mysqli_query($conn, "UPDATE detailpesanan SET qty='$qty' WHERE iddetailpesanan='$iddp'");
        $query2 = mysqli_query($conn, "UPDATE produk SET stock='$newstock' WHERE idproduk='$idproduk'");

        if ($query && $query2) {
            header("location:view.php?idpesan=$idpesan");
            exit;
        } else {
            echo '<script>alert("Gagal edit data");
window.location.href="view.php?idpesan=' . $idpesan . '"</script>';
        }
    } else {
        $selisih = $qtysekarang - $qty;
        $newstock = $stocksekarang + $selisih;

        $query = mysqli_query($conn, "UPDATE detailpesanan SET qty='$qty' WHERE iddetailpesanan='$iddp'");
        $query2 = mysqli_query($conn, "UPDATE produk SET stock='$newstock' WHERE idproduk='$idproduk'");

        if ($query && $query2) {
            header("location:view.php?idpesan=$idpesan");
            exit;
        } else {
            echo '<script>alert("Gagal edit data");
window.location.href="view.php?idpesan=' . $idpesan . '"</script>';
        }
    }
}


if (isset($_POST['hapuspesanan'])) {
    $idpesanan = $_POST['idpesanan'];

    // Lakukan proses penghapusan pesanan dari database
    $hapus_detail = mysqli_query($conn, "DELETE FROM detailpesanan WHERE idpesanan='$idpesanan'");
    $hapus_pesanan = mysqli_query($conn, "DELETE FROM pesanan WHERE idpesanan='$idpesanan'");

    if ($hapus_detail && $hapus_pesanan) {
        echo "Pesanan berhasil dihapus";
        // Redirect ke halaman yang sesuai setelah penghapusan berhasil
        header("Location: index.php");
        exit();
    } else {
        echo "Gagal menghapus pesanan: " . mysqli_error($conn);
    }
}

<?php
error_reporting(E_ALL ^ (E_NOTICE | E_WARNING));
require 'ceklogin.php';
if (isset($_GET['idpesan'])) {
    $idpesan = $_GET['idpesan'];

    // Query untuk mendapatkan informasi namapelanggan berdasarkan idpesanan
    $query = "SELECT pelanggan.namapelanggan FROM pesanan INNER JOIN pelanggan ON pesanan.idpelanggan = pelanggan.idpelanggan WHERE pesanan.idpesanan = $idpesan";
    $result = mysqli_query($conn, $query);

    // Periksa apakah query berhasil dieksekusi
    if ($result && mysqli_num_rows($result) > 0) {
        // Ambil hasil query
        $row = mysqli_fetch_assoc($result);
        $namapelanggan = $row['namapelanggan'];

        // Tampilkan informasi sesuai dengan 'idpesan'
        echo "<title> $namapelanggan - $idpesan</title>";

        // ... kode lainnya untuk menampilkan informasi lainnya di halaman view.php
    } else {
        echo "<title>Detail Pesanan - $idpesan</title>";
        echo "Informasi tidak ditemukan.";
    }
} else {
    header("Location: index.php");
    exit();
}



?>
<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">

    <title></title>


    <!-- Custom fonts for this template-->
    <link href="vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css">
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i" rel="stylesheet">

    <!-- Custom styles for this template-->
    <link href="css/sb-admin-2.min.css" rel="stylesheet">

</head>

<body id="page-top">

    <!-- Page Wrapper -->
    <div id="wrapper">

        <!-- Sidebar -->
        <ul class="navbar-nav bg-gradient-success sidebar sidebar-dark accordion" id="accordionSidebar">

            <!-- Sidebar - Brand -->
            <a class="sidebar-brand d-flex align-items-center justify-content-center" href="index.html">
                <div class="sidebar-brand-icon rotate-n-15">
                    <i class="fas fa-laugh-wink"></i>
                </div>
                <div class="sidebar-brand-text mx-3"><?= $namapelanggan; ?></div>
            </a>

            <!-- Divider -->
            <hr class="sidebar-divider my-0">

            <!-- Nav Item - Dashboard -->
            <li class="nav-item active">
                <a class="nav-link" href="index.php">
                    <i class="fas fa-address-card fa-fw"></i>
                    <span>Order</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="stok.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Stok barang</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="pelanggan.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Kelola pelanggan</span></a>
            </li>
            <li class="nav-item active">
                <a class="nav-link" href="masuk.php">
                    <i class="fas fa-fw fa-tachometer-alt"></i>
                    <span>Barang masuk</span></a>
            </li>


        </ul>
        <!-- End of Sidebar -->

        <!-- Content Wrapper -->
        <div id="content-wrapper" class="d-flex flex-column">

            <!-- Main Content -->
            <div id="content">

                <!-- Topbar -->
                <nav class="navbar navbar-expand navbar-light bg-white topbar mb-4 static-top shadow">

                    <!-- Sidebar Toggle (Topbar) -->
                    <button id="sidebarToggleTop" class="btn btn-link d-md-none rounded-circle mr-3">
                        <i class="fa fa-bars"></i>
                    </button>

                    <!-- Topbar Search -->
                    <form class="d-none d-sm-inline-block form-inline mr-auto ml-md-3 my-2 my-md-0 mw-100 navbar-search">
                        <div class="input-group">
                            <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="button">
                                    <i class="fas fa-search fa-sm"></i>
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- Topbar Navbar -->
                    <ul class="navbar-nav ml-auto">

                        <!-- Nav Item - Search Dropdown (Visible Only XS) -->
                        <li class="nav-item dropdown no-arrow d-sm-none">
                            <a class="nav-link dropdown-toggle" href="#" id="searchDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-search fa-fw"></i>
                            </a>
                            <!-- Dropdown - Messages -->
                            <div class="dropdown-menu dropdown-menu-right p-3 shadow animated--grow-in" aria-labelledby="searchDropdown">
                                <form class="form-inline mr-auto w-100 navbar-search">
                                    <div class="input-group">
                                        <input type="text" class="form-control bg-light border-0 small" placeholder="Search for..." aria-label="Search" aria-describedby="basic-addon2">
                                        <div class="input-group-append">
                                            <button class="btn btn-primary" type="button">
                                                <i class="fas fa-search fa-sm"></i>
                                            </button>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </li>

                        <!-- Nav Item - Alerts -->


                        <div class="topbar-divider d-none d-sm-block"></div>

                        <!-- Nav Item - User Information -->
                        <li class="nav-item dropdown no-arrow">
                            <a class="nav-link dropdown-toggle" href="#" id="userDropdown" role="button" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <span class="mr-2 d-none d-lg-inline text-gray-600 small"><?= $namapelanggan; ?></span>
                                <img class="img-profile rounded-circle" src="img/undraw_profile.svg">
                            </a>
                            <!-- Dropdown - User Information -->
                            <div class="dropdown-menu dropdown-menu-right shadow animated--grow-in" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-user fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Profile
                                </a>
                                <a class="dropdown-item" href="#">
                                    <i class="fas fa-cogs fa-sm fa-fw mr-2 text-gray-400"></i>
                                    Settings

                                    <a class="dropdown-item" href="logout.php" data-toggle="modal" data-target="#logoutModal">
                                        <i class="fas fa-sign-out-alt fa-sm fa-fw mr-2 text-gray-400"></i>
                                        Logout
                                    </a>
                            </div>
                        </li>

                    </ul>

                </nav>
                <!-- End of Topbar -->

                <!-- Begin Page Content -->
                <div class="container-fluid">
                    <!-- Page Heading -->
                    <div class="d-sm-flex align-items-center justify-content-between mb-4">
                        <h1 class="h3 mb-0 text-gray-800"> <?php echo "$namapelanggan - $idpesan"; ?></h1>
                        <a href="#" class="d-none d-sm-inline-block btn btn-sm btn-primary shadow-sm">
                            <i class="fas fa-download fa-sm text-white-50"></i> Generate Report
                        </a>
                    </div>

                    <!-- Content Row -->
                    <div class="row">
                        <!-- Earnings (Monthly) Card Example -->
                        <div class="col-lg-12">
                            <!-- Button to Open the Modal -->
                            <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#myModal">
                                TAMBAH
                            </button>

                        </div>

                        <!-- Tabel Content Row -->
                        <div class="col-md-12 col-lg-12 col-sm-12">
                            <div class="white-box">
                                <br>
                                <div class="table-responsive">
                                    <table class="table table-bordered thead-dark" id="table">
                                        <thead class="thead-dark">
                                            <tr>
                                                <th>No</th>
                                                <th>Nama produk</th>
                                                <th>Harga satuan</th>
                                                <th>Jumlah</th>
                                                <th>Subtotal</th>
                                                <th>Aksi</th>

                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php
                                            $get = mysqli_query($conn, "SELECT * FROM detailpesanan dp INNER JOIN produk pr ON dp.idproduk = pr.idproduk AND idpesanan='$idpesan'");

                                            $i = 1;
                                            while ($p = mysqli_fetch_assoc($get)) :
                                                $qty = $p['qty'];
                                                $harga = $p['harga'];
                                                $namaproduk = $p['namaproduk'];
                                                $subtotal = $qty * $harga;
                                                $idproduk = $p['idproduk'];
                                                $desc = $p['deskripsi'];
                                                $iddp = $p['iddetailpesanan'];
                                            ?>

                                                <tr>
                                                    <td><?= $i++; ?></td>
                                                    <td><?= $namaproduk; ?> (<?= $desc; ?>)</td>
                                                    <td><?= number_format($harga); ?></td>
                                                    <td><?= number_format($qty); ?></td>
                                                    <td><?= number_format($subtotal); ?></td>
                                                    <td>
                                                        <div class="btn-group" role="group" aria-label="Basic example">
                                                            <button type="button" class="btn btn-danger" data-toggle="modal" data-target="#delete<?= $idproduk; ?>">Delete</button>
                                                            <button type="button" class="btn btn-warning" data-toggle="modal" data-target="#edit<?= $idproduk; ?>">Edit</button>
                                                        </div>
                                                    </td>
                                                </tr>

                                                <!-- Modal untuk Delete -->
                                                <div class="modal fade" id="delete<?= $idproduk; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Apa Anda Yakin Ingin Menghapus?</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <form method="post">
                                                                <div class="modal-body">
                                                                    Apa Anda yakin ingin menghapus?
                                                                    <input type="hidden" name="idproduk" value="<?= $idproduk; ?>">
                                                                    <input type="hidden" name="iddp" value="<?= $iddp; ?>">
                                                                    <input type="hidden" name="idpesan" value="<?= $idpesan; ?>">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" id="submitBtn" class="btn btn-danger" name="hapusprodukpesanan">Ya</button>
                                                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Tidak</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- Akhir Modal untuk Delete -->

                                                <!-- Modal untuk Edit -->
                                                <!-- INI MODAL EDIT -->
                                                <div class="modal fade" id="edit<?= $idproduk; ?>">
                                                    <div class="modal-dialog">
                                                        <div class="modal-content">
                                                            <div class="modal-header">
                                                                <h4 class="modal-title">Ubah data</h4>
                                                                <button type="button" class="close" data-dismiss="modal">&times;</button>
                                                            </div>
                                                            <form method="post">
                                                                <div class="modal-body">
                                                                    <input type="text" name="namaproduk" class="form-control mt-2" value="<?= $namaproduk; ?> - <?= $desc; ?>" disabled>
                                                                    <input type="number" name="qty" class="form-control mt-2" value="<?= $qty; ?>">
                                                                    <input type="hidden" name="iddp" value="<?= $iddp; ?>">
                                                                    <input type="hidden" name="idproduk" value="<?= $idproduk; ?>">
                                                                    <input type="hidden" name="idpesan" value="<?= $idpesan; ?>">
                                                                </div>
                                                                <div class="modal-footer">
                                                                    <button type="submit" id="submitBtn" class="btn btn-info" name="editdetailp">Ubah</button>
                                                                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                                                                </div>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                                <!-- END MODAL EDIT -->

                                                <!-- Akhir Modal untuk Edit -->

                                            <?php endwhile; ?>
                                        </tbody>

                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- /.container-fluid -->

            </div>
            <!-- End of Main Content -->

            <!-- Footer -->
            <footer class="sticky-footer bg-white">
                <div class="container my-auto">
                    <div class="copyright text-center my-auto">
                        <span>Copyright &copy; Your Website 2021</span>
                    </div>
                </div>
            </footer>
            <!-- End of Footer -->

        </div>
        <!-- End of Content Wrapper -->

    </div>
    <!-- End of Page Wrapper -->

    <!-- Scroll to Top Button-->
    <a class="scroll-to-top rounded" href="#page-top">
        <i class="fas fa-angle-up"></i>
    </a>

    <!-- Logout Modal-->
    <div class="modal fade" id="logoutModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Ready to Leave?</h5>
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">×</span>
                    </button>
                </div>
                <div class="modal-body">Select "Logout" below if you are ready to end your current session.</div>
                <div class="modal-footer">
                    <button class="btn btn-secondary" type="button" data-dismiss="modal">Cancel</button>
                    <a class="btn btn-primary" href="logout.php">Logout</a>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap core JavaScript-->
    <script src="vendor/jquery/jquery.min.js"></script>
    <script src="vendor/bootstrap/js/bootstrap.bundle.min.js"></script>

    <!-- Core plugin JavaScript-->
    <script src="vendor/jquery-easing/jquery.easing.min.js"></script>

    <!-- Custom scripts for all pages-->
    <script src="js/sb-admin-2.min.js"></script>

    <!-- Page level plugins -->
    <script src="vendor/chart.js/Chart.min.js"></script>

    <!-- Page level custom scripts -->
    <script src="js/demo/chart-area-demo.js"></script>
    <script src="js/demo/chart-pie-demo.js"></script>

</body>
<!-- The Modal -->
<div class="modal fade" id="myModal">
    <div class="modal-dialog">
        <div class="modal-content">

            <!-- Modal Header -->
            <div class="modal-header">
                <h4 class="modal-title">Pelanggan</h4>
                <button type="button" class="close" data-dismiss="modal">&times;</button>
            </div>

            <!-- Modal body -->
            <form method="post">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="idproduk">Pilih Pelanggan:</label>
                        <select name="idproduk" id="idproduk" class="form-control" required>
                            <?php
                            $ambilproduk = mysqli_query($conn, "SELECT * FROM produk WHERE idproduk not in (SELECT idproduk FROM detailpesanan WHERE idpesanan='$idpesan')");
                            while ($pl = mysqli_fetch_array($ambilproduk)) :
                                $namaproduk = $pl['namaproduk'];
                                $stock = $pl['stock'];
                                $idproduk = $pl['idproduk'];
                                $deskripsi = $pl['deskripsi'];
                            ?>
                                <option value="<?php echo $idproduk; ?>"><?php echo $namaproduk; ?> - <?php echo $deskripsi; ?> - (Stock: <?= $stock; ?>)</option>
                            <?php endwhile; ?>
                        </select>
                        <input type="number" name="qty" class="form-control mt-4" placeholder="Masukan jumlah" required min="1">
                        <input type="hidden" name="idpesan" value="<?= $idpesan; ?>">
                    </div>
                </div>

                <!-- Modal footer -->
                <div class="modal-footer">
                    <button type="submit" id="submitBtn" class="btn btn-info" name="addproduk">Submit</button>
                    <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
                </div>
            </form>
        </div>
    </div>
</div>


</html>
<?php
require_once 'ClassForm.php';
require_once 'config.php';

$db = new Database();
$message = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['tombol'])) {
    $gambar_result = array('success' => false, 'filename' => '');
    
    // Handle file upload
    if (!empty($_FILES['gambar']['name'])) {
        $gambar_result = uploadGambar($_FILES['gambar']);
    }
    
    if ($gambar_result['success'] || empty($_FILES['gambar']['name'])) {
        $nama_menu = $db->conn->real_escape_string($_POST['nama_menu']);
        $deskripsi = $db->conn->real_escape_string($_POST['deskripsi']);
        $harga = $db->conn->real_escape_string($_POST['harga']);
        $kategori = $db->conn->real_escape_string($_POST['kategori']);
        $tersedia = $db->conn->real_escape_string($_POST['tersedia']);
        $bahan_bahan = $db->conn->real_escape_string($_POST['bahan_bahan']);
        $gambar_filename = $gambar_result['success'] ? $gambar_result['filename'] : '';
        
        $sql = "INSERT INTO menu (nama_menu, deskripsi, harga, kategori, tersedia, bahan_bahan, gambar) 
                VALUES ('$nama_menu', '$deskripsi', '$harga', '$kategori', '$tersedia', '$bahan_bahan', '$gambar_filename')";
        
        if ($db->conn->query($sql) === TRUE) {
            $message = '<div class="alert alert-success">Menu berhasil ditambahkan!</div>';
            header("refresh:2;url=index.php");
        } else {
            $message = '<div class="alert alert-danger">Error: ' . $db->conn->error . '</div>';
        }
    } else {
        $message = '<div class="alert alert-danger">' . $gambar_result['message'] . '</div>';
    }
}

// Create form
$form = new Form("tambah_menu.php", "Tambah Menu");
$form->addField("nama_menu", "Nama Menu", "text", array(), $_POST['nama_menu'] ?? '');
$form->addField("deskripsi", "Deskripsi", "textarea", array(), $_POST['deskripsi'] ?? '');
$form->addField("harga", "Harga", "text", array(), $_POST['harga'] ?? '');
$form->addField("kategori", "Kategori", "select", 
    array('makanan' => 'Makanan', 'minuman' => 'Minuman', 'snack' => 'Snack'), 
    $_POST['kategori'] ?? 'makanan');
$form->addField("tersedia", "Tersedia", "radio", 
    array('ya' => 'Ya', 'tidak' => 'Tidak'), 
    $_POST['tersedia'] ?? 'ya');
$form->addField("bahan_bahan", "Bahan-bahan", "textarea", array(), $_POST['bahan_bahan'] ?? '');
$form->addField("gambar", "Gambar Menu", "file");
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tambah Menu - Rumah Makan</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: white;
            color: #333;
        }
        .navbar {
            background-color: #F97A00;
        }
        .navbar-brand, .nav-link {
            color: white !important;
        }
        .btn-primary {
            background-color: #F97A00;
            border-color: #F97A00;
        }
        .btn-primary:hover {
            background-color: #e06d00;
            border-color: #e06d00;
        }
        .card {
            border: 1px solid #F97A00;
        }
        .card-header {
            background-color: #F97A00;
            color: white;
        }
    </style>
</head>
<body>
    <nav class="navbar navbar-expand-lg">
        <div class="container">
            <a class="navbar-brand" href="index.php">Rumah Makan</a>
            <div class="navbar-nav">
                <a class="nav-link" href="index.php">Daftar Menu</a>
                <a class="nav-link active" href="tambah_menu.php">Tambah Menu</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <div class="row justify-content-center">
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header">
                        <h4 class="mb-0">Tambah Menu Baru</h4>
                    </div>
                    <div class="card-body">
                        <?php echo $message; ?>
                        <?php $form->displayForm(); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
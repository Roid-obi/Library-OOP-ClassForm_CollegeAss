<?php
require_once 'config.php';

$db = new Database();
$search = isset($_GET['search']) ? $db->conn->real_escape_string($_GET['search']) : '';
$kategori = isset($_GET['kategori']) ? $db->conn->real_escape_string($_GET['kategori']) : '';

$where = "WHERE tersedia = 'ya'";
if (!empty($search)) {
    $where .= " AND nama_menu LIKE '%$search%'";
}
if (!empty($kategori)) {
    $where .= " AND kategori = '$kategori'";
}

$sql = "SELECT * FROM menu $where ORDER BY created_at DESC";
$result = $db->conn->query($sql);
?>

<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rumah Makan - Daftar Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: white;
            color: #333;
        }
        .navbar {
            background-color: #F97A00;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
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
            transition: transform 0.2s;
            height: 100%;
            box-shadow: rgba(0, 0, 0, 0.1) 0px 4px 12px;
        }
        .card:hover {
            transform: translateY(-5px);
        }
        .card-img-top {
            height: 200px;
            object-fit: cover;
        }
        .price {
            color: #F97A00;
            font-weight: bold;
            font-size: 1.2em;
        }
        .category-badge {
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
                <a class="nav-link active" href="index.php">Daftar Menu</a>
                <a class="nav-link" href="tambah_menu.php">Tambah Menu</a>
            </div>
        </div>
    </nav>

    <div class="container mt-4">
        <!-- Search and Filter -->
        <div class="row mb-4">
            <div class="col-md-8">
                <form method="GET" class="row g-2">
                    <div class="col-md-5">
                        <input type="text" name="search" class="form-control" placeholder="Cari menu..." value="<?php echo htmlspecialchars($search); ?>">
                    </div>
                    <div class="col-md-4">
                        <select name="kategori" class="form-select">
                            <option value="">Semua Kategori</option>
                            <option value="makanan" <?php echo $kategori == 'makanan' ? 'selected' : ''; ?>>Makanan</option>
                            <option value="minuman" <?php echo $kategori == 'minuman' ? 'selected' : ''; ?>>Minuman</option>
                            <option value="snack" <?php echo $kategori == 'snack' ? 'selected' : ''; ?>>Snack</option>
                        </select>
                    </div>
                    <div class="col-md-3">
                        <button type="submit" class="btn btn-primary w-100">Cari</button>
                    </div>
                </form>
            </div>
            <div class="col-md-4 text-end">
                <a href="tambah_menu.php" class="btn btn-primary"><i class="bi bi-plus"></i> Tambah Menu Baru</a>
            </div>
        </div>

        <!-- Menu Cards -->
        <div class="row">
            <?php if ($result->num_rows > 0): ?>
                <?php while($row = $result->fetch_assoc()): ?>
                    <div class="col-lg-2 col-md-3 col-sm-6 mb-4">
                        <div class="card">
                            <?php if (!empty($row['gambar'])): ?>
                                <img src="uploads/<?php echo $row['gambar']; ?>" class="card-img-top" alt="<?php echo htmlspecialchars($row['nama_menu']); ?>">
                            <?php else: ?>
                                <img src="https://www.svgrepo.com/show/508699/landscape-placeholder.svg" class="card-img-top" alt="No Image">
                            <?php endif; ?>
                            
                            <div class="card-body d-flex flex-column">
                                <h6 class="card-title"><?php echo htmlspecialchars($row['nama_menu']); ?></h6>
                                <p class="card-text small flex-grow-1"><?php echo substr(htmlspecialchars($row['deskripsi']), 0, 60); ?>...</p>
                                <div class="mt-auto">
                                    <span class="price">Rp <?php echo number_format($row['harga'], 0, ',', '.'); ?></span>
                                    <span class="badge category-badge float-end"><?php echo ucfirst($row['kategori']); ?></span>
                                </div>
                            </div>
                        </div>
                    </div>
                <?php endwhile; ?>
            <?php else: ?>
                <div class="col-12">
                    <div class="alert alert-info text-center">
                        Tidak ada menu yang ditemukan.
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
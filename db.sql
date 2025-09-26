-- Database: rumah_makan
CREATE DATABASE IF NOT EXISTS rumah_makan;
USE rumah_makan;

-- Table: menu
CREATE TABLE IF NOT EXISTS menu (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nama_menu VARCHAR(100) NOT NULL,
    deskripsi TEXT,
    harga DECIMAL(10,2) NOT NULL,
    kategori ENUM('makanan', 'minuman', 'snack') NOT NULL,
    tersedia ENUM('ya', 'tidak') DEFAULT 'ya',
    bahan_bahan TEXT,
    gambar VARCHAR(255),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Sample data dengan lebih banyak variasi
INSERT INTO menu (nama_menu, deskripsi, harga, kategori, tersedia, bahan_bahan) VALUES
('Nasi Goreng Spesial', 'Nasi goreng dengan telur, ayam, dan sayuran segar', 25000.00, 'makanan', 'ya', 'Nasi, Telur, Ayam, Wortel, Bawang'),
('Es Teh Manis', 'Es teh dengan gula aren asli', 8000.00, 'minuman', 'ya', 'Teh, Gula Aren, Es Batu'),
('Gado-gado', 'Salad sayuran dengan bumbu kacang khas', 18000.00, 'makanan', 'ya', 'Sayuran, Bumbu Kacang, Kerupuk'),
('Kerupuk Udang', 'Kerupuk udang renyah homemade', 5000.00, 'snack', 'ya', 'Tepung, Udang, Bumbu'),
('Soto Ayam', 'Soto ayam dengan suwiran daging dan tauge', 22000.00, 'makanan', 'ya', 'Ayam, Bumbu Soto, Tauge'),
('Es Jeruk', 'Es jeruk segar tanpa pengawet', 10000.00, 'minuman', 'ya', 'Jeruk, Gula, Es Batu'),
('Martabak Manis', 'Martabak manis dengan topping keju dan coklat', 30000.00, 'snack', 'tidak', 'Tepung, Telur, Gula, Keju'),
('Bakso Special', 'Bakso urat dengan kuah kaldu sapi', 20000.00, 'makanan', 'ya', 'Daging Sapi, Tepung, Bumbu'),
('Kopi Hitam', 'Kopi arabika pilihan', 12000.00, 'minuman', 'ya', 'Biji Kopi, Air Panas'),
('Pisang Goreng', 'Pisang goreng crispy dengan madu', 15000.00, 'snack', 'ya', 'Pisang, Tepung, Madu'),
('Ayam Bakar', 'Ayam bakar bumbu special', 35000.00, 'makanan', 'ya', 'Ayam, Bumbu Bakar'),
('Jus Alpukat', 'Jus alpukat dengan susu dan gula aren', 18000.00, 'minuman', 'ya', 'Alpukat, Susu, Gula Aren');
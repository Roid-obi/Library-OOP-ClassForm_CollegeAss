<?php
class Database {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "rumah_makan";
    public $conn;
    
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);
        
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }
    
    public function getConnection() {
        return $this->conn;
    }
}

// Upload handling function
function uploadGambar($file) {
    $target_dir = "uploads/";
    if (!is_dir($target_dir)) {
        mkdir($target_dir, 0777, true);
    }
    
    $target_file = $target_dir . basename($file["name"]);
    $imageFileType = strtolower(pathinfo($target_file, PATHINFO_EXTENSION));
    
    // Check if image file is actual image
    $check = getimagesize($file["tmp_name"]);
    if ($check === false) {
        return array('success' => false, 'message' => 'File bukan gambar.');
    }
    
    // Check file size (max 2MB)
    if ($file["size"] > 2000000) {
        return array('success' => false, 'message' => 'Ukuran file terlalu besar.');
    }
    
    // Allow certain file formats
    if (!in_array($imageFileType, array("jpg", "png", "jpeg", "gif"))) {
        return array('success' => false, 'message' => 'Hanya format JPG, JPEG, PNG & GIF yang diizinkan.');
    }
    
    // Generate unique filename
    $new_filename = uniqid() . '.' . $imageFileType;
    $target_file = $target_dir . $new_filename;
    
    if (move_uploaded_file($file["tmp_name"], $target_file)) {
        return array('success' => true, 'filename' => $new_filename);
    } else {
        return array('success' => false, 'message' => 'Error uploading file.');
    }
}
?>
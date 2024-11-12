<?php
// Database connection settings
$servername = "localhost";
$username = "root"; // Change to your MySQL username
$password = ""; // Change to your MySQL password
$dbname = "ppab";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Validate and sanitize input data
function sanitize_input($data) {
    return htmlspecialchars(stripslashes(trim($data)));
}

// Get and sanitize form data
$unit_kerja = sanitize_input($_POST['unit_kerja']);
$divisi_bagian = sanitize_input($_POST['divisi_bagian']);
$perihal = sanitize_input($_POST['perihal']);
$nomor_ppab = sanitize_input($_POST['nomor_ppab']);
$tanggal = sanitize_input($_POST['tanggal']);
$uraian = sanitize_input($_POST['uraian']);
$satuan = sanitize_input($_POST['satuan']);
$harga_satuan = filter_var($_POST['harga_satuan'], FILTER_VALIDATE_FLOAT);
$jumlah_unit = filter_var($_POST['jumlah_unit'], FILTER_VALIDATE_INT);
$sisa_anggaran = filter_var($_POST['sisa_anggaran'], FILTER_VALIDATE_FLOAT);
$capaian_percent = filter_var($_POST['capaian_percent'], FILTER_VALIDATE_FLOAT);
$anggaran_pengeluaran = filter_var($_POST['anggaran_pengeluaran'], FILTER_VALIDATE_FLOAT);

// Validate required fields
if (empty($unit_kerja) || empty($divisi_bagian) || empty($perihal) || empty($nomor_ppab) || empty($tanggal) || 
    $harga_satuan === false || $jumlah_unit === false) {
    die("Error: Required fields are missing or invalid.");
}

// formula pada tabel 'jumlah'
$jumlah = $harga_satuan * $jumlah_unit;

$stmt = $conn->prepare("INSERT INTO ppab_entries (unit_kerja, divisi_bagian, perihal, nomor_ppab, tanggal, uraian, satuan, harga_satuan, jumlah_unit, jumlah, sisa_anggaran, capaian_percent, anggaran_pengeluaran) 
                        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("sssssssdiiddi", 
    $unit_kerja, 
    $divisi_bagian, 
    $perihal, 
    $nomor_ppab, 
    $tanggal, 
    $uraian, 
    $satuan, 
    $harga_satuan, 
    $jumlah_unit, 
    $jumlah, 
    $sisa_anggaran, 
    $capaian_percent, 
    $anggaran_pengeluaran
);


if ($stmt->execute()) {
    header("Location: rekap_ppab.php");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>

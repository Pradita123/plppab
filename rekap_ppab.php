<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "ppab";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$sql = "SELECT * FROM ppab_entries ORDER BY unit_kerja, divisi_bagian, perihal, nomor_ppab, tanggal";
$result = $conn->query($sql);

$data_grouped = [];
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        $key = $row['unit_kerja'] . '|' . $row['divisi_bagian'] . '|' . $row['perihal'] . '|' . $row['nomor_ppab'] . '|' . $row['tanggal'];
        $data_grouped[$key][] = $row;
    }
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rekap PPAB Data</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background-color: #f8f9fa;
        }
        .sidebar {
            height: 100vh;
            background-color: #343a40;
            padding: 20px;
            position: fixed; 
            width: 220px; 
            color: white;
            overflow-y: auto; 
        }
        .sidebar a {
            color: #ffffff;
            text-decoration: none;
            padding: 10px;
            display: block;
            margin-bottom: 5px;
        }
        .sidebar a:hover {
            background-color: #495057;
            border-radius: 5px;
        }
        .content {
            margin-left: 240px; 
            padding: 20px; 
        }

        th {
            text-align: center;
            vertical-align: middle;
        }

        td {
            text-align: left;
            vertical-align: middle;
        }

        /* Print styles */
        @media print {
            .sidebar {
                display: none; /* Hide sidebar when printing */
            }
            .content {
                margin-left: 0; /* Remove left margin for content when printing */
                padding: 0; /* Remove padding for content when printing */
            }
            button {
                display: none; /* Hide print button when printing */
            }
            table {
                width: 100%; /* Ensure the table takes full width */
            }
            /* Hide the Created At and Actions columns */
            th:nth-child(10),
            th:nth-child(11),
            td:nth-child(10),
            td:nth-child(11) {
                display: none; /* Hide column */
            }
        }
    </style>
    <script>
        function printData() {
            window.print();
        }
    </script>
</head>
<body>
    <div class="sidebar">
        <h4>Menu</h4>
        <a href="dashboard.php">Dashboard</a> 
        <a href="rekap_ppab.php">Rekap Data</a>
        <a href="form_ppab.html">Input Data</a>
    </div>

    <div class="content">
        <h2 class="text-center mb-4">PERMINTAAN PEMAKAIAN ANGGARAN BELANJA (PPAB)</h2>

        <button class="btn btn-secondary mb-3" onclick="printData()">Print</button>

        <?php
        if (!empty($data_grouped)) {
            echo "<div class='table-responsive mb-4'>";
            echo "<table class='table table-bordered table-striped'>
                    <thead class='table-primary'>
                        <tr>
                            <th>No</th>
                            <th>Uraian</th>
                            <th>Satuan</th>
                            <th>Harga Satuan</th>
                            <th>Jumlah Unit</th>
                            <th>Jumlah</th>
                            <th>Sisa Anggaran</th>
                            <th>Capaian (%)</th>
                            <th>Anggaran Pengeluaran</th>
                            <th>Created At</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>";

            $no = 1;
            foreach ($data_grouped as $key => $rows) {
                foreach ($rows as $row) {
                    echo "<tr>
                            <td>" . $no++ . "</td>
                            <td>" . $row["uraian"] . "</td>
                            <td>" . $row["satuan"] . "</td>
                            <td>Rp " . number_format($row["harga_satuan"], 0, ',', '.') . "</td>
                            <td>" . $row["jumlah_unit"] . "</td>
                            <td>Rp " . number_format($row["jumlah"], 0, ',', '.') . "</td>
                            <td>Rp " . number_format($row["sisa_anggaran"], 0, ',', '.') . "</td>
                            <td>" . $row["capaian_percent"] . "</td>
                            <td>Rp " . number_format($row["anggaran_pengeluaran"], 0, ',', '.') . "</td>
                            <td>" . $row["created_at"] . "</td>
                            <td>
                                <form action='delete_ppab.php' method='POST' style='display:inline;'>
                                    <input type='hidden' name='id' value='" . $row["id"] . "'>
                                    <button type='submit' class='btn btn-danger btn-sm'>Delete</button>
                                </form>
                            </td>
                        </tr>";
                }
            }

            echo "</tbody>
                </table>
            </div>";
        } else {
            echo "<div class='alert alert-info'>No data available</div>";
        }
        ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

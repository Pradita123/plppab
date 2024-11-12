<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Menu</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            display: flex;
            height: 100vh; /* Full height for sidebar */
            background-color: #f8f9fa; /* Background color */
        }

        .sidebar {


            
            width: 250px; /* Fixed width for sidebar */
            background-color: #343a40; /* Sidebar background color */
            color: white; /* Text color */
            padding: 20px; /* Padding */
            position: fixed; /* Fixed position */
            height: 100%; /* Full height */
            overflow-y: auto; /* Scrollable if needed */
        }

        .sidebar h4 {
            color: #ffffff; /* Title color */
        }

        .sidebar a {
            color: #ffffff; /* Link color */
            text-decoration: none; /* Remove underline */
            padding: 10px; /* Padding for links */
            display: block; /* Block display */
            margin-bottom: 5px; /* Space between links */
        }

        .sidebar a:hover {
            background-color: #495057; /* Hover background color */
            border-radius: 5px; /* Rounded corners */
        }

        .content {
            margin-left: 270px; /* Space for the sidebar */
            padding: 20px; /* Padding for content area */
            flex-grow: 1; /* Allow content to grow */
        }
    </style>
</head>
<body>

    <!-- Fixed Sidebar -->
    <div class="sidebar">
        <h4>Menu</h4>
        <a href="dashboard.php">Dashboard</a> <!-- New Dashboard Link -->
        <a href="rekap_ppab.php">Rekap Data</a>
        <a href="form_ppab.html">Input Data</a>
    </div>

    <div class="content">
        <h2 class="mt-4">Welcome to the Sidebar Menu</h2>
        <p>This is the main content area. You can add more content here.</p>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>

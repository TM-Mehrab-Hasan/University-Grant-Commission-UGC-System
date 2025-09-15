<?php
// Start session
session_start();

// Include database connection
include('../php/db_connection.php');

// Initialize the search query if it's set
$search = '';
if (isset($_GET['search'])) {
    $search = trim($_GET['search']);
    $query = "SELECT * FROM universities WHERE name LIKE ? OR global_ranking LIKE ? ORDER BY global_ranking";
    $stmt = $conn->prepare($query);
    $search_param = "%" . $search . "%";
    $stmt->bind_param("ss", $search_param, $search_param);
    $stmt->execute();
    $result = $stmt->get_result();
} else {
    $query = "SELECT * FROM universities ORDER BY global_ranking";
    $result = $conn->query($query);
}

$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>University Grants Commission System for Ranking</title>
    <link rel="stylesheet" href="../css/style.css">
    <style>
        /* Search Bar Styles */
        .search-bar {
            margin: 30px auto;
            display: flex;
            justify-content: center;
            align-items: center;
            gap: 10px;
            max-width: 600px;
            width: 100%;
        }

        .search-bar input {
            padding: 12px;
            width: 250px;
            border-radius: 10px;
            border: 1px solid #ccc;
            font-size: 1em;
            transition: border 0.3s ease;
            text-align: center;
        }

        .search-bar input:focus {
            border-color: #0066cc;
            outline: none;
        }

        .search-bar button {
            padding: 12px 18px;
            border-radius: 10px;
            background: linear-gradient(90deg, #004080, #0066cc);
            color: white;
            border: none;
            cursor: pointer;
            transition: all 0.3s ease;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
        }

        .search-bar button:hover {
            background: #004080;
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
        }
    </style>
</head>
<body>
    <header>
        <h1>University Grants Commission System for Ranking</h1>
        <nav>
            <a href="index.html">Home</a>
            <a href="universities.php">Affiliated Universities</a>
            <a href="news.php">News</a>
            <a href="resource.php">Resources</a>
            <a href="about.php">About</a>
            <a href="contact.php">Contact</a>
            <a href="../php/logout.php">Logout</a>
        </nav>
    </header>
    <main>
        <center><h2>Affiliated Universities</h2></center>

        <!-- Search Bar -->
        <div class="search-bar">
            <form method="GET">
                <input type="text" name="search" placeholder="Search by Name or Ranking" value="<?php echo htmlspecialchars($search); ?>">
                <button type="submit">🔍</button>
            </form>
        </div>

        <!-- Display Universities -->
        <?php while($row = $result->fetch_assoc()): ?>
            <div class="university-item">
                <h3><?php echo htmlspecialchars($row['name']); ?></h3>
                <p>Departments: <?php echo htmlspecialchars($row['departments']); ?></p>
                <p>Subjects: <?php echo htmlspecialchars($row['subjects']); ?></p>
                <p>Global Ranking: <?php echo htmlspecialchars($row['global_ranking']); ?></p>
            </div>
        <?php endwhile; ?>
    </main>
</body>
</html>

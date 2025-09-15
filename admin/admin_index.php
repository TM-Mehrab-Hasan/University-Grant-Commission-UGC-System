<?php
session_start();
if (!isset($_SESSION['role']) || $_SESSION['role'] != 'admin') {
    header("Location: ../login.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - University Grants Commission System for Ranking</title>
    <link rel="stylesheet" href="../css/admin_style.css">
    <style>
        /* Custom Styles for the Admin Dashboard */
        .dashboard-container {
            padding: 20px;
            max-width: 1200px;
            margin: 0 auto;
        }

        .welcome-card {
            background: linear-gradient(135deg, var(--primary-color), var(--secondary-color));
            color: #ffffff;
            padding: 25px;
            border-radius: 12px;
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.2);
            text-align: center;
            margin-bottom: 20px;
        }

        .welcome-card h2 {
            margin: 0;
            font-size: 2em;
        }

        .welcome-card p {
            font-size: 1.2em;
            margin-top: 10px;
        }

        .dashboard-actions {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
            gap: 20px;
        }

        .action-card {
            background: #ffffff;
            border: 1px solid var(--light-border);
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            padding: 20px;
            text-align: center;
            transition: transform 0.3s ease, box-shadow 0.3s ease;
        }

        .action-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 8px 15px rgba(0, 0, 0, 0.2);
        }

        .action-card h3 {
            color: var(--primary-color);
            margin-bottom: 10px;
        }

        .action-card p {
            color: var(--text-color);
            margin-bottom: 15px;
        }

        .action-card a {
            display: inline-block;
            text-decoration: none;
            padding: 10px 16px;
            border-radius: 20px;
            background: linear-gradient(135deg, var(--secondary-color), var(--primary-color));
            color: #ffffff;
            font-weight: bold;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.1);
            transition: all 0.3s ease;
        }

        .action-card a:hover {
            background: var(--primary-color);
            transform: scale(1.05);
        }

        footer {
            background: var(--primary-color);
            color: #ffffff;
            text-align: center;
            padding: 15px;
            position: absolute;
            bottom: 0;
            width: 100%;
            box-shadow: 0 -4px 10px rgba(0, 0, 0, 0.1);
        }
    </style>
</head>
<body>
    <header>
        <h1>University Grants Commission System for Ranking</h1>
        <nav>
            <ul>
                <li><a href="admin_index.php" class="active">Home</a></li>
                <!-- <li><a href="admin_universities.php">Manage Universities</a></li>
                <li><a href="admin_resources.php">Manage Resources</a></li>
                <li><a href="admin_news.php">Manage News</a></li>
                <li><a href="admin_about.php">Manage About</a></li> -->
                <li><a href="../php/logout.php">Logout</a></li>
            </ul>
        </nav>
    </header>

    <main class="dashboard-container">
        <div class="welcome-card">
            <h2>Welcome, Admin!</h2>
            <p>Manage the system's universities, resources, news, and about section from this dashboard.</p>
        </div>

        <div class="dashboard-actions">
            <div class="action-card">
                <h3>Manage Universities</h3>
                <p>View and edit information about universities in the system.</p>
                <a href="admin_universities.php">Go to Universities</a>
            </div>
            <div class="action-card">
                <h3>Manage Resources</h3>
                <p>Oversee available resources and make updates as needed.</p>
                <a href="admin_resources.php">Go to Resources</a>
            </div>
            <div class="action-card">
                <h3>Manage News</h3>
                <p>Keep the latest news and updates in check for the users.</p>
                <a href="admin_news.php">Go to News</a>
            </div>
            <div class="action-card">
                <h3>Manage About</h3>
                <p>Edit details in the 'About' section for accurate information.</p>
                <a href="admin_about.php">Go to About</a>
            </div>
        </div>
    </main>

    <footer>
        <p>&copy; <?php echo date("Y"); ?> University Grants Commission System for Ranking</p>
    </footer>
</body>
</html>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Asset Management System</title>
    <link rel="stylesheet" href="../public/css/main.css">
    <link rel="stylesheet" href="../public/css/responsive.css">
</head>
<body>
    <nav class="navbar">
        <h1>AssetFlow</h1>
        <ul>
            <li><a href="index.php?controller=equipment&action=list">Equipment</a></li>
            <li><a href="index.php?controller=allocation&action=allocate">Allocate</a></li>
            <?php if (isset($_SESSION['user_role']) && ($_SESSION['user_role'] == 'admin' || $_SESSION['user_role'] == 'manager')): ?>
                <li><a href="index.php?controller=employee&action=list">Employees</a></li>
            <?php endif; ?>
            <?php if (isset($_SESSION['user_role'])): ?>
                <li><a href="index.php?controller=auth&action=logout">Logout (<?php echo htmlspecialchars($_SESSION['user_email']); ?>)</a></li>
            <?php endif; ?>
        </ul>
    </nav>
</body>
</html>
<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
$flash = getFlash();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= htmlspecialchars($pageTitle ?? 'Admin') ?> — WPoets Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../assets/css/admin.css">
</head>
<body>
    <nav class="navbar navbar-expand-lg navbar-dark bg-dark">
        <div class="container">
            <a class="navbar-brand" href="index.php">WPoets Admin</a>
            <div class="navbar-nav ms-auto">
                <a class="nav-link" href="index.php">Dashboard</a>
                <a class="nav-link" href="categories.php">Categories</a>
                <a class="nav-link" href="slides.php">Slides</a>
                <a class="nav-link" href="../index.php" target="_blank">View Site</a>
            </div>
        </div>
    </nav>
    <main class="container py-4">
        <?php if ($flash): ?>
            <div class="alert alert-<?= htmlspecialchars($flash['type']) ?> alert-dismissible fade show" role="alert">
                <?= htmlspecialchars($flash['message']) ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
            </div>
        <?php endif; ?>

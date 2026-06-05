<?php

require_once __DIR__ . '/../includes/functions.php';

$pageTitle = 'Dashboard';
$categories = getAllCategories();
$slides = getAllSlides();

require __DIR__ . '/includes/header.php';
?>

<h1 class="mb-4">Dashboard</h1>

<div class="row g-4">
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Categories</h5>
                <p class="display-6"><?= count($categories) ?></p>
                <a href="categories.php" class="btn btn-primary btn-sm">Manage Categories</a>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-body">
                <h5 class="card-title">Slides</h5>
                <p class="display-6"><?= count($slides) ?></p>
                <a href="slides.php" class="btn btn-primary btn-sm">Manage Slides</a>
            </div>
        </div>
    </div>
</div>

<?php require __DIR__ . '/includes/footer.php'; ?>

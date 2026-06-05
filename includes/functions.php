<?php

require_once __DIR__ . '/db.php';

function getAllCategoriesWithSlides(): array
{
    $pdo = getDbConnection();

    $categories = $pdo->query(
        'SELECT * FROM categories ORDER BY sort_order ASC, id ASC'
    )->fetchAll();

    $stmt = $pdo->query(
        'SELECT * FROM slides ORDER BY sort_order ASC, id ASC'
    );
    $slides = $stmt->fetchAll();

    $slidesByCategory = [];
    foreach ($slides as $slide) {
        $slidesByCategory[$slide['category_id']][] = $slide;
    }

    foreach ($categories as &$category) {
        $category['slides'] = $slidesByCategory[$category['id']] ?? [];
    }
    unset($category);

    return $categories;
}

function getAllCategories(): array
{
    $pdo = getDbConnection();
    return $pdo->query(
        'SELECT * FROM categories ORDER BY sort_order ASC, id ASC'
    )->fetchAll();
}

function getCategoryById(int $id): ?array
{
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('SELECT * FROM categories WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function createCategory(string $name, string $icon, int $sortOrder): int
{
    $pdo = getDbConnection();
    $stmt = $pdo->prepare(
        'INSERT INTO categories (name, icon, sort_order) VALUES (?, ?, ?)'
    );
    $stmt->execute([$name, $icon, $sortOrder]);
    return (int) $pdo->lastInsertId();
}

function updateCategory(int $id, string $name, string $icon, int $sortOrder): bool
{
    $pdo = getDbConnection();
    $stmt = $pdo->prepare(
        'UPDATE categories SET name = ?, icon = ?, sort_order = ? WHERE id = ?'
    );
    return $stmt->execute([$name, $icon, $sortOrder, $id]);
}

function deleteCategory(int $id): bool
{
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('DELETE FROM categories WHERE id = ?');
    return $stmt->execute([$id]);
}

function getAllSlides(): array
{
    $pdo = getDbConnection();
    return $pdo->query(
        'SELECT slides.*, categories.name AS category_name
         FROM slides
         JOIN categories ON categories.id = slides.category_id
         ORDER BY slides.sort_order ASC, slides.id ASC'
    )->fetchAll();
}

function getSlideById(int $id): ?array
{
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('SELECT * FROM slides WHERE id = ?');
    $stmt->execute([$id]);
    $row = $stmt->fetch();
    return $row ?: null;
}

function createSlide(int $categoryId, string $title, string $description, string $image, int $sortOrder): int
{
    $pdo = getDbConnection();
    $stmt = $pdo->prepare(
        'INSERT INTO slides (category_id, title, description, image, sort_order)
         VALUES (?, ?, ?, ?, ?)'
    );
    $stmt->execute([$categoryId, $title, $description, $image, $sortOrder]);
    return (int) $pdo->lastInsertId();
}

function updateSlide(int $id, int $categoryId, string $title, string $description, string $image, int $sortOrder): bool
{
    $pdo = getDbConnection();
    $stmt = $pdo->prepare(
        'UPDATE slides
         SET category_id = ?, title = ?, description = ?, image = ?, sort_order = ?
         WHERE id = ?'
    );
    return $stmt->execute([$categoryId, $title, $description, $image, $sortOrder, $id]);
}

function deleteSlide(int $id): bool
{
    $pdo = getDbConnection();
    $stmt = $pdo->prepare('DELETE FROM slides WHERE id = ?');
    return $stmt->execute([$id]);
}

function handleImageUpload(string $fieldName, string $existingPath = ''): string
{
    if (!isset($_FILES[$fieldName]) || $_FILES[$fieldName]['error'] === UPLOAD_ERR_NO_FILE) {
        return $existingPath;
    }

    if ($_FILES[$fieldName]['error'] !== UPLOAD_ERR_OK) {
        throw new RuntimeException('Image upload failed.');
    }

    $allowed = ['image/jpeg', 'image/png', 'image/gif', 'image/webp', 'image/svg+xml'];
    $mime = mime_content_type($_FILES[$fieldName]['tmp_name']);
    if (!in_array($mime, $allowed, true)) {
        throw new RuntimeException('Invalid image type.');
    }

    $uploadDir = __DIR__ . '/../uploads/';
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    $ext = pathinfo($_FILES[$fieldName]['name'], PATHINFO_EXTENSION);
    $filename = uniqid('img_', true) . '.' . strtolower($ext);
    $destination = $uploadDir . $filename;

    if (!move_uploaded_file($_FILES[$fieldName]['tmp_name'], $destination)) {
        throw new RuntimeException('Could not save uploaded image.');
    }

    return 'uploads/' . $filename;
}

function setFlash(string $type, string $message): void
{
    $_SESSION['flash'] = ['type' => $type, 'message' => $message];
}

function getFlash(): ?array
{
    if (!isset($_SESSION['flash'])) {
        return null;
    }
    $flash = $_SESSION['flash'];
    unset($_SESSION['flash']);
    return $flash;
}

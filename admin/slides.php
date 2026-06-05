<?php

require_once __DIR__ . '/../includes/functions.php';

$pageTitle = 'Slides';
$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $categoryId = (int) ($_POST['category_id'] ?? 0);
    $title = trim($_POST['title'] ?? '');
    $description = trim($_POST['description'] ?? '');
    $sortOrder = (int) ($_POST['sort_order'] ?? 0);
    $postAction = $_POST['action'] ?? '';
    $postId = (int) ($_POST['id'] ?? 0);
    $existingImage = $_POST['existing_image'] ?? '';

    try {
        $image = handleImageUpload('image', $existingImage);

        if ($postAction === 'create' && $title !== '' && $categoryId > 0) {
            createSlide($categoryId, $title, $description, $image, $sortOrder);
            setFlash('success', 'Slide created successfully.');
        } elseif ($postAction === 'update' && $postId > 0 && $title !== '' && $categoryId > 0) {
            updateSlide($postId, $categoryId, $title, $description, $image, $sortOrder);
            setFlash('success', 'Slide updated successfully.');
        } elseif ($postAction === 'delete' && $postId > 0) {
            deleteSlide($postId);
            setFlash('success', 'Slide deleted successfully.');
        }
    } catch (Exception $e) {
        setFlash('danger', $e->getMessage());
    }

    header('Location: slides.php');
    exit;
}

$slides = getAllSlides();
$categories = getAllCategories();
$editSlide = ($action === 'edit' && $id > 0) ? getSlideById($id) : null;

require __DIR__ . '/includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Slides</h1>
    <?php if ($action !== 'create' && !$editSlide): ?>
        <a href="?action=create" class="btn btn-primary">Add Slide</a>
    <?php endif; ?>
</div>

<?php if ($action === 'create' || $editSlide): ?>
    <?php $isEdit = (bool) $editSlide; ?>
    <div class="card mb-4">
        <div class="card-header"><?= $isEdit ? 'Edit' : 'Create' ?> Slide</div>
        <div class="card-body">
            <form method="post" enctype="multipart/form-data">
                <input type="hidden" name="action" value="<?= $isEdit ? 'update' : 'create' ?>">
                <?php if ($isEdit): ?>
                    <input type="hidden" name="id" value="<?= $editSlide['id'] ?>">
                    <input type="hidden" name="existing_image" value="<?= htmlspecialchars($editSlide['image']) ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label">Category</label>
                    <select name="category_id" class="form-select" required>
                        <option value="">Select category</option>
                        <?php foreach ($categories as $cat): ?>
                            <option value="<?= $cat['id'] ?>"
                                <?= ($editSlide['category_id'] ?? '') == $cat['id'] ? 'selected' : '' ?>>
                                <?= htmlspecialchars($cat['name']) ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div class="mb-3">
                    <label class="form-label">Title</label>
                    <input type="text" name="title" class="form-control" required
                           value="<?= htmlspecialchars($editSlide['title'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Description</label>
                    <textarea name="description" class="form-control" rows="4" required><?= htmlspecialchars($editSlide['description'] ?? '') ?></textarea>
                </div>
                <div class="mb-3">
                    <label class="form-label">Image (1:1 ratio)</label>
                    <?php if ($isEdit && $editSlide['image']): ?>
                        <div class="mb-2">
                            <img src="../<?= htmlspecialchars($editSlide['image']) ?>" alt="" width="80" height="80" class="rounded">
                        </div>
                    <?php endif; ?>
                    <input type="file" name="image" class="form-control" accept="image/*" <?= $isEdit ? '' : 'required' ?>>
                </div>
                <div class="mb-3">
                    <label class="form-label">Sort order</label>
                    <input type="number" name="sort_order" class="form-control"
                           value="<?= (int) ($editSlide['sort_order'] ?? 0) ?>">
                </div>
                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update' : 'Create' ?></button>
                <a href="slides.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
<?php endif; ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Image</th>
            <th>Title</th>
            <th>Category</th>
            <th>Sort</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($slides as $slide): ?>
            <tr>
                <td><?= $slide['id'] ?></td>
                <td>
                    <?php if ($slide['image']): ?>
                        <img src="../<?= htmlspecialchars($slide['image']) ?>" alt="" width="48" height="48" class="rounded">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($slide['title']) ?></td>
                <td><?= htmlspecialchars($slide['category_name']) ?></td>
                <td><?= $slide['sort_order'] ?></td>
                <td>
                    <a href="?action=edit&id=<?= $slide['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form method="post" class="d-inline" onsubmit="return confirm('Delete this slide?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $slide['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . '/includes/footer.php'; ?>

<?php

require_once __DIR__ . '/../includes/functions.php';

$pageTitle = 'Categories';
$action = $_GET['action'] ?? 'list';
$id = isset($_GET['id']) ? (int) $_GET['id'] : 0;

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = trim($_POST['name'] ?? '');
    $icon = trim($_POST['icon'] ?? '');
    $sortOrder = (int) ($_POST['sort_order'] ?? 0);
    $postAction = $_POST['action'] ?? '';
    $postId = (int) ($_POST['id'] ?? 0);

    try {
        if ($postAction === 'create' && $name !== '') {
            createCategory($name, $icon, $sortOrder);
            setFlash('success', 'Category created successfully.');
        } elseif ($postAction === 'update' && $postId > 0 && $name !== '') {
            updateCategory($postId, $name, $icon, $sortOrder);
            setFlash('success', 'Category updated successfully.');
        } elseif ($postAction === 'delete' && $postId > 0) {
            deleteCategory($postId);
            setFlash('success', 'Category deleted successfully.');
        }
    } catch (Exception $e) {
        setFlash('danger', $e->getMessage());
    }

    header('Location: categories.php');
    exit;
}

$categories = getAllCategories();
$editCategory = ($action === 'edit' && $id > 0) ? getCategoryById($id) : null;

require __DIR__ . '/includes/header.php';
?>

<div class="d-flex justify-content-between align-items-center mb-4">
    <h1>Categories</h1>
    <?php if ($action !== 'create' && !$editCategory): ?>
        <a href="?action=create" class="btn btn-primary">Add Category</a>
    <?php endif; ?>
</div>

<?php if ($action === 'create' || $editCategory): ?>
    <?php $isEdit = (bool) $editCategory; ?>
    <div class="card mb-4">
        <div class="card-header"><?= $isEdit ? 'Edit' : 'Create' ?> Category</div>
        <div class="card-body">
            <form method="post">
                <input type="hidden" name="action" value="<?= $isEdit ? 'update' : 'create' ?>">
                <?php if ($isEdit): ?>
                    <input type="hidden" name="id" value="<?= $editCategory['id'] ?>">
                <?php endif; ?>
                <div class="mb-3">
                    <label class="form-label">Name</label>
                    <input type="text" name="name" class="form-control" required
                           value="<?= htmlspecialchars($editCategory['name'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Icon path</label>
                    <input type="text" name="icon" class="form-control"
                           placeholder="files/images/DL-technology.svg"
                           value="<?= htmlspecialchars($editCategory['icon'] ?? '') ?>">
                </div>
                <div class="mb-3">
                    <label class="form-label">Sort order</label>
                    <input type="number" name="sort_order" class="form-control"
                           value="<?= (int) ($editCategory['sort_order'] ?? 0) ?>">
                </div>
                <button type="submit" class="btn btn-primary"><?= $isEdit ? 'Update' : 'Create' ?></button>
                <a href="categories.php" class="btn btn-secondary">Cancel</a>
            </form>
        </div>
    </div>
<?php endif; ?>

<table class="table table-striped">
    <thead>
        <tr>
            <th>ID</th>
            <th>Icon</th>
            <th>Name</th>
            <th>Sort</th>
            <th>Actions</th>
        </tr>
    </thead>
    <tbody>
        <?php foreach ($categories as $cat): ?>
            <tr>
                <td><?= $cat['id'] ?></td>
                <td>
                    <?php if ($cat['icon']): ?>
                        <img src="../<?= htmlspecialchars($cat['icon']) ?>" alt="" width="32" height="32">
                    <?php endif; ?>
                </td>
                <td><?= htmlspecialchars($cat['name']) ?></td>
                <td><?= $cat['sort_order'] ?></td>
                <td>
                    <a href="?action=edit&id=<?= $cat['id'] ?>" class="btn btn-sm btn-outline-primary">Edit</a>
                    <form method="post" class="d-inline" onsubmit="return confirm('Delete this category and all its slides?');">
                        <input type="hidden" name="action" value="delete">
                        <input type="hidden" name="id" value="<?= $cat['id'] ?>">
                        <button type="submit" class="btn btn-sm btn-outline-danger">Delete</button>
                    </form>
                </td>
            </tr>
        <?php endforeach; ?>
    </tbody>
</table>

<?php require __DIR__ . '/includes/footer.php'; ?>

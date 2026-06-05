<?php

require_once __DIR__ . '/includes/functions.php';

$categories = getAllCategoriesWithSlides();
$categoriesJson = json_encode($categories, JSON_HEX_TAG | JSON_HEX_APOS | JSON_HEX_QUOT | JSON_HEX_AMP);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>WPoets Full Stack Test</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>

<section class="content-section" id="contentSection">
    <div class="container">
        <div class="row g-0 content-row">

            <!-- Column 1: Tabs (desktop) / Accordion (mobile) -->
            <div class="col-lg-3 col-12 column-tabs">
                <div class="tabs-desktop d-none d-lg-block">
                    <ul class="nav flex-column category-tabs" role="tablist">
                        <?php foreach ($categories as $index => $category): ?>
                            <li class="nav-item">
                                <button
                                    class="category-tab <?= $index === 0 ? 'active' : '' ?>"
                                    type="button"
                                    data-category-index="<?= $index ?>"
                                    role="tab"
                                    aria-selected="<?= $index === 0 ? 'true' : 'false' ?>"
                                >
                                    <?php if ($category['icon']): ?>
                                        <img src="<?= htmlspecialchars($category['icon']) ?>"
                                             alt="<?= htmlspecialchars($category['name']) ?>"
                                             class="tab-icon">
                                    <?php endif; ?>
                                    <span class="tab-label"><?= htmlspecialchars($category['name']) ?></span>
                                </button>
                            </li>
                        <?php endforeach; ?>
                    </ul>
                </div>

                <div class="accordion-mobile d-lg-none">
                    <?php foreach ($categories as $index => $category): ?>
                        <div class="accordion-item <?= $index === 0 ? 'open' : '' ?>"
                             data-category-index="<?= $index ?>">
                            <button class="accordion-header" type="button" aria-expanded="<?= $index === 0 ? 'true' : 'false' ?>">
                                <div class="accordion-title">
                                    <?php if ($category['icon']): ?>
                                        <img src="<?= htmlspecialchars($category['icon']) ?>"
                                             alt="<?= htmlspecialchars($category['name']) ?>"
                                             class="tab-icon">
                                    <?php endif; ?>
                                    <span><?= htmlspecialchars($category['name']) ?></span>
                                </div>
                                <img src="files/images/plus-01.svg" alt="" class="accordion-icon icon-plus">
                                <img src="files/images/minus-01.svg" alt="" class="accordion-icon icon-minus">
                            </button>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

            <!-- Column 2: Slider -->
            <div class="col-lg-5 col-12 column-slider">
                <div class="slider-wrapper">
                    <div class="slider-track" id="sliderTrack">
                        <!-- Slides injected by JS -->
                    </div>
                    <div class="slider-controls">
                        <button type="button" class="slider-btn slider-prev" id="sliderPrev" aria-label="Previous slide">
                            <img src="files/images/arrow-right.svg" alt="" class="arrow-left">
                        </button>
                        <div class="slider-dots" id="sliderDots"></div>
                        <button type="button" class="slider-btn slider-next" id="sliderNext" aria-label="Next slide">
                            <img src="files/images/arrow-right.svg" alt="">
                        </button>
                    </div>
                </div>
            </div>

            <!-- Column 3: 1:1 Image (desktop only) -->
            <div class="col-lg-4 d-none d-lg-block column-image">
                <div class="image-wrapper">
                    <img src="" alt="" id="columnImage" class="column-image">
                </div>
            </div>

        </div>
    </div>
</section>

<script>
    window.categoriesData = <?= $categoriesJson ?>;
</script>
<script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
<script src="assets/js/main.js"></script>
</body>
</html>

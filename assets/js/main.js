(function ($) {
    'use strict';

    var categories = window.categoriesData || [];
    var activeCategoryIndex = 0;
    var activeSlideIndex = 0;
    var isMobile = false;

    function checkMobile() {
        isMobile = window.innerWidth < 992;
    }

    function getActiveSlides() {
        var cat = categories[activeCategoryIndex];
        return cat ? cat.slides : [];
    }

    function renderSlides() {
        var slides = getActiveSlides();
        var $track = $('#sliderTrack');
        var $dots = $('#sliderDots');

        $track.empty();
        $dots.empty();

        if (!slides.length) {
            $track.html('<p class="slide-description">No slides available for this category.</p>');
            updateColumnImage('');
            return;
        }

        if (activeSlideIndex >= slides.length) {
            activeSlideIndex = 0;
        }

        slides.forEach(function (slide, index) {
            var bgStyle = isMobile && slide.image
                ? ' style="background-image: url(\'' + slide.image + '\')"'
                : '';

            var html =
                '<div class="slide' + (index === activeSlideIndex ? ' active' : '') + '"' +
                ' data-slide-index="' + index + '"' + bgStyle + '>' +
                '<div class="slide-content">' +
                '<h2 class="slide-title">' + escapeHtml(slide.title) + '</h2>' +
                '<p class="slide-description">' + escapeHtml(slide.description) + '</p>' +
                '</div></div>';

            $track.append(html);

            var $dot = $('<button>', {
                type: 'button',
                class: 'slider-dot' + (index === activeSlideIndex ? ' active' : ''),
                'aria-label': 'Go to slide ' + (index + 1)
            }).data('index', index);

            $dots.append($dot);
        });

        updateColumnImage(slides[activeSlideIndex].image);
    }

    function updateColumnImage(src) {
        var $img = $('#columnImage');
        if (src) {
            $img.attr('src', src).attr('alt', getActiveSlides()[activeSlideIndex]?.title || '');
        } else {
            $img.attr('src', '').attr('alt', '');
        }
    }

    function goToSlide(index) {
        var slides = getActiveSlides();
        if (!slides.length) return;

        if (index < 0) index = slides.length - 1;
        if (index >= slides.length) index = 0;

        activeSlideIndex = index;

        $('.slide').removeClass('active');
        $('.slide[data-slide-index="' + index + '"]').addClass('active');

        $('.slider-dot').removeClass('active');
        $('.slider-dot').eq(index).addClass('active');

        if (!isMobile) {
            updateColumnImage(slides[index].image);
        }
    }

    function switchCategory(index) {
        if (index < 0 || index >= categories.length) return;

        activeCategoryIndex = index;
        activeSlideIndex = 0;

        $('.category-tab').removeClass('active').attr('aria-selected', 'false');
        $('.category-tab[data-category-index="' + index + '"]')
            .addClass('active').attr('aria-selected', 'true');

        $('.accordion-item').removeClass('open');
        $('.accordion-item[data-category-index="' + index + '"]').addClass('open');
        $('.accordion-header').attr('aria-expanded', 'false');
        $('.accordion-item.open .accordion-header').attr('aria-expanded', 'true');

        renderSlides();
    }

    function escapeHtml(text) {
        var div = document.createElement('div');
        div.appendChild(document.createTextNode(text));
        return div.innerHTML;
    }

    // Tab click (desktop)
    $(document).on('click', '.category-tab', function () {
        switchCategory(parseInt($(this).data('category-index'), 10));
    });

    // Accordion click (mobile)
    $(document).on('click', '.accordion-header', function () {
        var $item = $(this).closest('.accordion-item');
        var index = parseInt($item.data('category-index'), 10);

        if ($item.hasClass('open')) return;

        switchCategory(index);
    });

    // Slider controls
    $('#sliderPrev').on('click', function () {
        goToSlide(activeSlideIndex - 1);
    });

    $('#sliderNext').on('click', function () {
        goToSlide(activeSlideIndex + 1);
    });

    $(document).on('click', '.slider-dot', function () {
        goToSlide($(this).data('index'));
    });

    // Resize handler
    var resizeTimer;
    $(window).on('resize', function () {
        clearTimeout(resizeTimer);
        resizeTimer = setTimeout(function () {
            var wasMobile = isMobile;
            checkMobile();
            if (wasMobile !== isMobile) {
                renderSlides();
            }
        }, 150);
    });

    // Init
    checkMobile();
    if (categories.length) {
        renderSlides();
    }

})(jQuery);

<?php

$dir = __DIR__ . '/../files/images/slides/';
if (!is_dir($dir)) {
    mkdir($dir, 0755, true);
}

$images = [
    ['technology-1.jpg', [17, 50, 77]],
    ['technology-2.jpg', [30, 80, 120]],
    ['technology-3.jpg', [50, 100, 140]],
    ['communication-1.jpg', [196, 53, 30]],
    ['communication-2.jpg', [180, 70, 50]],
    ['communication-3.jpg', [160, 60, 45]],
    ['learning-1.jpg', [40, 90, 70]],
    ['learning-2.jpg', [60, 110, 85]],
    ['learning-3.jpg', [80, 130, 100]],
];

$size = 600;

foreach ($images as [$filename, $rgb]) {
    $path = $dir . $filename;
    $img = imagecreatetruecolor($size, $size);
    $color = imagecolorallocate($img, $rgb[0], $rgb[1], $rgb[2]);
    imagefill($img, 0, 0, $color);

    $lighter = imagecolorallocate($img, min(255, $rgb[0] + 40), min(255, $rgb[1] + 40), min(255, $rgb[2] + 40));
    imagefilledellipse($img, $size / 2, $size / 2, $size * 0.6, $size * 0.6, $lighter);

    imagejpeg($img, $path, 90);
    imagedestroy($img);
    echo "Created: $filename\n";
}

echo "Done.\n";

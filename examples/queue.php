<?php
require_once __DIR__.'/../vendor/autoload.php';

function formatBytes($bytes, $precision = 2) {
    $units = array('B', 'KB', 'MB', 'GB', 'TB');

    $bytes = max($bytes, 0);
    $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
    $pow = min($pow, count($units) - 1);

    // Uncomment one of the following alternatives
    $bytes /= pow(1024, $pow);
    // $bytes /= (1 << (10 * $pow));

    return round($bytes, $precision) . ' ' . $units[$pow];
}

// Find all the torrents
$queue = Transmission\Torrent::all();

echo sprintf("Found %d torrents\n", count($queue));

foreach ($queue as $torrent) {
    $size = formatBytes($torrent->getSize(), 2);
    echo "#{$torrent->getId()}: {$torrent->getName()} ({$size})\n";
}

<?php
require_once __DIR__.'/../vendor/autoload.php';

// Find all the torrents
$queue = Transmission\Torrent::all();

echo sprintf("Found %d torrents\n", count($queue));

foreach ($queue as $torrent) {
    echo "#{$torrent->getId()}: {$torrent->getName()} ({$size})\n";
}

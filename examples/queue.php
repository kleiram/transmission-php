<?php
require_once __DIR__.'/../vendor/autoload.php';

$transmission = new Transmission\Transmission();
echo $transmission->getSession()->getDownloadDir();
$queue = $transmission->all();

foreach ($queue as $torrent) {
    echo "{$torrent->getName()}";

    if ($torrent->isFinished()) {
        echo ": done\n";
    } else {
        if ($torrent->isDownloading()) {
            echo ": {$torrent->getPercentDone()}% ";
            echo "(eta: ". gmdate("H:i:s", $torrent->getEta()) .")\n";
        } else{
            echo ": paused\n";
        }
    }
}

$transmission->getSession()->setDownloadDir('/var/www/')->setIncompleteDir('/tmp')->save();
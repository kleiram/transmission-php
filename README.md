# PHP Transmission API

[![Build Status](https://travis-ci.org/kleiram/transmission-php.png)](https://travis-ci.org/kleiram/transmission-php)

This library provides an interface to the [Transmission](http://transmissionbt.com)
bit-torrent downloader. It provides means to get and remove torrents from
the downloader as well as adding new torrents to the download queue.

## Installation

Installation is easy using [Composer](https://getcomposer.org):

```json
{
    "require": {
        "kleiram/transmission-php": "dev-master"
    }
}
```

## Usage

Using the library is as easy as installing it:

```php
<?php
use Transmission\Transmission;

// This will connect to localhost:9091 (the defaults)
$transmission = new Transmission();

// This will connect to example.org:8081
$transmission = new Transmission('example.org', 8081);

// This will get a list of torrents
$torrents = $transmission->getTorrents();

// This will get the torrent with id 1
$torrent = $transmission->getTorrent(1);

// This will add a torrent using the path of the torrent file (or magnet link!)
$torrent = $transmission->addTorrent(/* path to torrent file */);

// This will remove a torrent from Transmission
$transmission->removeTorrent($torrent);
```

To find out which information is contained by the torrent, check
[Transmission\Model\Torrent](https://github.com/kleiram/transmission-php/tree/master/lib/Transmission/Model/Torrent.php).

## License

This library is licensed under the BSD 2-clause license.

    Copyright (c) 2013, Ramon Kleiss <ramon@cubilon.n>
    All rights reserved.

    Redistribution and use in source and binary forms, with or without
    modification, are permitted provided that the following conditions are met:

    1. Redistributions of source code must retain the above copyright notice, this
       list of conditions and the following disclaimer.
    2. Redistributions in binary form must reproduce the above copyright notice,
       this list of conditions and the following disclaimer in the documentation
       and/or other materials provided with the distribution.

    THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND
    ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED
    WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE
    DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR
    ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES
    (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES;
    LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND
    ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT
    (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS
    SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

    The views and conclusions contained in the software and documentation are those
    of the authors and should not be interpreted as representing official policies,
    either expressed or implied, of the FreeBSD Project.


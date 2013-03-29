# PHP Transmission API

[![Build Status](https://travis-ci.org/kleiram/transmission-php.png)](https://travis-ci.org/kleiram/transmission-php)

This library enables you to communicate with an instance of the
[Transmission](http://transmissionbt.com) Daemon or the GUI application
using the RPC API provided by Transmission.

## Installation

Installation is easy using Composer:

```json
{
    "require": {
        "kleiram/transmission-php": "dev-master"
    }
}
```

## Usage

Currently, the library can add torrents, get torrents and remove torrents
from and to Transmission:

```php
$transmission = new Transmission\Service();

// Get all the torrents Transmission contains
$torrents = $transmission->get();

// Get a specific torrent by id
$torrent = $transmission->get(1);

// Add a torrent to Transmission
$torrent = $transmission->add(/* the URL, magent link or filename of the torrent */);

// Remove a torrent from Transmission
$transmission->remove(1);
```

Each of the `torrent` variables is an instance of the class
`Transmission\Model\Torrent` which contains the following information:

 - The torrent ID (`id`)
 - The name of the torrent (`name`)
 - The size of the torrent (`size`)
 - The date the torrent is expected to be done (`doneDate`)
 - The files the torrent contains (`files`)
 - The peers that are used to download the torrent (`peers`)
 - The trackers used to download the torrent (`trackers`)

### Files

The files that are contained by a `Torrent` instance are instances of the
class `Transmission\Model\File` which allows access to:

 - The name of the file (`name`)
 - The size of the file (`size`)
 - How much of the file is already downloaded (`completed`)

### Peers

The peers used to download the torrent are stored in the `peers` variable and
contain:

 - The address of the peer (`address`)
 - The port which is used to connect to the peer (`port`)

### Trackers

The trackers are instances of the `Transmission\Model\Tracker` class which
have:

 - The id of the tracker (`tracker`)
 - `announce` (no idea, I think the announce URI used)
 - `scrape` (no idea either)
 - `tier` (what is that?)

## LICENSE

This library is licensed under the BSD 2-clause license:

```
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
```

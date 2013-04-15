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
use Transmission\Torrent;

// Getting all the torrents currently in the download queue
$torrents = Torrent::all();

// Getting a specific torrent from the download queue
$torrent = Torrent::get(1);

// Adding a torrent to the download queue
$torrent = Torrent::add(/* path to torrent */);

// Removing a torrent from the download queue
$torrent = Torrent::get(1);
$torrent->delete();

// Or if you want to delete all local data too
$torrent->delete(true);

// You can also get the Trackers that the torrent currently uses
// These are instances of the Transmission\Model\Tracker class
$trackers = $torrent->getTrackers();

// Getting the files downloaded by the torrent are available too
// These are instances of Transmission\Model\File
$files = $torrent->getFiles();

// You can start, stop, verify the torrent and ask the tracker for
// more peers to connect to
$torrent->stop();
$torrent->start();
$torrent->start(true); // Pass true if you want to start the torrent immediatly
$torrent->verify();
$torrent->reannounce();
```

To find out which information is contained by the torrent, check
[`Transmission\Model\Torrent`](https://github.com/kleiram/transmission-php/tree/master/lib/Transmission/Model/Torrent.php).

By default, the library will try to connect to `localhost:9091`. If you want to
connect to an other host or port you can create a new `Transmission\Client` and
pass that to the static methods described above:

```php
<?php
use Transmission\Client;
use Transmission\Torrent;

$client = new Client('example.com', 33);

$torrents = Torrent::all($client);
$torrent  = Torrent::get(1, $client);
$torrent  = Torrent::add(/* path to torrent */, $client);

// When you already have a torrent, you don't have to pass the client again
$torrent->delete();
```

It is also possible to pass the torrent data directly instead of using a file
but the metadata must be base64-encoded:

```php
<?php
use Transmission\Torrent;

// Instead of null you can pass a Transmission\Client instance
$torrent = Torrent::add(/* base64-encoded metainfo */, null, true);
```

If the Transmission server is secured with a username and password you can
authenticate using the `Client` class:

```php
<?php
use Transmission\Client;
use Transmission\Torrent;

$client = new Client();
$client->authenticate('username', 'password');

// And you should pass the client to any static method you call!
$torrent = Torrent::get(1, $client);
```

For more examples, see the
[`examples`](https://github.com/kleiram/transmission-php/tree/master/examples)
directory.

## Testing

Testing is done using [PHPUnit](https://github.com/sebastianbergmann/phpunit). To
test the application, you have to install the dependencies using Composer before
running the tests:

```bash
$ curl -s https://getcomposer.org/installer | php
$ php composer.phar install
$ phpunit --coverage-text
```

## Changelog

    Version     Changes

    0.1.0       - Initial release

    0.2.0       - Rewrote the entire public API

    0.3.0       - Added support for authentication

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


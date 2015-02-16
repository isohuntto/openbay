<?php
return [
    // torrent module
    'download.php' => 'torrent/default/download',
    'torrents' => 'torrent/default/index',
    'torrent/<id:\d+>/<name:.*>' => 'torrent/default/view',
    'torrent/<id:\d+>' => 'torrent/default/view',
];

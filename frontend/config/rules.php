<?php
return [
    // torrent module
    'download.php' => 'torrent/default/download',
    'torrents' => 'torrent/default/index',
    'torrent/<id:\d+>/<name:.*>' => 'torrent/default/view',
    'torrent/<id:\d+>' => 'torrent/default/view',

    /* User profile */
    [
        'pattern' => 'profile/<name:\w+>',
        'route' => 'userprofile/default/profile',
        'defaults' => ['name' => ''],
    ],
    'feed/follow/<name:\w+>' => 'feed/default/follow',
    'feed/unfollow/<name:\w+>' => 'feed/default/unfollow',
    'feed' => 'feed/default/feed',
];

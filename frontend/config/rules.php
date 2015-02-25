<?php
return [
    // Module Torrent
    'download.php' => 'torrent/default/download',
    'torrents' => 'torrent/default/index',
    'torrents/<username:.*>' => 'torrent/default/torrents',
    'torrent/<id:\d+>/<name:.*>' => 'torrent/default/view',
    'torrent/<id:\d+>' => 'torrent/default/view',

    // Module Follower
    'following' => 'follower/default/following',
    'followers' => 'follower/default/followers',
    'follow/<username:.*>' => 'follower/default/follow',
    'unfollow/<username:.*>' => 'follower/default/unfollow',
];

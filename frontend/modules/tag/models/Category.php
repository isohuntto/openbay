<?php

namespace frontend\modules\tag\models;

use common\models\torrent\Torrent;

class Category extends \common\models\tag\Category {

    public static function getTorrentTags(Torrent $torrent) {
        if (empty($torrent->tags)) {
            return array();
        }

        $tags = explode(',', $torrent->tags);
        return $tags;
    }

    public static function getTorrentCategoryTag(Torrent $torrent) {
        $tags = self::getTorrentTags($torrent);
        if (empty($tags)) {
            return strtolower(self::getTag(self::OTHER));
        }
        return $tags[0];
    }
}

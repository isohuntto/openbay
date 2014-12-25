<?php

class LTorrent extends CActiveRecord
{
    public static $defaultSortAttributes = array(
        'id' => array(
            'default' => 'desc',
            'asc' => 'id',
            'desc' => 'id desc'
        ),
        'created_at' => array(
            'default' => 'desc',
            'asc' => 'id',
            'desc' => 'id desc'
        ),
        'size' => array(
            'default' => 'desc',
            'asc' => 'size',
            'desc' => 'size desc'
        ),
        'seeders' => array(
            'default' => 'desc',
            'asc' => 'seeders',
            'desc' => 'seeders desc'
        ),
        'leechers' => array(
            'default' => 'desc',
            'asc' => 'leechers',
            'desc' => 'leechers desc'
        )
    );

    const SYNC_STATUS_UPLOADED = 0;

    const SYNC_STATUS_SYNCHRONIZED = 1;

    const TORRENT_STATUS_UNCHECKED = 0;

    const TORRENT_STATUS_GOOD = 1;

    const TORRENT_STATUS_SUSPECTED = 2;

    const TORRENT_STATUS_FAKE = 3;

    const TORRENT_STATUS_REMOVED = 4;

    const VISIBLE_STATUS_VISIBLE = 0;

    const VISIBLE_STATUS_DIRECT = 1;

    const VISIBLE_STATUS_INVISIBLE = 2;

    const VISIBLE_STATUS_REGISTERED_ONLY = 3;

    protected static $torrentVisibleStatusRelations = array(
        // Visible
        self::TORRENT_STATUS_UNCHECKED => self::VISIBLE_STATUS_VISIBLE,
        self::TORRENT_STATUS_GOOD => self::VISIBLE_STATUS_VISIBLE,
        self::TORRENT_STATUS_SUSPECTED => self::VISIBLE_STATUS_VISIBLE,
        // Direct
        self::TORRENT_STATUS_FAKE => self::VISIBLE_STATUS_DIRECT,
        // View
        self::TORRENT_STATUS_REMOVED => self::VISIBLE_STATUS_INVISIBLE
    );

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    /**
     *
     * @return string the associated database table name
     */
    public function tableName()
    {
        return 'torrents';
    }

    public function attributeLabels()
    {
        return array(
            'category_id' => Yii::t('model_titles', 'Category'),
            'file' => Yii::t('model_titles', 'Torrent file'),
            'cover' => Yii::t('model_titles', 'Cover')
        );
    }

    public function scopes()
    {
        return array(
            'allowed' => array(
                'condition' => 'torrent_status IN(:unchecked, :good) AND visible_status = :visible',
                'params' => array(
                    ':unchecked' => self::TORRENT_STATUS_UNCHECKED,
                    ':good' => self::TORRENT_STATUS_GOOD,
                    ':visible' => self::VISIBLE_STATUS_VISIBLE
                )
            )
        );
    }

    public function getPreparedName($name = '')
    {
        if (empty($name)) {
            $name = $this->name;
        }

        $name = preg_replace(array(
            '#\[[^\]]+\]#sui',
            '#{[^}]+}#sui',
            '#\W+#sui'
        ), ' ', $name);

        $breakWords = array(
            '\([^\)]+\)',
            '[1|2]\d{3}',
            's\d{1,2}e\d{1,2}',
            'camrip',
            '\scam',
            '\s+ts\s*',
            'dvd',
            'dvdrip',
            'dvd-rip',
            'bdrip',
            'bd-rip',
            'brrip',
            'br-rip',
            'hdrip',
            'hdtvrip',
            'hdtv-rip',
            'telesync',
            'bd-remux',
            'bluray-remux',
            'tvrip',
            'tv-rip',
            'satrip',
            'sat-rip',
            'dvdscreener',
            'dvdscr',
            'dvd-screener',
            'scr',
            'dvd5',
            'dvd-5',
            'dvd9',
            'dvd-9',
            'webrip',
            'hdtv',
            'blu-*ray',
            '\sts',
            'divx',
            'xvid',
            'v\so',
            'vid',
            '3d',
            '480',
            '720p',
            '1080p',
            '720i',
            '1080i',
            'ac3',
            'rip',
            'avi',
            'mkv',
            'mpg',
            'mp3',
            'mp4',
            'wmv',
            '\stv',
            '\s\+',
            'english',
            'french',
            'spanish',
            'german',
            'hindi',
            'flac',
            'ape',
            'lossless',
            'cdv',
            'cved',
            'dts',
            'dtsaudio',
            'torrent'
        );
        foreach ($breakWords as $word) {
            if (preg_match('#\s+' . $word . '#sui', $name, $matches)) {
                $pos = mb_strpos($name, $matches[0]);
                $name = str_replace(mb_substr($name, $pos), '', $name);
            }
        }

        return trim(preg_replace('#\s+#sui', ' ', $name));
    }

    public function getUrl()
    {
        return Yii::app()->createUrl('main/torrent', array(
            'id' => $this->id,
            'name' => self::getUrlName($this->name)
        ));
    }

    public static function getUrlName($name)
    {
        // replace non letter or digits by -
        $name = preg_replace('#[^\\pL\d]+#u', '-', $name);
        $name = trim($name, '-');

        // remove unwanted characters
        $name = preg_replace('#[^-\w]+#u', '', $name);

        if (empty($name)) {
            return 'n-a';
        }
        return $name;
    }

    /**
     * Internal site url
     */
    public function getDownloadUrl()
    {
        static $url = null;
        if (is_null($url)) {
            $url = 'http://torcache.net/torrent/' . strtoupper($this->hash) . '.torrent';
            $hdrs = get_headers($url);
            if (substr($hdrs[0], 9, 3) != '200') {
                $url = false;
            }
        }
        return $url;
    }

    public function getMagnetLink()
    {
        $params = array(
            'dn' => $this->name,
            'xl' => $this->size,
            'dl' => $this->size
        );

        $magnetLink = 'magnet:?xt=urn:btih:' . $this->hash . '&amp;' . http_build_query($params, '', '&amp;');

        return $magnetLink;
    }

    public function findByHash($hash)
    {
        if (empty($hash)) {
            return null;
        }
        return self::model()->findByAttributes(array(
            'hash' => $hash
        ));
    }

    public function getFormatedSize($size = null, $precision = 2)
    {
        $units = array(
            'B',
            'KB',
            'MB',
            'GB',
            'TB'
        );

        if (null === $size) {
            $size = $this->size;
        }

        $bytes = max($size, 0);
        $pow = floor(($bytes ? log($bytes) : 0) / log(1024));
        $pow = min($pow, count($units) - 1);

        $bytes /= pow(1024, $pow);

        return round($bytes, $precision) . '&nbsp;' . $units[$pow];
    }

    public function getTags()
    {
        if (empty($this->tags)) {
            return array();
        }

        $tags = explode(',', $this->tags);
        return $tags;
    }


    public function getCategoryTag()
    {
        $tags = $this->getTags();
        if (empty($tags)) {
            return strtolower(LCategory::getCategoryTag(LCategory::OTHER));
        }
        return $tags[0];
    }

    public function getCategoryTagId()
    {
        $tags = $this->getTags();
        if (empty($tags)) {
            return LCategory::OTHER;
        }
        $lowedCategories = array_map(function ($val) {return strtolower($val);}, LCategory::$categoriesTags);
        if ($id = array_search($tags[0], $lowedCategories)) {
            return $id;
        }
        return LCategory::OTHER;
    }


    public function getSphinxDataProvider(SearchForm $model)
    {
        $objCommon = $this->getSphinxSearchObject($model);
        $defaultSortOrder = $objCommon->getOrders() ? array() : array('id' => CSort::SORT_DESC);
        if (!empty($model->words)) {
            $defaultSortOrder = array_merge(array('weight()' => CSort::SORT_DESC), $defaultSortOrder);
        }

        return new LSphinxDataProvider("LTorrent", $objCommon, array(
            'pagination' => array(
                'class' => 'Pagination',
                'pageSize' => 40,
            ),
            'sort' => array(
                'attributes' => LTorrent::$defaultSortAttributes,
                'sortVar' => 'Torrent_sort',
                'defaultOrder' => $defaultSortOrder,
            )
        ));
    }

    protected function getSphinxSearchObject(SearchForm $model)
    {
        $objCommon = new ESphinxQL();
        $objCommon->addField('id')->addIndex(Yii::app()->params['sphinx']['indexes']['torrents']);

        // Keywords
        $searchPattern = '';
        if (! empty($model->words)) {
            if (is_array($model->words)) {
                $wordQuery = $model->words;
                foreach ($wordQuery as $key => $word) {
                    $wordQuery[$key] = $objCommon->halfEscapeMatch($word);
                }
                $exact = '"' . implode(' ', $wordQuery) . '"';
                $approximite = $exact . '/5';
                usort($wordQuery, function ($a, $b)
                {
                    $a = mb_strlen($a, 'utf-8');
                    $b = mb_strlen($b, 'utf-8');
                    if ($a === $b) {
                        return 0;
                    }
                    return $a > $b ? - 1 : 1;
                });

                $tmp = array();
                $tmp[] = $exact;
                foreach ($wordQuery as $word) {
                    if (mb_strlen($word, 'utf-8') > 3) {
                        $tmp[] = $word;
                    }
                }
                $tmp[] = $approximite;
                $search = join(' | ', $tmp);
            } else {
                $search = $objCommon->halfEscapeMatch($model->words);
            }

            $searchPattern .= '@name ' . $search;
            $objCommon->option('ranker', 'expr(\'' . 'sum((4*lcs+2*(min_hit_pos==1)+exact_hit)*user_weight)*1000+bm25 + '
                . '(created_at - 1000000000) / (NOW() - 1000000000) * 100 + if(torrent_status=1,100,0)\')');
        }

        // Tag
        if (! empty($model->tags)) {
            $searchPattern .= ' @tags "=' . $model->tags . '"';
        }

        $objCommon->order('weight()', 'DESC');
        $objCommon->order('id', 'DESC');

        if (! empty($searchPattern)) {
            $objCommon->search($searchPattern);
        }

        // Filter torrents by age
        if (! empty($model->age)) {
            $objCommon->where('created_at', time() - $model->age * 86400, '>=', true);
        }

        return $objCommon;
    }

    public static function getLastTorrentIdsByCategories($count = 5, $forceRefresh = false)
    {
        $key = 'tags_last_torrents_ids';
        $torrentsIds = Yii::app()->cache->get($key);

        try {
            if (empty($torrentsIds) || $forceRefresh) {
                $torrentsIds = array();
                $tags = LCategory::$categoriesTags;
                foreach ($tags as $tag) {
                    $obj = new ESphinxQL();
                    $obj->addField('id')
                        ->addIndex(Yii::app()->params['sphinx']['indexes']['torrents'])
                        ->option('ranker', 'SPH04')
                        ->search('@tags "' . $obj->halfEscapeMatch($tag) . '"')
                        ->where('torrent_status', LTorrent::TORRENT_STATUS_GOOD)
                        ->order('weight()', 'DESC')
                        ->order('id', 'DESC')
                        ->limit($count);

                    $torrentsIds = array_merge($torrentsIds, Yii::app()->sphinx->cache(600)->createCommand($obj->build())->queryColumn());
                }
                Yii::app()->cache->set($key, $torrentsIds);
            }
        } catch (Exception $e) {
            Yii::log('getLastTorrentIdsByCategories failed. Exception: ' . $e->getMessage() . PHP_EOL . 'Trace: ' . $e->getTraceAsString(), CLogger::LEVEL_ERROR);

            if (YII_DEBUG) {
                throw $e;
            }
        }

        return $torrentsIds;
    }

    public function getBBParsed($str = null)
    {
        if ($str === null) {
            $str = $this->description;
        }
        if (! extension_loaded('bbcode')) {
            return $str;
        }
        $arrayBBCode = array(
            '' => array(
                'type' => BBCODE_TYPE_ROOT,
                'childs' => '!i'
            ),
            'b' => array(
                'type' => BBCODE_TYPE_NOARG,
                'open_tag' => '<b>',
                'close_tag' => '</b>'
            ),
            'i' => array(
                'type' => BBCODE_TYPE_NOARG,
                'open_tag' => '<i>',
                'close_tag' => '</i>',
                'childs' => 'b'
            ),
            'u' => array(
                'type' => BBCODE_TYPE_NOARG,
                'open_tag' => '',
                'close_tag' => ''
            ),
            's' => array(
                'type' => BBCODE_TYPE_NOARG,
                'open_tag' => '',
                'close_tag' => ''
            ),
            'img' => array(
                'type' => BBCODE_TYPE_NOARG,
                'open_tag' => '<img src="',
                'close_tag' => '" />',
                'childs' => ''
            ),
            'url' => array(
                'type' => BBCODE_TYPE_OPTARG,
                'open_tag' => '<a href="{PARAM}">',
                'close_tag' => '</a>',
                'default_arg' => '{CONTENT}',
                'childs' => 'b,i'
            ),
            'quote' => array(
                'type' => BBCODE_TYPE_NOARG,
                'open_tag' => '',
                'close_tag' => ''
            ),
            'code' => array(
                'type' => BBCODE_TYPE_NOARG,
                'open_tag' => '<pre>',
                'close_tag' => '</pre>'
            ),
            'size' => array(
                'type' => BBCODE_TYPE_OPTARG,
                'open_tag' => '',
                'close_tag' => '',
                'default_arg' => '{CONTENT}',
                'childs' => 'b,i'
            ),
            'color' => array(
                'type' => BBCODE_TYPE_OPTARG,
                'open_tag' => '',
                'close_tag' => '',
                'default_arg' => '{CONTENT}',
                'childs' => 'b,i'
            )
        );
        $BBHandler = bbcode_create($arrayBBCode);
        return bbcode_parse($BBHandler, $str);
    }

    public function getPureDescription($str = null)
    {
        if ($str === null) {
            $str = $this->description;
        }
        $p = new CHtmlPurifier();
        $p->options = array(
            'HTML.Allowed' => 'br,p,ul,li,b,i,a[href],pre,img[src|alt]',
            'HTML.Nofollow' => true,
            'Core.EscapeInvalidTags' => true
        );
        return $p->purify($str);
    }

    public function getDescriptionWithLazyImage($str = null)
    {
        if ($str === null) {
            $str = $this->description;
        }
        return preg_replace('#(<img[^>]+?)(src=("[^"]"|[^\s>]+))([^>]*>)#sui', '\1 data-url=\3 src="" \4', $str);
    }

    protected function replaceImageLinksWithTag($str)
    {
        $str = preg_replace('#\[img\]\s*(http://[^\[\ ]+)\s*\[/img\]#sui', '<img src="\\1" />', $str);
        $str = preg_replace('#(?<!["=])http://[^\[\ ]+\.(jpeg|jpg|png|gif)#sui', '<img src="\\0" />', $str);
        return $str;
    }

    public function getFullyPreparedDescription()
    {
        $str = $this->getBBParsed();
        $str = $this->getPureDescription($str);
        $str = $this->replaceImageLinksWithTag($str);
        $str = $this->getDescriptionWithLazyImage($str);
        return $str;
    }
}

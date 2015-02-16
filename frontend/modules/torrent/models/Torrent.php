<?php

namespace frontend\modules\torrent\models;

use Yii;
use common\models\torrent\Scrape;
use yii\data\ActiveDataProvider;
use yii\data\ArrayDataProvider;
use yii\helpers\HtmlPurifier;

/**
 * This is the model class for table "torrents".
 */
class Torrent extends \common\models\torrent\Torrent
{

    protected $fileProvider = null;
    protected $scrapeProvider = null;

    protected $localFileCache = null;

    /**
     * Get torrent list
     * @return ActiveDataProvider
     */
    public function search()
    {
        return new ActiveDataProvider([
            'query' => static::find()->with('scrapes'),
        ]);
    }

    /**
     * File list in torrent
     * @return ArrayDataProvider
     */
    public function getFilesDataProvider()
    {
        if (empty($this->fileProvider)) {
            $this->fileProvider = new ArrayDataProvider([
                'allModels' => $this->files,
                'pagination' => false,
            ]);
        }
        return $this->fileProvider;
    }

    public function getScrapesDataProvider()
    {
        if (empty($this->scrapeProvider)) {
            $this->scrapeProvider = new ArrayDataProvider([
                'allModels' => $this->scrapes,
                'pagination' => false,
            ]);
        }
        return $this->scrapeProvider;
    }

    /**
     * Get url for torrent view
     * @return string
     */
    public function getUrl()
    {
        return Yii::$app->urlManager->createUrl(['torrent/default/view', 'id' => $this->id, 'name' => $this->getUrlName()]);
    }

    /**
     * Prepared name for url
     * @return string
     */
    protected function getUrlName()
    {
        // replace non letter or digits by -
        $name = preg_replace('#[^\\pL\d]+#u', '-', $this->name);
        $name = trim($name, '-');

        // remove unwanted characters
        $name = preg_replace('#[^-\w]+#u', '', $name);

        if (empty($name)) {
            return 'n-a';
        }
        return $name;
    }

    /**
     * Replace bbcodes if enabled php extension
     * @param null $str
     * @return string
     */
    protected function getBBParsed($str = null)
    {
        if ($str === null) {
            $str = $this->description;
        }
        if (! extension_loaded('bbcode')) {
            return $str;
        }
        $arrayBBCode = [
            '' => [
                'type' => BBCODE_TYPE_ROOT,
                'childs' => '!i'
            ],
            'b' => [
                'type' => BBCODE_TYPE_NOARG,
                'open_tag' => '<b>',
                'close_tag' => '</b>'
            ],
            'i' => [
                'type' => BBCODE_TYPE_NOARG,
                'open_tag' => '<i>',
                'close_tag' => '</i>',
                'childs' => 'b'
            ],
            'u' => [
                'type' => BBCODE_TYPE_NOARG,
                'open_tag' => '',
                'close_tag' => ''
            ],
            's' => [
                'type' => BBCODE_TYPE_NOARG,
                'open_tag' => '',
                'close_tag' => ''
            ],
            'img' => [
                'type' => BBCODE_TYPE_NOARG,
                'open_tag' => '<img alt="image" src="',
                'close_tag' => '" />',
                'childs' => ''
            ],
            'url' => [
                'type' => BBCODE_TYPE_OPTARG,
                'open_tag' => '<a href="{PARAM}" rel="nofollow">',
                'close_tag' => '</a>',
                'default_arg' => '{CONTENT}',
                'childs' => 'b,i,img'
            ],
            'quote' => [
                'type' => BBCODE_TYPE_NOARG,
                'open_tag' => '',
                'close_tag' => ''
            ],
            'code' => [
                'type' => BBCODE_TYPE_NOARG,
                'open_tag' => '<pre>',
                'close_tag' => '</pre>'
            ],
            'size' => [
                'type' => BBCODE_TYPE_OPTARG,
                'open_tag' => '',
                'close_tag' => '',
                'default_arg' => '{CONTENT}',
                'childs' => 'b,i'
            ],
            'color' => [
                'type' => BBCODE_TYPE_OPTARG,
                'open_tag' => '',
                'close_tag' => '',
                'default_arg' => '{CONTENT}',
                'childs' => 'b,i'
            ]
        ];
        $BBHandler = bbcode_create($arrayBBCode);
        return bbcode_parse($BBHandler, $str);
    }

    /**
     * Purify html
     * @param null $str
     * @return string
     */
    protected function getPureDescription($str = null)
    {
        if ($str === null) {
            $str = $this->description;
        }
        $options = [
            'HTML' => [
                'Allowed' => 'br,p,ul,li,b,i,a[href],pre,img[src|alt]',
                'Nofollow' => true,
            ],
            'Core' => [
                'EscapeInvalidTags' => true
            ],
            'AutoFormat' => [
                'RemoveEmpty' => true,
                'AutoParagraph' => false,
            ],
        ];
        return HtmlPurifier::process($str, $options);
    }

    /**
     * @param null $str
     * @return mixed
     */
    protected function getDescriptionWithLazyImage($str = null)
    {
        if ($str === null) {
            $str = $this->description;
        }
        return preg_replace('#(<img[^>]+?)(src=("[^"]"|[^\s>]+))([^>]*>)#sui', '\1 data-url=\3 src="" \4', $str);
    }

    protected function replaceImageLinksWithTag($str)
    {
        $str = preg_replace('#(?<!["=])http://[^\[\ ]+\.(jpeg|jpg|png|gif)#sui', '<img src="\\0" alt="image" />', $str);
        return $str;
    }

    public function getPreparedDescription($lazy = true)
    {
        $str = $this->getBBParsed();
        if ($this->description !== $str) {
            $str = nl2br($str);
        }
        $str = $this->getPureDescription($str);

        if (!preg_match('#<[^>]+>#sui', $str)) {
            $str = '<pre>' . $str . '</pre>';
        }

        if ($lazy) {
            $str = $this->replaceImageLinksWithTag($str);
            $str = $this->getDescriptionWithLazyImage($str);
        }

        return $str;
    }

    public function getMagnetLink()
    {
        $params = [
            'dn' => $this->name,
            'xl' => $this->size,
            'dl' => $this->size
        ];

        $magnetLink = 'magnet:?xt=urn:btih:' . $this->hash . '&amp;' . http_build_query($params, '', '&amp;');

        $scrapes = $this->scrapes;
        $i = 0;
        foreach ($scrapes as $tracker) {
            if ($tracker->status === Scrape::STATUS_GOOD) {
                $magnetLink .= '&amp;tr=' . str_replace('scrape', 'announce', $tracker->name);
                if (--$i >= 3) {
                    break;
                }
            }
        }

        return $magnetLink;
    }

    public function getDownloadLink()
    {
        $params = [
            'id' => 0,
            'name' => $this->name,
            'hash' => $this->hash
        ];
        if ($this->torrentFileIsLocal()) {
            return '/download.php?' . http_build_query($params);
        } else {
            return Yii::$app->params['torrentFilesServer'] . '/download.php?' . http_build_query($params);
        }
    }

    public function getFilePath()
    {
        return $this->FILE_DIR . '/' . $this->hash;
    }

    public function torrentFileIsLocal()
    {
        if ($this->localFileCache === null) {
            $this->localFileCache = file_exists($this->getFilePath());
        }
        return $this->localFileCache;
    }
}

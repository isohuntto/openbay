<?php

namespace frontend\modules\search\models;

use Yii;
use yii\sphinx\Query;
use yii\sphinx\ActiveQuery;
use yii\db\Expression;
use yii\data\ArrayDataProvider;
use frontend\modules\torrent\models\Torrent;
use frontend\modules\tag\models\Category;
use frontend\modules\search\components\SphinxActiveDataProvider;
use frontend\modules\search\components\RecentTorrentsActiveDataProvider;

/**
 * This is the model class for index "opbtorrents".
 *
 * @property integer $id
 * @property string $name
 * @property string $tags
 * @property string $hash
 * @property integer $category_id
 * @property string $created_at
 * @property integer $size
 * @property integer $downloads_count
 * @property integer $seeders
 * @property integer $leechers
 * @property integer $torrent_status
 * @property integer $visible_status
 * @property integer $files_count
 */
class Search extends \yii\sphinx\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function indexName()
    {
        return 'npbtorrents, npbtorrents_delta';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id'], 'required'],
            [['id'], 'unique'],
            [['id', 'category_id', 'size', 'downloads_count', 'seeders', 'leechers', 'torrent_status', 'visible_status', 'files_count'], 'integer'],
            [['name', 'tags', 'hash'], 'string'],
            [['created_at'], 'safe']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => Yii::t('torrent', 'ID'),
            'name' => Yii::t('torrent', 'Name'),
            'tags' => Yii::t('torrent', 'Tags'),
            'hash' => Yii::t('torrent', 'Hash'),
            'category_id' => Yii::t('torrent', 'Category ID'),
            'created_at' => Yii::t('torrent', 'Created At'),
            'size' => Yii::t('torrent', 'Size'),
            'downloads_count' => Yii::t('torrent', 'Downloads Count'),
            'seeders' => Yii::t('torrent', 'Seeders'),
            'leechers' => Yii::t('torrent', 'Leechers'),
            'torrent_status' => Yii::t('torrent', 'Torrent Status'),
            'visible_status' => Yii::t('torrent', 'Visible Status'),
            'files_count' => Yii::t('torrent', 'Files Count'),
        ];
    }

    public static function getRecentTorrentDataProvider() {
        $query = Torrent::find();

        $query->with('scrapes');
        $query->where(['visible_status' => [0,3]]);
        $query->addOrderBy(['id' => SORT_DESC]);
        $cmd = $query->createCommand();

        return new RecentTorrentsActiveDataProvider([
            'query' => $query,
            'db' => Yii::$app->db,
            'sort' => false,
            'pagination' => [
                'pageSize' => 35,
            ],
        ]);
    }

    /**
     *
     * @param \frontend\modules\search\models\SearchForm $model
     * @return \yii\data\ArrayDataProvider
     */
    public static function getTorrentDataProvider(SearchForm $model) {
        $query = new ActiveQuery('\frontend\modules\torrent\models\Torrent');

        $query->from(static::indexName());
        $query->with('scrapes');

        // Keywords
        $searchPattern = '';
        if (! empty($model->words)) {
            if (is_array($model->words)) {
                $wordQuery = $model->words;
                foreach ($wordQuery as $key => $word) {
                    $wordQuery[$key] = Yii::$app->sphinx->escapeMatchValue($word);
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
                $search = Yii::$app->sphinx->escapeMatchValue($model->words);
            }

            $searchPattern .= '@name ' . $search;
            $query->addOptions(['ranker' => new Expression('expr(\'' . 'sum((4*lcs+2*(min_hit_pos==1)+exact_hit)*user_weight)*1000+bm25 + '
                                      . '(created_at - 1000000000) / (NOW() - 1000000000) * 100 + if(torrent_status=1,100,0)\')')]);
        }

        // Tag
        if (! empty($model->tags)) {
            $searchPattern .= ' @tags "=' . $model->tags . '"';
        }
        // Sortable
        $isSortable = \Yii::$app->request->get('sort');
        if(empty($isSortable)) {
            $query->addOrderBy(['weight()' => SORT_DESC, 'id' => SORT_DESC]);
        }

        if (! empty($searchPattern)) {
            $query->match(new Expression(':match', [':match' => $searchPattern]));
        }

        // Filter torrents by age
        if (! empty($model->age)) {
            $query->where("created_at >= " . (time() - $model->age * 86400));
        }

        $query->andWhere(['deleted' => 0]);

        $query->addOptions(['max_matches' => 10000]);

        return new SphinxActiveDataProvider([
            'query' => $query,
            'sort' => ['attributes' => ['seeders','leechers']],
            'db' => Yii::$app->sphinx,
            'sort' => [
                'attributes' => [
                    'name' => [
                        'default' => SORT_DESC
                    ],
                    'created_at' => [
                        'default' => SORT_DESC
                    ],
                    'size' => [
                        'default' => SORT_DESC
                    ],
                    'seeders' => [
                        'default' => SORT_DESC
                    ],
                    'leechers' => [
                        'default' => SORT_DESC
                    ]
                ]
            ],
            'pagination' => [
                'pageSize' => 35,
            ],
        ]);
    }

    public static function getLastTorrentsDataProvider($count = 5, $forceRefresh = false) {
        $cacheKey = 'browse_torrents';
        $torrentsByTags = Yii::$app->cache->get($cacheKey);
        if (!$torrentsByTags) {
            $torrentsByTags = [];
            $torrentsIds = [];
            $tags = Category::$categoriesTags;

            foreach ($tags as $tag) {
                $query = new Query();
                $rows = $query->from(static::indexName())
                    ->match(new Expression(':match', [':match' => '@tags ' . Yii::$app->sphinx->escapeMatchValue($tag)]))
                    ->where(['deleted' => 0])
                    ->orderBy(['weight()' => SORT_DESC, 'id' => SORT_DESC])
                    ->limit($count)
                    ->addOptions(['ranker' => 'SPH04', 'max_matches' => 5]);
                $torrents = array_map(function($item) {return $item['id'];}, $rows->all());
                $torrentsIds = array_merge($torrentsIds, $torrents);
            }

            if (empty($torrentsIds)) {
                Yii::warning('Empty last torrents ids');
            } else {
                $query = (new Torrent())->find()->with('scrapes')
                        ->where(['id' => $torrentsIds]);

                foreach ($query->all() as $torrent) {
                    $torrentsByTags[Category::getTorrentCategoryTag($torrent)][] = $torrent;
                }
            }

            Yii::$app->cache->set($cacheKey, $torrentsByTags, 600);
        }

        $result = array_map(function($data) {return new ArrayDataProvider(['key' => 'id', 'allModels' => $data]);}, $torrentsByTags);

        return $result;
    }
}

<?php
// TODO: Mb remove cactiverecord???
class LCategory extends CActiveRecord
{

    const ANIME = 1;

    const SOFTWARE = 2;

    const GAMES = 3;

    const ADULT = 4;

    const MOVIES = 5;

    const MUSIC = 6;

    const OTHER = 7;

    const TV_SHOWS = 8;

    const BOOKS = 9;

    public static $categoriesTags = array(
        1 => 'Anime',
        2 => 'Software',
        3 => 'Games',
        4 => 'Adult',
        5 => 'Movies',
        6 => 'Music',
        7 => 'Other',
        8 => 'Series & TV',
        9 => 'Books'
    );

    public static function model($className = __CLASS__)
    {
        return parent::model($className);
    }

    public static function getCategoryIdByName($name) {
        foreach (self::$categoriesTags as $id => $category)  {
            if (strtolower($category) == strtolower($name)) {
                return $id;
            }
        }
        return false;
    }

    public static function getCategoryTag($id)
    {
        return isset(self::$categoriesTags[$id]) ? self::$categoriesTags[$id] : self::$categoriesTags[self::OTHER];
    }
}
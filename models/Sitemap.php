<?php
/**
 * Created by PhpStorm.
 * User: user
 * Date: 06.02.19
 * Time: 17:48
 */

namespace app\models;

use yii\base\Model;
use Yii;


class Sitemap extends Model
{
    public function getUrl(){

        $urls = array();

        //Посты
        $url_posts = Category::find()
            ->select('slug')
            ->all();
        //Формируем двумерный массив. createUrl преобразует ссылки в правильный вид.
        //Добавляем элемент массива 'daily' для указания периода обновления контента
        foreach ($url_posts as $url_post){
            $urls[] = array($url_post->slug,'daily');
        }

        $url_posts = Products::find()
            ->select('slug')
            ->all();
        //Формируем двумерный массив. createUrl преобразует ссылки в правильный вид.
        //Добавляем элемент массива 'daily' для указания периода обновления контента
        foreach ($url_posts as $url_post){
            $urls[] = array($url_post->slug,'daily');
        }


        $url_posts = Page::find()
            ->select('slug')
            ->all();
        //Формируем двумерный массив. createUrl преобразует ссылки в правильный вид.
        //Добавляем элемент массива 'daily' для указания периода обновления контента
        foreach ($url_posts as $url_post){
            $urls[] = array($url_post->slug,'daily');
        }


        //Рубрики

        return $urls;
    }

    //Формирует XML файл, возвращает в виде переменной
    public function getXml($urls){
        $host = Yii::$app->request->hostInfo; // домен сайта
        ob_start();

        echo '<?xml version="1.0" encoding="UTF-8"?>'; ?>
        <urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">

            <url>
                <loc><?= $host ?></loc>
                <changefreq>daily</changefreq>
                <priority>1</priority>
            </url>

            <?php foreach($urls as $url): ?>
                <url>
                    <loc><?= $host.$url[0] ?></loc>
                    <changefreq><?= $url[1] ?></changefreq>
                </url>
            <?php endforeach; ?>
        </urlset>

        <?php return ob_get_clean();
    }

    //Возвращает XML файл
    public function showXml($xml_sitemap){
        // устанавливаем формат отдачи контента
        //Yii::$app->response->format = \yii\web\Response::FORMAT_XML;
        //повторно т.к. может не сработать
        header("Content-type: text/xml");
        echo $xml_sitemap;
        die();
        Yii::$app->end();
    }
}
<?php
/**
 * Created by PhpStorm.
 * User: Vitaut
 * Date: 16.01.2018
 * Time: 16:27
 */

namespace common\models;

use Yii;
use GuzzleHttp\Client;
use yii\helpers\Url;
use common\models\Page;
use  common\models\PageI18n;
use yii\helpers\StringHelper;

class Parsernews extends \yii\db\ActiveRecord
{
    const LIMIT_NEWS = 10;


    public function getTutbyNews()
    {
        $client = new Client();
        $res = $client->request('GET', 'https://auto.tut.by/');
        $body = $res->getBody();
        $document = \phpQuery::newDocumentHTML($body);

        $news = $document->find("ul.b-lists")->slice(0, static::LIMIT_NEWS);

        foreach ($news as $link) {
            $pq = pq($link);
            $id = $pq->find('li.lists__li')->attr('data-id');
            if (((Page::find()->where(['id_foreign' => $id])->andWhere(['source' => 'TUTBY'])->one()) === null) && ($id !== null)) {
                $link = $pq->find('li.lists__li')->find('div.txt')->find('a')->attr('href');

                $body = file_get_contents($link);
                $document = \phpQuery::newDocumentHTML($body);
                $title = $document->find("div.m_header")->find('h1');
                $content = $document->find("div#article_body");
                $content->find('table.tbl')->remove();
                $content->find('style')->remove();
                $content->find('script')->remove();
                $mainImage = $document->find("div#article_body")->find('img')->slice(0, 1)->attr('src');

                if ($mainImage == null) {
                    $mainImage = null;
                }

                unset($body);

                $model = new Page();

                $model->type = Page::TYPE_NEWS;
                $model->id_foreign = $id;
                $model->source = 'TUTBY';
                $model->created_by = 23;
                $model->status = Page::STATUS_PUBLISHED;
                $model->alias = $id;
                $model->main_image = $mainImage;

                if ($model->save()) {
                    $parent_id = $model->id;
                    unset($model);

                    $model = new PageI18n();
                    $model->parent_id = $parent_id;
                    $model->language = Yii::$app->language;
                    $model->header = (string)$title;
                    $model->content = (string)$content . '<br> Информация взята с сайта <a href="' . $link . '">Tut.by</a>';
                    $model->description = StringHelper::truncate((string)$content, 500, '...');

                    if ($model->save()) {

                        return true;
                    } else {
                        var_dump($model->getErrors());

                        return false;
                    }
                } else {

                    return false;
                }

            }

        }


    }
}
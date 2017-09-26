<?php

namespace backend\controllers;

use common\models\Page;
use common\models\PageSearch;
use Yii;

/**
 * PagesController implements the CRUD actions for application pages (common\models\Page model).
 */
class NewsController extends PagesController
{
    /**
     * Lists all pages.
     * @return mixed
     */
    public function actionIndex()
    {
        if (!Yii::$app->user->can('viewPage')) {
            Yii::$app->user->denyAccess();
        }

        $searchModel = new PageSearch();
        $searchModel->type = PageSearch::TYPE_NEWS;
        $params = Yii::$app->request->get();
        $searchModel->loadI18n($params);
        $dataProvider = $searchModel->searchI18n();
        $dataProvider->sort->defaultOrder = [
           'id' => SORT_DESC,
        ];

        return $this->render('index', [
            'dataProvider' => $dataProvider,
            'searchModel' => $searchModel,
        ]);
    }

    /**
     * Creates a new page
     * If creation is successful, the browser will be redirected to the 'pages/index' page.
     * @return mixed
     */
    public function actionCreate()
    {
        if (!Yii::$app->user->can('createPage')) {
            Yii::$app->user->denyAccess();
        }

        $model = new Page();

        $data = Yii::$app->request->post();
        $data['Page']['type'] = Page::TYPE_NEWS;

        if ($model->loadI18n($data) && $model->validateI18n()) {
            $model->save();
            $this->saveUploads($model);
            $this->saveMetaData($model);
            return $this->redirect(['index']);
        } else {
            return $this->render('create', [
                'model' => $model
            ]);
        }
    }
}

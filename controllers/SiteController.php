<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;

use app\models\Links;
use app\models\History;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    /**
     * Generates shortlink part.
     *
     * @param number of symbols
     *
     * @return string
     */
    protected function getRandomLink($n) {
        $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
        $randomString = '';

        for ($i = 0; $i < $n; $i++) {
            $index = rand(0, strlen($characters) - 1);
            $randomString .= $characters[$index];
        }

        return $randomString;
    }


    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = new Links;

        if ($model->load(Yii::$app->request->post())) {

            if (empty($model->link))
                $model->link = $this->getRandomLink(10);

            $model->date_create = time();
            $model->creator_ip = ip2long(Yii::$app->request->userIP);

            if ($model->save())
                return $this->render('result', [
                    'model' => $model,
                ]);
        }

        return $this->render('index', [
            'model' => $model,
        ]);

    }

    /**
     * Redirects to the URL.
     *
     * @param short URL
     *
     * @return string
     */
    public function actionRedirect($link)
    {
        $item = Links::find()->where(['link' => $link ])->andWhere('date_delete IS NULL OR date_delete>'.time())->one();

        if(!$item)
            return $this->redirect('/');

        $history = new History();
        $history->id_link = $item->id_link;
        $history->date = time();
        $history->ip = ip2long(Yii::$app->request->userIP);
        $history->save();

        return Yii::$app->response->redirect($item->url);
    }

}

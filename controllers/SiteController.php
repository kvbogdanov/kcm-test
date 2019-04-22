<?php

namespace app\controllers;

use Yii;
use yii\web\Controller;
use yii\web\Response;
use yii\helpers\FileHelper;

use app\models\Links;
use app\models\History;

use yii\data\ActiveDataProvider;
use yii\data\SqlDataProvider;


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

        // if no matched links -> to main page
        if(!$item)
            return $this->redirect('/');

        // save redirect event info
        $history = new History();
        $history->id_link = $item->id_link;
        $history->date = time();
        $history->ip = ip2long(Yii::$app->request->userIP);
        $history->save();

        // if not comercial -> redirect immediately
        if(!$item->commercial)
            return Yii::$app->response->redirect($item->url);

        // otherwise -> show page with adv image (if exists) with delay
        $advPath = Yii::getAlias('@webroot').Yii::$app->params['advSrc'];

        // if no dir with images - go to url
        if(!file_exists($advPath))
            return Yii::$app->response->redirect($item->url);

        $images = FileHelper::findFiles(Yii::getAlias('@webroot').Yii::$app->params['advSrc'],['only'=>['*.jpeg','*.jpg','*.png','*.gif']]);

        // if no images in path - go to url
        if(!$images)
            return Yii::$app->response->redirect($item->url);

        shuffle($images);

        $meta = [
            'http-equiv' => 'Refresh',
            'content' => Yii::$app->params['advDelay'].'; url=' . $item->url,
        ];
        Yii::$app->view->registerMetaTag($meta);

        // save fact of showing
        $imgToShow = str_replace(Yii::getAlias('@webroot'),'',$images[0]);
        $history->image = $imgToShow;
        $history->update();

        $this->layout = 'empty';

        return $this->render('advert', [
            'imagePath' => $imgToShow
        ]);
    }

    /**
     * Shows redirect history for particular URL.
     *
     * @param short URL
     *
     * @return string
     */
    public function actionHistory($link)
    {
        $item = Links::find()->where(['link' => $link ])->one();

        if(!$item)
            return $this->redirect('/');

        $dataProvider = new ActiveDataProvider([
            'query' => $item->getRedirects(),
            'pagination' => [
                'pageSize' => 10,
            ]
        ]);

        return $this->render('history', [
            'dataProvider' => $dataProvider,
            'link' => $item
        ]);

    }

    /**
     * Shows stat.
     *
     * @return string
     *
     * @throws
     */
    public function actionStat()
    {
        $sql = "SELECT cl.url, cl.link, COUNT(cl.id_link) as cnt FROM cnt_history ch
                    LEFT JOIN cnt_links cl ON cl.id_link = ch.id_link
                    WHERE ch.date>DATE_SUB(curdate(), INTERVAL 2 WEEK)
                    GROUP BY ch.id_link
                    HAVING cnt>0
                    ";

        $count = Yii::$app->db->createCommand('SELECT COUNT(*) FROM ('.$sql.') t1')->queryScalar();

        $dataProvider = new SqlDataProvider([
            'sql' => $sql,
            'totalCount' => $count,
            'sort' => [
                'attributes' => [
                    'cnt',
                ],
            ],
            'pagination' => [
                'pageSize' => 20,
            ],
        ]);

        return $this->render('stat', [
            'dataProvider' => $dataProvider,
        ]);

    }


}

<?php

namespace app\controllers;

use app\models\Category;
use app\models\ForgotForm;
use app\models\News;
use app\models\Page;
use app\models\Products;
use app\models\Sitemap;
use app\models\User;
use dektrium\user\traits\AjaxValidationTrait;
use dektrium\user\traits\EventTrait;
use Yii;
use yii\filters\AccessControl;
use yii\filters\PageCache;
use yii\helpers\Json;
use yii\web\Controller;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;
use yii\web\NotFoundHttpException;
use yii\widgets\ActiveForm;

class SiteController extends Controller
{

    use AjaxValidationTrait;
    use EventTrait;

    const EVENT_BEFORE_LOGIN = 'beforeLogin';

    /**
     * Event is triggered after logging user in.
     * Triggered with \dektrium\user\events\FormEvent.
     */
    const EVENT_AFTER_LOGIN = 'afterLogin';

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
//            'cache' => [
//                'class' => PageCache::className(),
//                'only' => ['index'],
//                'duration' => 60*60*24*30
//            ]
        ];
    }

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
//                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionError(){
    	return $this->redirect(['/']);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {

        $model = \Yii::createObject(\dektrium\user\models\LoginForm::className());
        $event = $this->getFormEvent($model);

        $this->performAjaxValidation($model);

        $this->trigger(self::EVENT_BEFORE_LOGIN, $event);

        if ($model->load(\Yii::$app->getRequest()->post()) && $model->login()) {
            $this->trigger(self::EVENT_AFTER_LOGIN, $event);
            if(!Yii::$app->user->identity->getIsActive()){
                Yii::$app->session->setFlash('login', Yii::$app->settings->get('Settings.notify_unactive'));
            }
            return $this->goBack();
        }

        $categories = Category::find()->where('parent_id IS NULL')->orderBy(['position' => SORT_ASC])->limit(16)->all();
        $news = News::find()->orderBy(['created_at' => SORT_DESC])->limit(4)->all();
        return $this->render('index', ['categories' => $categories, 'news' => $news]);
    }

    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
    	return $this->redirect('/#login');
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact()) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    public function actionSlug($slug = ''){
        $page = Page::find()->where(['slug' => '/' . $slug])->one();
        if(!$page){
            throw new NotFoundHttpException('Страница не найдена');
        }
        return Yii::$app->runAction($page->route);
    }

    public function actionForgot(){
	    $model = new ForgotForm();
	    $model->scenario = 'step1';
	    return $this->renderAjax('forgot', ['model' => $model]);
    }

	public function actionForgotvalidation(){
		$model = new ForgotForm();
		$model->scenario = 'step1';
		$model->load(\Yii::$app->request->post());
		$errors = ActiveForm::validate($model);
		if(!empty($errors)) {
			return Json::encode( $errors );
		}

		$phone = str_replace('-', '', $model->phone);
		$phone = str_replace('(', '', $phone);
		$phone = str_replace(')', '', $phone);
		$phone = str_replace(' ', '', $phone);

		$user = User::findOne(['username' => $phone]);
		$user->mailer->mailerComponent = null;

		$user->resetPass();

		return Json::encode([
			'success' => 1,
			'popup' => $this->renderPartial('ok')
		]);

	}

	public function actionSitemap(){
        $sitemap = new Sitemap();
        //Если в кэше нет карты сайта
        if (!$xml_sitemap = \Yii::$app->cache->get('sitemap')) {
            //Получаем мыссив всех ссылок
            $urls = $sitemap->getUrl();
            //Формируем XML файл
            $xml_sitemap = $sitemap->getXml($urls);
            // кэшируем результат
            \Yii::$app->cache->set('sitemap', $xml_sitemap, 3600*6);
        }
        //Выводим карту сайта
        $sitemap->showXml($xml_sitemap);
    }

    public function actionClear(){
        Products::delete('is_deleted=1 and deleted_date<' . (time() - 60*60*24*30*6));
        //Products::deleteAll('is_deleted=1 and deleted_date<' . (time() - 60));
    }

}

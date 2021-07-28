<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 02.05.17
 * Time: 17:34
 */

namespace app\modules\admin\controllers;


use app\models\BlockForm;
use app\models\User;
use dektrium\user\Finder;
use dektrium\user\controllers\AdminController;
use yii\helpers\Url;
use app\models\UserSearch;
use dektrium\user\filters\AccessRule;
use yii\filters\AccessControl;

class UserController extends AdminController
{

    public function __construct($id, $module, Finder $finder, $config = [])
    {
        defined('MODULE_ID') or define('MODULE_ID', 'tkbpfdtnf');
        parent::__construct($id, $module, $finder, $config);
    }

    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::class,
                'ruleConfig' => [
                    'class' => AccessRule::class,
                ],
                'rules' => [
                    [
                        'allow' => true,
                        'matchCallback' => function ($rule, $action) {
                            if (\Yii::$app->user->isGuest) {
                                return false;
                            }
                            return \Yii::$app->user->identity->role == 'admin';
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index', 'update'],
                        'matchCallback' => function ($rule, $action) {
                            if (\Yii::$app->user->isGuest) {
                                return false;
                            }
                            return \Yii::$app->user->identity->role == 'manager';
                        }
                    ],
                    [
                        'allow' => true,
                        'actions' => ['index'],
                        'matchCallback' => function ($rule, $action) {
                            if (\Yii::$app->user->isGuest) {
                                return false;
                            }
                            return \Yii::$app->user->identity->role == 'contentmanager';
                        }
                    ],
                ],
            ],
        ];
    }

    const EVENT_BEFORE_ACTIVATE = 'beforeActivate';
    const EVENT_AFTER_ACTIVATE = 'afterActivate';
    const EVENT_BEFORE_IGNORE = 'beforeIgnore';
    const EVENT_AFTER_IGNORE = 'afterIgnore';
    const EVENT_BEFORE_UNIGNORE = 'beforeUnIgnore';
    const EVENT_AFTER_UNIGNORE = 'afterUnIgnore';


    public function actionIndex()
    {
        Url::remember('', 'actions-redirect');
        $searchModel  = \Yii::createObject(UserSearch::class);
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        $block_form = new BlockForm();

        return $this->render('//user/admin/index', [
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
            'blockForm' => $block_form
        ]);
    }


    public function actionActivate($id)
    {
        $user = $this->findModel($id);
        $event = $this->getUserEvent($user);
        $this->trigger(self::EVENT_BEFORE_ACTIVATE, $event);
        $user->activate();
        $this->trigger(self::EVENT_AFTER_ACTIVATE, $event);
        return $this->redirect(['/user/' . MODULE_ID]);
    }

    /**
     * Blocks the user.
     *
     * @param int $id
     *
     * @return Response
     */
    public function actionBlock($id)
    {
        if ($id == \Yii::$app->user->getId()) {
            \Yii::$app->getSession()->setFlash('danger', \Yii::t('user', 'You can not block your own account'));
        } else {
            $user  = $this->findModel($id);
            $event = $this->getUserEvent($user);
            if ($user->getIsBlocked()) {
                $this->trigger(self::EVENT_BEFORE_UNBLOCK, $event);
                $user->unblock();
                $this->trigger(self::EVENT_AFTER_UNBLOCK, $event);
                \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been unblocked'));
            } else {
                $blockForm = new BlockForm();
                if ($blockForm->load(\Yii::$app->request->post()) && $blockForm->validate()) {
                    $this->trigger(self::EVENT_BEFORE_BLOCK, $event);
                    $blockForm->block($user);
                    $this->trigger(self::EVENT_AFTER_BLOCK, $event);
                    \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been blocked'));
                }
            }
        }

        return $this->redirect(Url::previous('actions-redirect'));
    }


    /**
     * Blocks the user.
     *
     * @param int $id
     *
     * @return Response
     */
    public function actionIgnore($id)
    {
        if ($id == \Yii::$app->user->getId()) {
            \Yii::$app->getSession()->setFlash('danger', 'Вы не можете игнорирувать свой аккаунт');
        } else {
            $user  = $this->findModel($id);
            $event = $this->getUserEvent($user);
            if ($user->getIsIgnored()) {
                $this->trigger(self::EVENT_BEFORE_UNIGNORE, $event);
                $user->unignore();
                $this->trigger(self::EVENT_AFTER_UNIGNORE, $event);
                \Yii::$app->getSession()->setFlash('success', 'Пользователь больше не игнорируется');
            } else {
                $this->trigger(self::EVENT_BEFORE_IGNORE, $event);
                $user->ignore();
                $this->trigger(self::EVENT_AFTER_IGNORE, $event);
                \Yii::$app->getSession()->setFlash('success', 'Пользователь добавлен в игнор');
            }
        }

        return $this->redirect(Url::previous('actions-redirect'));
    }


    public function actionDeletemultiply()
    {
        $ids = \Yii::$app->request->post('selection');
        $sendemail = \Yii::$app->request->post('sendemail');
        $users = User::findAll(['id' => $ids]);
        foreach ($users as $user) {
            if (!$user->not_delete) {

                $event = $this->getUserEvent($user);
                $this->trigger(self::EVENT_BEFORE_DELETE, $event);
                if ($sendemail) {
                    $user->sendEmail('delete');
                }
                $user->delete();
                $this->trigger(self::EVENT_AFTER_DELETE, $event);
            }
        }
        return $this->redirect(Url::previous('actions-redirect'));
    }


    public function actionDelete($id)
    {
        if ($id == \Yii::$app->user->getId()) {
            \Yii::$app->getSession()->setFlash('danger', \Yii::t('user', 'You can not remove your own account'));
        } else {
            $model = $this->findModel($id);
            $event = $this->getUserEvent($model);
            $this->trigger(self::EVENT_BEFORE_DELETE, $event);
            $sendemail = \Yii::$app->request->post('send');
            if (!$model->not_delete) {

                $event = $this->getUserEvent($model);
                $this->trigger(self::EVENT_BEFORE_DELETE, $event);
                if ($sendemail) {
                    $model->sendEmail('delete');
                }
                $model->delete();
                $this->trigger(self::EVENT_AFTER_DELETE, $event);
            }
            $this->trigger(self::EVENT_AFTER_DELETE, $event);
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'User has been deleted'));
        }

        return $this->redirect(['index']);
    }

    public function actionUpdate($id)
    {
        $searchModel  = \Yii::createObject(UserSearch::class);
        $dataProvider = $searchModel->search(\Yii::$app->request->get());

        Url::remember('', 'actions-redirect');
        $user = $this->findModel($id);
        $user->scenario = 'update';
        $event = $this->getUserEvent($user);

        $this->performAjaxValidation($user);

        $this->trigger(self::EVENT_BEFORE_UPDATE, $event);
        if (
            $user->load(\Yii::$app->request->post())
            && $user->profile->load(\Yii::$app->request->post())
            && $user->save()
            && $user->profile->save()
        ) {
            \Yii::$app->getSession()->setFlash('success', \Yii::t('user', 'Account details have been updated'));
            $this->trigger(self::EVENT_AFTER_UPDATE, $event);
            return $this->refresh();
        }

        return $this->render('@app/views/user/admin/update', [
            'user' => $user,
            'dataProvider' => $dataProvider,
            'searchModel'  => $searchModel,
        ]);
    }
}

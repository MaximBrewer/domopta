<?php

namespace app\models;

use app\components\Mailer;
use app\helpers\Password;
use yii\db\Exception;
use yii\bootstrap\Html;

/**
 * @property Favorite $favorite
 */
class User extends \dektrium\user\models\User
{

    public $password;
    public $password_repeat;

    public $docs;

    protected function getMailer()
    {
        return \Yii::$container->get(Mailer::className());
    }


    public function getIsAdmin()
    {
        return in_array($this->role, ['admin', 'moderator', 'manager', 'contentmanager']);
    }

    public function scenarios()
    {
        $scenarios = parent::scenarios();
        // add field to scenarios
        $scenarios['create'][]   = 'is_active';
        $scenarios['update'][]   = 'is_active';
        $scenarios['register'][] = 'is_active';
        $scenarios['cabinet'] = ['email'];
        $scenarios['password'] = ['password', 'password_repeat'];
        return $scenarios;
    }

    public function rules()
    {
        $rules = parent::rules();
        $rules['activate'] = ['is_active', 'integer'];
        $rules['phone_code'] = ['phone_code', 'safe'];
        $rules[] = ['role', 'default', 'value' => 'user'];
        $rules[] = ['not_delete', 'integer'];
        $rules[] = ['password', 'string', 'min' => 6, 'message' => "Пароль должен состоять минимум их 6-ти знаков."];
        $rules[] = ['flags', 'safe'];
        $rules[] = ['email', 'email', 'skipOnEmpty' => true];
        $rules[] = ['password_repeat', 'compare', 'compareAttribute' => 'password', 'message' => "Пароль и подтверждение пароля не совпадают."];
        $rules[] = ['password_repeat', 'required', 'when' => function ($model) {
            return $model->password;
        }, 'message' => "Поле необходимо заполнить."];
        $rules[] = ['docs', 'file', 'maxFiles' => 5, 'extensions' => ['jpg', 'pdf', 'doc', 'docx']];
        unset($rules['usernameMatch']);
        unset($rules['emailRequired']);
        return $rules;
    }


    public function attributeLabels()
    {
        $attribute_lables = parent::attributeLabels();
        $attribute_lables['created_at'] = 'Дата';
        $attribute_lables['not_delete'] = 'Защита от удаления';
        $attribute_lables['role'] = 'Роль';
        $attribute_lables['organization'] = 'Название ООО';
        $attribute_lables['phone'] = 'Телефон';
        $attribute_lables['inn'] = 'ИНН';
        $attribute_lables['is_active'] = 'Активированный пользователь';
        return $attribute_lables;
    }


    public function activate()
    {
        $this->is_active = 1;
        $this->save(false);
        $this->mailer->sendActivate($this);
    }

    public function block()
    {
        parent::block();
        try {
            $this->mailer->sendBlock($this);
        } catch (\Exception $e) {
        }
    }

    public function unblock()
    {
        parent::unblock();
        $this->mailer->sendUnblock($this);
    }

    public function delete()
    {
        parent::delete();
        //$this->mailer->sendDelete($this);
    }

    public function ignore()
    {
        $this->is_ignored = 1;
        $this->save();
    }

    public function unignore()
    {
        $this->is_ignored = 0;
        $this->save();
    }

    public function getIsIgnored()
    {
        return $this->is_ignored;
    }

    public function getStatus()
    {
        if (!$this->confirmed_at) {
            return 'Не активный';
        }
        if ($this->getIsBlocked()) {
            return 'Блок';
        }
        if ($this->getIsIgnored()) {
            return 'Игнор';
        }
        if ($this->is_active) {
            return 'актив';
        }
    }

    public function getIsActive()
    {
        return $this->is_active == 1 && $this->getIsIgnored() != 1 && $this->getIsBlocked() != 1;
    }

    public function sendEmail($letter, $params = [])
    {
        if ($letter == 'delete') {
            try {
                $this->mailer->sendDelete($this);
            } catch (\Swift_TransportException $e) {
            }
        }
        if ($letter == 'confirm') {
            try {
                $this->mailer->sendConfirmationMessage($this, 'https://domopta.ru/confirm?key=' . $this->auth_key);
            } catch (\Swift_TransportException $e) {
            }
        }
    }

    public function getOrders()
    {
        return $this->hasMany(Order::className(), ['user_id' => 'id']);
    }



    public function afterDelete()
    {
        parent::afterDelete();
        foreach ($this->orders as $order) {
            $order->delete();
        }

        $carts = Cart::findAll(['user_id' => $this->id]);
        foreach ($carts as $cart) {
            $cart->delete();
        }
    }

    public static function countActivated()
    {
        return self::find()->where(['is_active' => 1, 'is_ignored' => null, 'blocked_at' => null])->count();
    }

    public static function countBlocked()
    {
        return self::find()->where('blocked_at IS NOT NULL')->count();
    }

    public static function countIgnored()
    {
        return self::find()->where(['is_ignored' => 1, 'blocked_at' => null])->count();
    }

    public function createMob()
    {
        if ($this->getIsNewRecord() == false) {
            throw new \RuntimeException('Calling "' . __CLASS__ . '::' . __METHOD__ . '" on existing user');
        }

        $transaction = $this->getDb()->beginTransaction();

        try {

            $this->password = $this->password == null && $this->module->enableGeneratingPassword ? Password::generate(8) : $this->password;
            $this->password_repeat = $this->password;

            $this->trigger(self::BEFORE_CREATE);

            if (!$this->validate()) {
                $transaction->rollBack();
                return false;
            }
            $this->save();
            // $pass = Password::generate(8);

            // if($this->password == null && $this->module->enableGeneratingPassword){
            //     $this->password = $pass;
            //     $this->password_repeat = $pass;
            // }


            // $this->password = ($this->password == null && $this->module->enableGeneratingPassword) ? Password::generate(8) : $this->password;
            // var_dump($this->password);die;

            $this->trigger(self::AFTER_CREATE);

            $transaction->commit();

            $number = str_replace('+', '', $this->username);

            \Yii::$app->sms->send_sms($number, "Ваш код для подтверждения регистрации на сайте:\n"  . $this->phone_code . "\ndomopta.ru");

            return true;
        } catch (\Exception $e) {
            $transaction->rollBack();
            \Yii::warning($e->getMessage());
            throw $e;
        }
    }

    public function resetPass()
    {
        $this->trigger(self::BEFORE_CONFIRM);
        $this->password = Password::generate(8);
        $this->password_repeat = $this->password;
        $this->confirmed_at = time();
        $result = (bool) $this->save();
        // if ($result) {
        //     $number = str_replace('+', '', $this->username);
        //     \Yii::$app->sms->send_sms($number, "Новый пароль для входа:\n" . $this->password . "\ndomopta.ru");
        // }
        $this->trigger(self::AFTER_CONFIRM);
        return $result;
    }

    public function confirm()
    {
        $this->trigger(self::BEFORE_CONFIRM);
        $this->password = Password::generate(8);
        $this->password_repeat = $this->password;
        $this->confirmed_at = time();
        $result = (bool) $this->save();
        if ($result) {
            $number = str_replace('+', '', $this->username);
            \Yii::$app->sms->send_sms($number, "Ваш пароль для входа на сайт:\n" . $this->password . "\ndomopta.ru");
        }
        //$result = (bool) $this->updateAttributes(['confirmed_at' => time()]);
        $this->trigger(self::AFTER_CONFIRM);
        return $result;
    }

    public function getFavoritesAmount()
    {
        $cnt = 0;
        foreach ($this->favorite as $favorite) {
            // var_dump($favorite->product);
            if ($favorite->product && !$favorite->product->is_deleted) ++$cnt;
        }

        return $cnt;
    }

    public function getFiles()
    {
        return $this->hasMany(UserFile::class, ['user_id' => 'id']);
    }

    public function getFavorite()
    {
        return $this->hasMany(Favorite::className(), ['user_id' => 'id']);
    }

    public function beforeSave($insert)
    {
        parent::beforeSave($insert);
        if (!$insert) {
            $this->username = $this->getOldAttribute('username');
            if ($this->getOldAttribute('confirmed_at') && $this->getOldAttribute('password_hash') && $this->getOldAttribute('password_hash') != $this->password_hash) {
                $number = str_replace('+', '', $this->username);
                \YII::$app->session->setFlash('password_changed');
                \YII::$app->session->setFlash('no_success');
                \Yii::$app->sms->send_sms($number, "Пароль успешно изменен.\nНовый пароль для входа:\n" . $this->password . "\ndomopta.ru");
                Session::deleteAll(['user_id' => $this->id]);
                $this->auth_key = \Yii::$app->security->generateRandomString();
            }
        }
        return true;
    }

    public function getCartSum()
    {
        $carts = Cart::findAll(['user_id' => $this->id]);
        $sum = 0;
        foreach ($carts as $cart) {
            $sum += $cart->getSum();
        }
        return $sum;
    }

    public function getLastCartAdd()
    {
        $cart = Cart::find()->where(['user_id' => $this->id])->orderBy(['created_at' => SORT_DESC])->one();
        return \Yii::$app->formatter->asDate($cart->created_at, 'php:d.m.Y H:i');
    }

    public function getImports()
    {
        $s = date("Y-m-d H:i:s", strtotime("-1 months"));
        $f = date("Y-m-d H:i:s");
        $sum = Import::find()->where('user_id = ' . $this->id . ' AND datetime BETWEEN \''.$s.'\' AND \''.$f.'\'')->count();
        return $sum;
    }

    public function getLastImport()
    {
        $sum = Import::find()->where(['user_id' => $this->id])->orderBy(['created_at' => SORT_DESC])->one();
        return $sum->datetime;
    }



    public function renderBigCart()
    {
        $carts = Cart::find()
            ->innerJoinWith('details')
            ->where(['user_id' => $this->id])
            ->andFilterWhere(['>', '{{%cart_details}}.amount', 0])
            ->orderBy(['article' => SORT_ASC])->all();

        $retur = '';
        $sum = 0;
        $amm = 0;

        foreach ($carts as $cart) {
            foreach ($cart->details as $detail) {
                $row_amount = $detail->amount;
                if ($cart->product->pack_quantity > 0)
                    $row_amount = $detail->amount * $cart->product->pack_quantity;

                $retur .= "<tr>";
                $retur .= "<td class=\"text-center\">";
                if (isset($cart->product->pictures[0])) $retur .= Html::img($cart->product->pictures[0]->getUrl('thumb'));
                $retur .= "</td>";
                $retur .= "<td class=\"text-center\">";
                $retur .= $cart->product->article;
                $retur .= "</td>";
                $retur .= "<td class=\"text-center\">";
                $retur .= $cart->product->name;
                $retur .= "</td>";
                $retur .= "<td class=\"text-center\">";
                $retur .= $detail->color == 'default' ? '' : $detail->color;
                $retur .= "</td>";
                $retur .= "<td class=\"text-center\">";
                $retur .= $row_amount;
                $retur .= "</td>";
                $retur .= "<td class=\"text-center text-nowrap\">";
                $retur .= Products::formatPrice($cart->product->price);
                $retur .= "</td>";
                $retur .= "<td class=\"text-center text-nowrap\">";
                $retur .= Products::formatPrice($detail->getSum());
                $retur .= "</td>";
                $retur .= "<td class=\"text-center\">";
                $sold = false;
                if (($detail->color != 'default' || !$cart->product->flag) && !$cart->product->hasColor($detail->color)) {
                    $sold = true;
                }
                $retur .= !$sold ? 'В&nbsp;наличии' : '<span style="color:red;">Продан</span>';
                $retur .= "</td>";
                $retur .= "<td class=\"text-center\">";
                $retur .= str_replace(" ", "&nbsp;", date("d.m.y  (H:i)", $cart->created_at));
                $retur .= "</td>";
                $retur .= "</tr>";
                $sum += $detail->getSum();
                $amm += $row_amount;
            }
        }

        $return = "<table class=\"table table-striped table-bordered table-bigcart\">";
        $return .= "<thead>";
        $return .= "<tr>";
        $return .= "<th class=\"text-center\"></th>";
        $return .= "<th class=\"text-center\">Артикул</th>";
        $return .= "<th class=\"text-center\">Название</th>";
        $return .= "<th class=\"text-center\">Цвет</th>";
        $return .= "<th class=\"text-center\">Кол-во</th>";
        $return .= "<th class=\"text-center\">Цена за ед.</th>";
        $return .= "<th class=\"text-center\">Сумма</th>";
        $return .= "<th class=\"text-center\">Cтатус</th>";
        $return .= "<th class=\"text-center\">Дата</th>";
        $return .= "</tr>";
        $return .= "<tr>";
        $return .= "<td colspan=\"4\"><strong>Итого:</strong></td>";
        $return .= "<td class=\"text-right text-center\"><strong>" . $amm . "</strong></td>";
        $return .= "<td class=\"text-right text-nowrap\"><strong></strong></td>";
        $return .= "<td class=\"text-right text-nowrap\"><strong>" . Products::formatPrice($sum) . "</strong></td>";
        $return .= "<td class=\"text-right text-nowrap\"><strong></strong></td>";
        $return .= "<td class=\"text-right text-nowrap\"><strong></strong></td>";
        $return .= "</tr>";
        $return .= "</thead>";
        $return .= "<tbody>";


        $return .= $retur;

        $return .= "</tbody>";
        $return .= "<tfoot>";
        $return .= "<td colspan=\"4\"><strong>Итого:</strong></td>";
        $return .= "<td class=\"text-right text-center\"><strong>" . $amm . "</strong></td>";
        $return .= "<td class=\"text-right text-nowrap\"><strong></strong></td>";
        $return .= "<td class=\"text-right text-nowrap\"><strong>" . Products::formatPrice($sum) . "</strong></td>";
        $return .= "<td class=\"text-right text-nowrap\"><strong></strong></td>";
        $return .= "<td class=\"text-right text-nowrap\"><strong></strong></td>";
        $return .= "</tfoot>";
        $return .= "</table>";
        return $return;
    }
}

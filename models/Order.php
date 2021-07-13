<?php

namespace app\models;

use app\components\Mailer;
use app\modules\adminka\Module;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * This is the model class for table "order".
 *
 * @property integer $id
 * @property integer $user_id
 * @property integer $created_at
 * @property OrderDetails[] $detiles
 * @property User $user
 * @property Mailer $mailer
 */
class Order extends \yii\db\ActiveRecord
{
    public $page_size = 50;

    const SCENARIO_PICKUP = 'pickup';
    const SCENARIO_DELIVERY = 'delivery';
    const SCENARIO_SENDING = 'sending';

    public static $methods = [
        'delivery' => 'Доставка по Крыму',
        'sending' => 'Отправка ТК',
        'pickup' => 'Самовывоз',
    ];

    public static $tcs = [
        'kit' => 'GTD (КИТ)',
        'pek' => 'ПЭК',
        'zde' => 'ЖелДорЭкспедиция',
        'magic' => 'Мейджик Транс',
        'other' => 'Иная ТК',
    ];


    public function scenarios()
    {
        $scenarios = parent::scenarios();
        $scenarios[self::SCENARIO_PICKUP] = ['delivery_method', 'user_id', 'created_at'];
        $scenarios[self::SCENARIO_DELIVERY] = ['delivery_method', 'user_id', 'created_at', 'fio', 'locality', 'phone'];
        $scenarios[self::SCENARIO_SENDING] = ['delivery_method', 'user_id', 'fio', 'tc', 'passport_series', 'passport_id', 'city', 'region', 'phone', 'tc_name'];
        return $scenarios;
    }
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'order';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        $rules[] = ['num', 'required'];
        $rules[] = ['delivery_method', 'required', 'message' => 'Необходимо заполнить'];
        $rules[] = ['user_id', 'required', 'message' => 'Необходимо заполнить'];
        $rules[] = ['created_at', 'required', 'message' => 'Необходимо заполнить'];
        $rules[] = ['fio', 'required', 'message' => 'Необходимо заполнить'];
        $rules[] = ['passport_series', 'required', 'message' => 'Необходимо заполнить'];
        $rules[] = ['passport_id', 'required', 'message' => 'Необходимо заполнить'];
        $rules[] = ['city', 'required', 'message' => 'Необходимо заполнить'];
        $rules[] = ['region', 'required', 'message' => 'Необходимо заполнить'];
        $rules[] = ['phone', 'required', 'message' => 'Необходимо заполнить'];
        $rules[] = ['phone', 'match', 'pattern' => '~^\+7 \([0-9]{3}\) [0-9]{3}-[0-9]{2}-[0-9]{2}$~', 'message' => 'Некорректный номер'];
        $rules[] = ['locality', 'required', 'message' => 'Необходимо заполнить'];
        $rules[] = ['tc', 'required', 'message' => 'Необходимо выбрать транспортную компанию'];
        $rules[] = ['tc_name', 'required', 'when' => function ($model) {
            return $model->tc == 'other';
        }, 'message' => 'Необходимо заполнить'];
        return $rules;
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'Номер заказа',
            'user_id' => 'User ID',
            'delivery_method' => 'Спопсоб доставки',
            'fio' => 'Фамилия Имя Отчество',
            'locality' => 'Укажите населенный пункт',
            'phone' => 'Телефон',
            'tc' => 'Транспортная компания',
            'passport_series' => 'Серия паспорта',
            'passport_id' => 'Номер паспорта',
            'city' => 'Город',
            'region' => 'Область',
            'created_at' => 'Дата добавления',
            'sum' => 'Сумма',
            'ooo' => 'ООО',
        ];
    }

    protected function getMailer()
    {
        return \Yii::$container->get(Mailer::className());
    }

    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    public function getDetiles()
    {
        return $this->hasMany(OrderDetails::className(), ['order_id' => 'id'])->orderBy(['article' => SORT_ASC]);
    }

    public function getSum()
    {
        return $this->getDetiles()->where(['order_details.flag' => 1])->sum('sum');
    }

    public function getOldSum()
    {
        return $this->getDetiles()->sum('sum_old');
    }

    public function getAmount()
    {
        $amount = 0;
        foreach ($this->detiles as $item) {
            $amount += $item->amount;
        }
        return $amount;
    }

    public static function create($order, $cart)
    {
        if ($cart) {
            $user = User::findOne(Yii::$app->user->id);
            $order->user_id = $user->id;
            $order->created_at = time();
            $mxOrder = Order::find()->where(['>', 'created_at', mktime(0, 0, 0, 1, 1, date("Y"))])->max('num');
            $order->num = (int) $mxOrder + 1;

            $type = $user->profile->type;
            
            if ($order->validate() && $order->save()) {
                foreach ($cart as $item) {
                    $product = $item->product;
                    foreach ($item->details as $detail) {
                        if ($detail->amount > 0) {
                            $order_details = new OrderDetails();
                            $order_details->order_id = $order->id;
                            $order_details->article = $item->article;
                            $order_details->name = $product->name;
                            $order_details->color = $detail->color;
                            $order_details->memo = $item->memo;
                            $order_details->amount = $detail->amount;
                            if ($type == 1) {
                                $order_details->price = $product->price;
                            } elseif ($type == 2) {
                                $order_details->price = $product->price2;
                            } else {
                                $order_details->price = $product->price;
                            }
                            $quantity = $product->pack_quantity ? $product->pack_quantity : 1;
                            $order_details->sum = $order_details->price * $quantity * $detail->amount;
                            $order_details->flag = 1;
                            $order_details->save();
                        }
                    }
                    $item->delete();
                }
                $controller = new Controller('new', Module::className());
                $body = $controller->renderPartial('@app/modules/adminka/views/orders/email/admin', ['order' => $order, 'status' => 'new']);
                $model = new Self;
                $model->mailer->sendEmail(Yii::$app->settings->get('Settings.adminEmail'), 'Уведомление о новом заказе', $body);
                $model->mailer->sendEmail(Yii::$app->settings->get('Settings.sellEmail'), 'Уведомление о новом заказе', $body);
                // $model->mailer->sendEmail('pimax1978@icloud.com', 'Новый заказ', $body);

                if ($user->unconfirmed_email == 1) {
                    $body = $controller->renderPartial('@app/modules/adminka/views/orders/email/customer', ['order' => $order, 'status' => 'new']); // @todo сделать письмо
                    $model->mailer->sendEmail($user->email, 'Ваш Заказ успешно оформлен и отправлен в Отдел Заказов', $body);
                    // $model->mailer->sendEmail('pimax1978@icloud.com', 'Ваш Заказ успешно оформлен и отправлен в Отдел Заказов', $body);
                }

                return true;
            } else {
                return $order->errors;
            }
        }
        return false;
    }

    public function afterDelete()
    {
        $models = $this->detiles;
        foreach ($models as $model) {
            $model->delete();
        }
    }

    public function recount()
    {
        foreach ($this->detiles as $detail) {
            $product = Products::findOne(['article_index' => $detail->article]);
            $detail->flag_old = $detail->flag;
            $detail->flag = $product->flag;
            $detail->price_old = $detail->price;
            $detail->price = $product->price;
            $detail->sum_old = $detail->sum;
            $quantity = $product->pack_quantity ? $product->pack_quantity : 1;
            $detail->sum = $product->price * $quantity * $detail->amount;
            $detail->save();
        }

    }

    public function recountcancel()
    {
        foreach ($this->detiles as $detail) {
            if ($detail->price_old !== null) {
                $detail->flag = $detail->flag_old;
                $detail->flag_old = null;
                $detail->price = $detail->price_old;
                $detail->price_old = null;
                $detail->sum = $detail->sum_old;
                $detail->sum_old = null;
                $detail->save();
            }
        }
    }
}

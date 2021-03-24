<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 13.05.17
 * Time: 13:04
 */

namespace app\controllers;

use app\models\Cart;
use app\models\ProductForm;
use app\models\Products;
use app\models\ProductViews;
use DeepCopyTest\Matcher\Y;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

class ProductController extends Controller
{

    public function actionIndex($id){
        $model = $this->getProduct($id);
        if($model->is_deleted == 1){
            if(isset($model->category->slug)) {
                return $this->redirect($model->category->slug, 301);
            } else {
                return $this->redirect('/', 301);
            }
        }
        $form_model = new ProductForm();
        ProductViews::view($id);
        if(\Yii::$app->request->isAjax){
	        return $this->renderPartial( 'ajax', [ 'model' => $model, 'form_model' => $form_model ] );
        } else {
	        return $this->render( 'index', [ 'model' => $model, 'form_model' => $form_model ] );
        }
    }

    public function actionAdd(){
    	if(\Yii::$app->user->identity->profile->name != '') {
		    $form_model = new ProductForm();
		    if ( $form_model->load( \Yii::$app->request->post() ) && $form_model->validate() ) {
			    $form_model->addToCart();
		    }

		    return json_encode( Cart::getAmount() + [ 'popup' => $this->renderPartial( 'add' ) ] );
	    } else {
		    return json_encode( Cart::getAmount() + [ 'popup' => $this->renderPartial( 'reg' ) ] );
	    }
    }

    public function getProduct($id){
        $product = Products::findOne($id);
        if(!$product){
            throw new NotFoundHttpException('Страница не найдена');
        }
        return $product;
    }

}
<?php

/**
 * Created by PhpStorm.
 * User: resh
 * Date: 25.01.19
 * Time: 17:07
 */

namespace app\modules\adminka\controllers;


use app\models\Products;
use app\helpers\Inflector;
use app\models\ProductsImages;
use yii\httpclient\Client;
use yii\web\Controller;
use yii\web\UploadedFile;

class TestController extends Controller
{

    public function actionIndex()
    {
        $curl = new Client();
        $response = $curl->createRequest()
            ->setHeaders([
                'Content-Type: application/json',
                'Accept: application/json',
                'Authorization: Token d1f1cc1d2f8b283837831c90c7f5d8e1b33776da'
            ])
            ->setData(['query' => '2315995226111'])
            ->setUrl('https://suggestions.dadata.ru/suggestions/api/4_1/rs/findById/party')
            ->send();
        //		$data = $response->data;
        //		if(!isset($data['suggestions'])){
        //
        //		}
        print_r($response->data);
    }

    public function actionPhoto()
    {
        $model = Products::findOne(4038);
        return $this->render('index', ['model' => $model]);
    }

    public function actionUpload($id)
    {
        $model = Products::findOne($id);
        $arr = [];
        if ($model) {
            $model_images = ProductsImages::find()->where(['folder' => Inflector::slug($model->article_index)])->all();
            $max_order = 0;
            foreach ($model_images as $model_image) {
                if ($max_order < $model_image->order) {
                    $max_order = $model_image->order + 1;
                }
            }

            $files = UploadedFile::getInstances($model, 'images');
            foreach ($files as $k => $file) {
                $fcleanname = Inflector::slug($model->article_index);
                $fcleanname .= '-' . str_pad($max_order + ($k + 1), 3, "0", STR_PAD_LEFT);
                $fname = $fcleanname . '.' . $file->extension;
                $path = \Yii::getAlias('@webroot/upload/product/' . Inflector::slug($model->article_index) . '/');
                @mkdir($path);
                $file->saveAs($path . $fname);
                @exec("jpegoptim --all-progressive -ptm80 " . $path . $fname, $output);

                $suff = "-domopta.ru";
                copy($path . $fname, $path . 'big-' . $fcleanname . $suff . '.' . $file->extension);
                $model->createThumb($path, $fname, 'thumb-', $suff, 240, 330);
                $model->createThumb($path, $fname, 'small-', $suff, 146, 187);

                $model1 = new ProductsImages();
                $model1->image = $fname;
                $model1->folder = Inflector::slug($model->article_index);
                $model1->category_id = $model->category_id;
                $model1->order = $max_order + $k + 1;
                $model1->save();

                $arr['ids'][$k] = $model1->id;
                $output = [];
                $arr['output'] = $output;
                
            }
        }
        return json_encode($arr);
    }
}

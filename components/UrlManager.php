<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 08.05.17
 * Time: 16:48
 */

namespace app\components;

use app\models\Category;
use app\models\News;
use app\models\Page;
use app\models\SeoUrl;
use app\models\Products;

class UrlManager extends \yii\web\UrlManager
{


    public function createUrl($params)
    {
        $url = parent::createUrl($params);
        $page = Page::find()->where(['route' => $url])->one();
        if($page) {
            return $page->slug;
        }

	    if($params[0] == 'category/index'){
	    	$category = Category::findOne($params['id']);
	    	if($category){
	    		unset($params[0]);
	    		$url = $category->slug;
	    		if(isset($params['page'])){
	    			$url .= '?page=' . $params['page'];
			    }
		    }
	    }

        return $url;

    }

    public function parseRequest($request)
    {
        $path = $request->getPathInfo();
        $path = trim($path, '/');
        if(strpos($path, 'news') === 0){
            $page = News::find()->where(['slug' => '/' . $path])->one();
            if($page){
                \Yii::$app->params['page'] = $page;
                return ['/news' , ['id' => $page->id]];
            }
        }
        if(strpos($path, 'category') === 0){
            $page = Category::find()->where(['slug' => '/' . $path])->one();
            if($page){
                \Yii::$app->params['page'] = $page;
                return ['/category' , ['id' => $page->id]];
            }
        }
        if(strpos($path, 'product') === 0){
            $page = Products::find()->where(['slug' => '/' . $path])->one();
            if($page){
                \Yii::$app->params['page'] = new Page();
                return ['/product' , ['id' => $page->id]];
            }
        }
        
        $seourl = SeoUrl::find()->where(['slug' => '/' . $path])->one();
        if($seourl && $seourl->module == 'catalog'){
            \Yii::$app->params['page'] = $seourl;
            return [$seourl->route, ['id' => $seourl->item_id]];
        }
        
        $page = Page::find()->where(['slug' => '/' . $path])->one();
        if($page){
            \Yii::$app->params['page'] = $page;
            return [$page->route, []];
        } else {
            \Yii::$app->params['page'] = new Page();
        }
        return parent::parseRequest($request);
    }

}
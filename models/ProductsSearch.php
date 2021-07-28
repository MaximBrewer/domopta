<?php
/**
 * Created by PhpStorm.
 * User: resh
 * Date: 10.05.17
 * Time: 16:46
 */

namespace app\models;


use yii\data\ActiveDataProvider;

class ProductsSearch extends Products
{

    public $nophotos;
    public $nodescription;
    public $text;
    public $text_type;
    public $nocolor;
    public $page_size = 24; //Количество товаров на странице списка категории

    public function rules()
    {
        return [
            [['flag', 'nophotos', 'nocolor', 'nodescription', 'text', 'text_type', 'page_size'], 'safe']
        ];
    }

    public function search($params, $category = null){
        $this->load($params);

        $this->text = trim($this->text);

        $categories = Category::find()->where(['parent_id' => $category])->all();
        $array_category[] = $category;
        foreach ($categories as $cat) {
            $array_category[] = $cat->id;
        }

        $query = Products::find()->where(['is_deleted' => 0]);

        if(!\Yii::$app->user->isGuest && !\Yii::$app->user->identity->getIsAdmin()){
            if(\Yii::$app->user->identity->flags == 1) {
                $query->andWhere(['ooo' => '1']);
            }
        }

        if(\Yii::$app->request->get('sort') == 'price'){
	        $query->orderBy(['price' => SORT_ASC]);
        } elseif (\Yii::$app->request->get('sort') == '-price'){
	        $query->orderBy(['price' => SORT_DESC]);
        } elseif (\Yii::$app->request->get('sort') == 'name'){
            $query->orderBy(['name' => SORT_ASC]);
        } else {
	        $query->orderBy(['article' => SORT_ASC]);
        }

        if(!$category && $this->text == ''){
           // $query->andWhere('1=0');
        }

        if($category && $this->text_type != 1){
            $query->andWhere(['products.category_id' => $array_category]);
        }

        if(MODULE_ID == "admin"){
            $this->page_size = 50;
        }

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
            'pagination' => [
                'pageSize' => $this->page_size
//                'pageSize' => 12
            ],
            'sort' => false
        ]);

        if(!$this->validate()){
            return $dataProvider;
        }

        $query->andFilterWhere(['flag' => $this->flag]);
        if($this->color){
            $query->andWhere(['color' => $this->color]);
        }

        if($this->nodescription){
            $query->andWhere(['description' => [null, '']]);
        }

        if($this->nophotos){
            $query->leftJoin('products_images', '`products_images`.`folder` = `products`.`folder`')->andWhere(['image' => null]);
        }

        if($this->text){
            $query->andWhere(['or',['like', 'name' , $this->text], ['like', 'article_index' , $this->text]]);
        }

        if($this->nocolor){
            $query->andWhere(['color' => '']);
        }

        //echo $query->createCommand()->sql; die();

        return $dataProvider;
    }


}
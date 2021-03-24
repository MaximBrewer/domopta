<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\MainAsset;
use app\widgets\loginform\LoginForm;
use app\models\Menu;
use app\models\Cart;
use yii\widgets\ActiveForm;
use app\models\SearchForm;

$searchModel = new SearchForm();
$searchModel->load(Yii::$app->request->queryParams);
MainAsset::register($this);
if(Yii::$app->params['page']->title){
    $this->title = Yii::$app->params['page']->title;
}
if(isset(Yii::$app->params['page']->keywords)){
    $this->registerMetaTag(['name' => 'keywords', 'content' => Yii::$app->params['page']->keywords]);
}
if(isset(Yii::$app->params['page']->description)){
    $this->registerMetaTag(['name' => 'description', 'content' => Yii::$app->params['page']->description]);
}

if(Yii::$app->session->hasFlash('login')){
    $this->registerJS('alert("'.Yii::$app->session->getFlash('login').'")');
}


?>
<?php $this->beginPage() ?>
    <!DOCTYPE html>
    <html lang="<?= Yii::$app->language ?>">
    <head>
        <meta charset="<?= Yii::$app->charset ?>">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <link rel="icon" type="image/png" href="/images/favicon.png" />
        <?= Html::csrfMetaTags() ?>
        <title><?= Html::encode($this->title) ?></title>
        <?php $this->head() ?>
    </head>
    <body>
    <?php $this->beginBody() ?>
    <div class="mh">
        <div class="wrap">
            <ul class="col9 fl">
                <?php $menu = Menu::find()->orderBy('order')->all(); ?>
                <?php foreach ($menu as $item): ?>
                    <li><a href="<?php echo $item->page->slug; ?>"><?php echo $item->page->name; ?></a></li>
                <?php endforeach; ?>
                <div class="clear"></div>
            </ul>
            <?php $this->beginBlock('cart'); ?>
            <div class="col3 fl">
                <div class="cart fl">
                    <?php $cart = Cart::getAmount(); ?>
                    Всего <strong><span id="cart_amount"><?php echo $cart['amount'] ?></span> шт.</strong> <br/>
                    Сумма <strong><span id="cart_sum"><?php echo $cart['sum'] ?></span> ₽</strong>
                </div>

            </div>
            <?php $this->endBlock() ?>
            <?php echo Html::a($this->blocks['cart'], ['/cart']) ?>
            <div class="col4 fl search_box">
                <?php $form = ActiveForm::begin(['action' => ['/search'], 'method' => 'GET']); ?>
                <?php echo Html::activeTextInput($searchModel, 'text'); ?>
                <?php echo Html::submitInput('', ['style' => 'display:none;']);?>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="clear"></div>
        </div>
    </div>
    <header class="header_screen">
        <div class="wrap">
            <a href="/"><div class="logo col4"><img src="/images/logo-en.png" class="logo-en" /></div></a>
            <div class="col4 fl empty_block"></div>
            <div class="col4 fl contacts">
                <div><?php echo Yii::$app->settings->get('Settings.phone_call') ?></div>
                <div>Мы работаем<br/><strong>с 9.00 до 18.00</strong><br>ВОСКРЕСЕНЬЕ – <strong>ВЫХОДНОЙ</strong></div>
            </div>
            <div class="col4 fl login_form">
                <?php echo LoginForm::widget(); ?>

                <hr color="#8a9195">
                <div class="cart fl">
                    <?php $cart = Cart::getAmount(); ?>
                    Всего <strong><span id="cart_amount1"><?php echo $cart['amount'] ?></span> шт.</strong> <br/>
                    Сумма <strong><span id="cart_sum1"><?php echo $cart['sum'] ?></span> ₽</strong>
                </div>
                <?php echo Html::a('Корзина', ['/cart'], ['class' => 'butcart fl' ]) ?>
                <div class="clear"></div>
            </div>
        </div>

    </header>


    <header class="header_phone">
        <div class="wrap">
            <a href="/"><div class="logo col4"><img src="/images/logo-en.png" class="logo-en" /></div></a>
            

            <div class="header_info">
           <!--    <?php echo Html::a('Корзина', ['/cart'], ['class' => 'butcart fl' ]) ?> -->
             <div class="cart fl">
                    <?php $cart = Cart::getAmount(); ?>
                    Всего <strong><span id="cart_amount1"><?php echo $cart['amount'] ?></span> шт.</strong> <br/>
                    Сумма <strong><span id="cart_sum1"><?php echo $cart['sum'] ?></span> ₽</strong>
             </div>

             <div class="header_info_bot">
                 <div class="h_menu"></div>
                 <div class="h_search">
                     <div class="search_box">
                <?php $form = ActiveForm::begin(['action' => ['/search'], 'method' => 'GET']); ?>
                <?php echo Html::activeTextInput($searchModel, 'text'); ?>
                <?php echo Html::submitInput('', ['style' => 'display:none;']);?>
                <?php ActiveForm::end(); ?>
            </div>


                 </div>
             </div>
            </div>
           
            <div class="col4 fl login_form" style="display: none;">
                <?php echo LoginForm::widget(); ?>

                <hr color="#8a9195">
                <div class="cart fl">
                    <?php $cart = Cart::getAmount(); ?>
                    Всего <strong><span id="cart_amount1"><?php echo $cart['amount'] ?></span> шт.</strong> <br/>
                    Сумма <strong><span id="cart_sum1"><?php echo $cart['sum'] ?></span> ₽</strong>
                </div>
               
                <div class="clear"></div>
            </div>
        </div>

    <div class="mobile_menu_container" style="display: none;"> <!-- mobile menu -->
        
    </div>    

    </header>


    <nav class="main_nav">
        <div class="wrap">
            <ul class="col9 fl">
                <?php $menu = Menu::find()->orderBy('order')->all(); ?>
                <?php foreach ($menu as $item): ?>
                    <li><a href="<?php echo $item->page->slug; ?>"><?php echo $item->page->name; ?></a></li>
                <?php endforeach; ?>
                <div class="clear"></div>
            </ul>
            <div class="col3 fl"></div>
            <div class="col4 fl search_box">
                <?php $form = ActiveForm::begin(['action' => ['/search'], 'method' => 'GET']); ?>
                <?php echo Html::activeTextInput($searchModel, 'text'); ?>
                <?php echo Html::submitInput('', ['style' => 'display:none;']);?>
                <?php ActiveForm::end(); ?>
            </div>
            <div class="clear"></div>
        </div>

    </nav>


     <nav class="mobile_nav">           
            <ul>
                <li><a href="/">ГЛАВНАЯ</a></li>
                <?php $menu = Menu::find()->orderBy('order')->all(); ?>
                <?php foreach ($menu as $item): ?>
                    <li><a href="<?php echo $item->page->slug; ?>"><?php echo $item->page->name; ?></a></li>
                <?php endforeach; ?>
                
            </ul>
                <div class="login_form">
                      <?php echo LoginForm::widget(); ?>

                </div>
           

             <div class="cart fl">
                    <?php $cart = Cart::getAmount(); ?>
                    Всего <strong><span id="cart_amount1"><?php echo $cart['amount'] ?></span> шт.</strong> <br/>
                    Сумма <strong><span id="cart_sum1"><?php echo $cart['sum'] ?></span> ₽</strong>
                </div> <br>
             <?php echo Html::a('Корзина', ['/cart'], ['class' => 'butcart fl' ]) ?>   

      <div class="mobile_close"></div>  
      <div class="clear"></div>    
     </nav>




    <?= $content ?>


    <footer>

     <nav class="mobile_nav_footer">           
            <ul>        
                <li><a href="/">ГЛАВНАЯ</a></li>
                <li><a href="/uslovia-raboty">УСЛОВИЯ РАБОТЫ</a></li>
                <li><a href="/polzovatelskoe-soglasenie">ПОЛЬЗОВАТЕЛЬСКОЕ СОГЛАШЕНИЕ</a></li>
                <li><a href="/faq">ВОПРОСЫ И ОТВЕТЫ</a>  </li>
                <li><a href="/">КАТАЛОГ</a></li>
                <li><a href="/dostavka">ДОСТАВКА</a></li>
                <li><a href="/sertifikaty">СЕРТИФИКАТЫ</a> </li>        
                <li><a href="/kontakty">КОНТАКТЫ</a></li>
                <li><a href="/o-nas">О НАС</a></li>
                <li><a href="/contact">НАПИСАТЬ АДМИНИСТРАЦИИ</a></li>                         
            </ul>

      <div class="mobile_close"></div>  
      <div class="clear"></div>    
     </nav>
<!-- 
        <div class="wrap">
            <div class="footer_col1 fcols fl">
                <img src="/images/lvr.jpg">
                <img src="/images/lve.jpg">  <div class="h_menu f_menu"></div>
                <br/>
                Оптовый Комплекс “ЛЕГКИЙ ВЕТЕР”  <br/>
                Республика Крым  <br/>
                г. Симферополь, ул. Крылова, 123  <br/>
                <br/>  <br/>
                Сopyright 2007-2017
            </div>

            <div class="footer_col2 fcols fl">
                <a href="/uslovia-raboty">УСЛОВИЯ РАБОТЫ</a>
                <a href="/polzovatelskoe-soglasenie">ПОЛЬЗОВАТЕЛЬСКОЕ СОГЛАШЕНИЕ</a>
                <a href="/faq">ВОПРОСЫ И ОТВЕТЫ</a>
            </div>

            <div class="footer_col3 fcols fl">
                <a href="/">КАТАЛОГ</a>
                <a href="/dostavka">ДОСТАВКА</a>
                <a href="/sertifikaty">СЕРТИФИКАТЫ</a>
            </div>

            <div class="footer_col4 fcols fl">
                <a href="/kontakty">КОНТАКТЫ</a>
                <a href="/o-nas">О НАС</a>
                <a href="/contact">НАПИСАТЬ АДМИНИСТРАЦИИ</a>
            </div>

            <div class="footer_col5 fcols fl">
                КОНСУЛЬТАЦИЯ<br/>
                <strong><?php echo Yii::$app->settings->get('Settings.phone_call') ?></strong><br/>
                ОТДЕЛ ЗАКАЗОВ<br/>
                <strong><?php echo Yii::$app->settings->get('Settings.phone_order') ?></strong><br/>
                АДМИНИСТРАЦИЯ<br/>
                <strong><?php echo Yii::$app->settings->get('Settings.phone_admin') ?></strong><br/><br/>
                ВОСКРЕСЕНЬЕ – <strong>ВЫХОДНОЙ</strong>
            </div>
            <div class="clear"></div>
            <div class="footer_seo">
                В свое время мы достаточно часто рассказывали нашим читателям о различных самособирающихся структурах, изготовленных из материалов, меняющих свою форму под воздействием света. Такой механизм хорошо подходит для получения трехмерных форм, состоящих из плоскостей, таких, как кубы и пирамиды. Но для того, чтобы заставить изначально плоский материал свернуться в нечто более сложной формы, ученые из университета Северной Каролины разработали новую технологию, которая позволяет при помощи света с различными параметрами управлять процессом "превращения" с достаточно высокой точностью и избирательностью.
            </div>

        </div> -->


        <div class="wrap">
             <div class="footer_col1 fcols fl">
                <img src="/images/lvr.jpg">
                <img src="/images/lve.jpg">  <div class="h_menu f_menu"></div>
                <br/>
                Оптовый Комплекс “ЛЕГКИЙ ВЕТЕР”  <br/>
                Республика Крым  <br/>
                г. Симферополь, ул. Крылова, 123  <br/>
                <br/>  <br/>
                Сopyright 2007-2017
            </div>

               <div class="footer_b_wrap fl">  
           <div class="footer_b_menu">
                <a href="/uslovia-raboty">УСЛОВИЯ РАБОТЫ</a>
                <a href="/polzovatelskoe-soglasenie">ПОЛЬЗОВАТЕЛЬСКОЕ СОГЛАШЕНИЕ</a>
                <a href="/faq">ВОПРОСЫ И ОТВЕТЫ</a>
            

          
                <a href="/">КАТАЛОГ</a>
                <a href="/dostavka">ДОСТАВКА</a>
                <a href="/sertifikaty">СЕРТИФИКАТЫ</a>
            

           
                <a href="/kontakty">КОНТАКТЫ</a>
                <a href="/o-nas">О НАС</a>
                <a href="/contact">НАПИСАТЬ АДМИНИСТРАЦИИ</a>
            </div>

             <div class="footer_seo footer_seo2">
                В свое время мы достаточно часто рассказывали нашим читателям о различных самособирающихся структурах, изготовленных из материалов, меняющих свою форму под воздействием света. Такой механизм хорошо подходит для получения трехмерных форм, состоящих из плоскостей, таких, как кубы и пирамиды. Но для того, чтобы заставить изначально плоский материал свернуться в нечто более сложной формы, ученые из университета Северной Каролины разработали новую технологию, которая позволяет при помощи света с различными параметрами управлять процессом "превращения" с достаточно высокой точностью и избирательностью.
            </div> 

            </div> 

            <div class="footer_col5 fcols fl">
                КОНСУЛЬТАЦИЯ<br/>
                <strong><?php echo Yii::$app->settings->get('Settings.phone_call') ?></strong><br/>
                ОТДЕЛ ЗАКАЗОВ<br/>
                <strong><?php echo Yii::$app->settings->get('Settings.phone_order') ?></strong><br/>
                АДМИНИСТРАЦИЯ<br/>
                <strong><?php echo Yii::$app->settings->get('Settings.phone_admin') ?></strong><br/><br/>
                ВОСКРЕСЕНЬЕ – <strong>ВЫХОДНОЙ</strong>
            </div>

             <div class="clear"></div>
              <div class="footer_col1 fcols fl footer_col_vis">
                <img src="/images/lvr.jpg">
                <img src="/images/lve.jpg">
                <br/>
                Оптовый Комплекс “ЛЕГКИЙ ВЕТЕР”  <br/>
                Республика Крым  <br/>
                г. Симферополь, ул. Крылова, 123  <br/>
                <br/>  <br/>
                Сopyright 2007-2017
            </div>

            


            <div class="clear"></div>
        </div>










    </footer>

    <div class="arrows">
        <div class="arrow-up"></div>
        <div class="arrow-down"></div>
    </div>

    <?php $this->endBody() ?>
    </body>
    </html>
<?php $this->endPage() ?>
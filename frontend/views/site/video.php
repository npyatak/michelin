<?php
use yii\helpers\Url;
?>

<?php $videoArr = [
	['id' => '042UyeWlC5I', 'title' => 'О проекте', 'image' => '/img/video/1.jpg'],
	['id' => 'jB4MyAc2ujQ', 'title' => 'Скажите сыыыр! Ферма-сыроварня, Матокса', 'image' => '', 'cityId' => 105],
	['id' => 'gtqMyLBQfJE', 'title' => 'Саблинские пещеры', 'image' => ''],
	['id' => 'wRSDnBc-4-w', 'title' => 'Таинственный лес', 'image' => ''],
	['id' => 'e7pYgyx7cWM', 'title' => 'Музей железных дорог России', 'image' => '', 'cityId' => 100],
	['id' => 'tCY8VXOZhK8', 'title' => 'Трек, Хибины', 'image' => ''],
	['id' => 'b4j0uABIbBc', 'title' => 'Кировский рудник, Хибины', 'image' => '/img/video/7.jpg', 'cityId' => 101],
	['id' => 'WBMPt-EqKLo', 'title' => 'Гольф-клуб "Дюны", Сестрорецк', 'image' => '', 'cityId' => 102],
	['id' => 'xajxxDJUNxQ', 'title' => 'Ретро-дайвинг, Семиозерье', 'image' => '/img/video/9.jpg', 'cityId' => 103],
	['id' => 'pjLmtZViw8k', 'title' => 'По законам севера. Этническая деревня', 'image' => '/img/video/10.jpg', 'cityId' => 104],
	['id' => 'W0awU596rNo', 'title' => 'Горячий снег. Тур на снегоходах', 'image' => '/img/video/11.jpg'],
    // ['id' => 'tCY8VXOZhK8', 'title' => 'Лёдная погода. Хибины', 'image' => '/img/video/2018-10-18_17-44-31.png'],
    // ['id' => 'wRSDnBc-4-w', 'title' => 'Арт-парк "Таинственный лес"', 'image' => '/img/video/2018-10-18_17-45-37.png'],
    // ['id' => 'gtqMyLBQfJE', 'title' => 'Саблинские пещеры', 'image' => '/img/video/2018-10-18_17-47-41.png'],
];
?>
<?php $this->params['bodyClass'] = 'about_page';?>

<div class="page_wrapper ">
    <div class="row text_center">
        <a href="#" class="main_title"></a>
    </div>
    <div class="row text_center">
        <div class="col ruli_zimoi_label">
            <p>Чтобы стать лучшим, смотри видео <strong>в этом разделе</strong>,</p>
    	    <p>выполняй условия и получай крутые призы</p>
        </div>
    </div>
    <div class="row contast-cards">
    	<?php foreach ($videoArr as $key => $v):?>
    		<?php $image = $v['image'] ? Url::toRoute($v['image']) : "https://img.youtube.com/vi/".$v['id']."/maxresdefault.jpg";?>
	        <div class="col-xs-offset-1 col-sm-offset-0 col-xs-10 col-sm-6 col-md-4 col-lg-4 contast-card"">
	            <div class="contast-card-play-icon play-video" data-id="<?=$v['id']?>"></div>
	            <div class="contest-image" style="background: url(<?=$image;?>) 0 0/cover;">
                    <?php if(isset($v['cityId'])):?>
	            	    <a href="<?=Url::toRoute(['site/index', 'cityId' => $v['cityId']]);?>" class="contest-link">Подробнее..</a>
                    <?php endif;?>

	            	<div class="contest-image-shadow"></div>
	            </div>
	            <div class="contest-text text_center"><?=$v['title'];?></div>
	        </div>
    	<?php endforeach;?>
    </div>
</div>


<div class="video-modal" id="video">
    <div class="modalType2-content">
        <div class="video-modal-close"></div>
        <div id="ytplayer"></div>
    </div>
</div>

<div class="overlay"></div>

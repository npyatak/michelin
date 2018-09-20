<?php $videoArr = [
	['id' => '042UyeWlC5I', 'title' => 'О проекте', 'image' => '/img/video/1.jpg'],
	['id' => 'jB4MyAc2ujQ', 'title' => 'Скажите сыыыр! Ферма-сыроварня, Матокса', 'image' => ''],
	['id' => 'gtqMyLBQfJE', 'title' => 'Саблинские пещеры', 'image' => ''],
	['id' => 'wRSDnBc-4-w', 'title' => 'Таинственный лес', 'image' => ''],
	['id' => 'e7pYgyx7cWM', 'title' => 'Музей железных дорог России', 'image' => ''],
	['id' => 'tCY8VXOZhK8', 'title' => 'Трек, Хибины', 'image' => ''],
	['id' => 'b4j0uABIbBc', 'title' => 'Кировский рудник, Хибины', 'image' => '/img/video/7.jpg'],
	['id' => 'WBMPt-EqKLo', 'title' => 'Гольф-клуб "Дюны", Сестрорецк', 'image' => ''],
	['id' => 'xajxxDJUNxQ', 'title' => 'Ретро-дайвинг, Семиозерье', 'image' => '/img/video/9.jpg'],
	['id' => 'pjLmtZViw8k', 'title' => 'По законам севера. Этническая деревня', 'image' => '/img/video/10.jpg'],
	['id' => 'W0awU596rNo', 'title' => 'Горячий снег. Тур на снегоходах', 'image' => '/img/video/11.jpg'],
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
    		<?php $image = $v['image'] ? $v['image'] : "https://img.youtube.com/vi/".$v['id']."/maxresdefault.jpg";?>
	        <div class="col-xs-offset-1 col-sm-offset-0 col-xs-10 col-sm-6 col-md-4 col-lg-4 contast-card"">
	            <div class="contast-card-play-icon play-video" data-id="<?=$v['id']?>"></div>
	            <div class="contest-image" style="background: url(<?=$image;?>) 0 0/cover;">
	            	<a href="" class="contest-link">Подробнее..</a>
	            	<div class="contest-image-shadow"></div>
	            </div>
	            <div class="contest-text text_center">Снегоходы</div>
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

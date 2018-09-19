<?php $videoArr = [
	['id' => '042UyeWlC5I', 'image' => '/img/video/1.jpg'],
	['id' => 'jB4MyAc2ujQ', 'image' => ''],
	['id' => 'gtqMyLBQfJE', 'image' => ''],
	['id' => 'wRSDnBc-4-w', 'image' => ''],
	['id' => 'e7pYgyx7cWM', 'image' => ''],
	['id' => 'tCY8VXOZhK8', 'image' => ''],
	['id' => 'b4j0uABIbBc', 'image' => '/img/video/7.jpg'],
	['id' => 'WBMPt-EqKLo', 'image' => ''],
	['id' => 'xajxxDJUNxQ', 'image' => '/img/video/9.jpg'],
	['id' => 'pjLmtZViw8k', 'image' => '/img/video/10.jpg'],
	['id' => 'W0awU596rNo', 'image' => '/img/video/11.jpg'],
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
	            <div class="contest-image" style="background: url(<?=$image;?>) 0 0/cover;"></div>
	            <!-- <div class="contest-text text_center">Снегоходы</div> -->
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
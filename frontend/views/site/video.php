<?php $videoArr = [
	'042UyeWlC5I',
	'jB4MyAc2ujQ',
	'gtqMyLBQfJE',
	'wRSDnBc-4-w',
	'e7pYgyx7cWM',
	'tCY8VXOZhK8',
	'b4j0uABIbBc',
	'WBMPt-EqKLo',
	'xajxxDJUNxQ',
	'pjLmtZViw8k',
	'W0awU596rNo',
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
	        <div class="col-xs-offset-1 col-sm-offset-0 col-xs-10 col-sm-6 col-md-4 col-lg-4 contast-card" data-toggle="modal" data-target="#contest-video-1">
	            <div class="contast-card-play-icon play-video" data-id="<?=$v?>"></div>
	            <div class="contest-image" style="background: url('https://img.youtube.com/vi/<?=$v;?>/maxresdefault.jpg') 0 0/cover;"></div>
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
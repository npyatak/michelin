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

<div class="page_wrapper">
    <div class="text text_center">
        <div class="like-p">
            <div>Чтобы стать лучшим, смотри видео <b>в этом разделе</b>,</div>
            <div>выполняй условия и получай призы</div>
        </div>
    </div>

    <div class="row main_screen">
    	<?php foreach ($videoArr as $v):?>
	        <div class="video" style="background: url('https://img.youtube.com/vi/<?=$v;?>/maxresdefault.jpg') 0 0/cover;">
	            <div class="play-video" data-id="<?=$v?>"></div>
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
<?php
namespace frontend\widgets\share;

use yii\helpers\Url;

class ShareWidget extends \yii\bootstrap\Widget  {
	
	public $post;
	public $url;
	public $title = 'Nokia 8: покажи свою историю с обеих сторон';
	public $image;
	public $desc = 'Голосуйте за меня и участвуйте в конурсе #fridaybothie #бозинапятнице #bothie';

	public function init() {
		if($this->post->is_from_ig) {
			$this->image = $this->post->igImageUrl;
		}
		$this->image = $this->image ? $this->image : Url::to($this->post->gluedImageUrl, true);
		$this->url = $this->url ? $this->url : Url::to($this->post->url, true);
	}

	public function run() {
    	$script = "
    		$(document).on('click', '.shares-link', function(e) {
    			obj = $(this);
    			if(obj.hasClass('inactive')) {
    				return false;
    			}

    			var url = getShareUrl(obj);

    			$.ajax({
		            type: 'GET',
        			url: '".Url::toRoute(['site/user-action'])."',
		            data: 'id='+obj.data('id')+'&type='+obj.attr('data-type'),
		            success: function (data) {
		            	if(data.status === 'success') {
		            		obj.closest('.other-jobs__item').find('.o-j__rating span').html(data.score);
		            		obj.addClass('inactive');
		            	}
		            }
		        });

    			window.open(url,'','toolbar=0,status=0,width=626,height=436');
    		});
	    ";
	    $this->view->registerJs($script, \yii\web\View::POS_END);

		echo $this->render('widget', [
			'post' => $this->post,
			'url' => $this->url,
			'title' => $this->title,
			'image' => $this->image,
			'desc' => $this->desc,
		]);
    }
}
?>
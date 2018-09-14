<?php
namespace frontend\widgets\share;

use Yii;
use yii\helpers\Url;
use yii\helpers\Html;

use common\models\Share;

class ShareWidget extends \yii\base\Widget 
{

	public $share;
	public $wrap;
	public $wrapClass;
	public $itemWrapClass;
	public $itemClass = 'share';

    public function init()
    {
        $this->registerAssets();
    }

    public function run() {
        $this->share['url'] = Url::current([], $_SERVER['REQUEST_SCHEME']);
        $this->share['imageUrl'] = isset($this->share['image']) ? Url::to([$this->share['image']], $_SERVER['REQUEST_SCHEME']) : null;

        $view = $this->getView();
		$view->registerMetaTag(['property' => 'og:description', 'content' => $this->share['text']], 'og:description');
		$view->registerMetaTag(['property' => 'og:title', 'content' => $this->share['title']], 'og:title');
		$view->registerMetaTag(['property' => 'og:url', 'content' => $this->share['url']], 'og:url');
		$view->registerMetaTag(['property' => 'og:type', 'content' => 'website'], 'og:type');
		if(isset($this->share['image']) && $this->share['image']) {
        	$imagePath = Share::getImageSrcPath().$this->share['image'];
        	if(is_file($imagePath)) {
				$view->registerMetaTag(['property' => 'og:image', 'content' => $this->share['imageUrl']], 'og:image');
				$size = getimagesize($imagePath);
				if(is_array($size)) {
					$view->registerMetaTag(['property' => 'og:image:width', 'content' => $size[0]], 'og:image:width');
					$view->registerMetaTag(['property' => 'og:image:height', 'content' => $size[1]], 'og:image:height');
				}
			}
		}

	    echo Html::a('<img src="/img/facebook.png" alt="">', '', [
	        'class' => 'share fb',
	        'data-type' => 'fb',
	        'data-url' => $this->share['url'],
	        'data-title' => $this->share['title'],
	        'data-image' => $this->share['imageUrl'],
	        'data-text' => $this->share['text'],
	        'rel' => 'nofollow',
	    ]);
	    echo Html::a('<img src="/img/vk.png" alt="">', '', [
	        'class' => 'share vk',
	        'data-type' => 'vk',
	        'data-url' => $this->share['url'],
	        'data-title' => $this->share['title'],
	        'data-image' => $this->share['imageUrl'],
	        'data-text' => $this->share['text'],
	        'rel' => 'nofollow',
	    ]);
    }

    private function registerAssets()
    {
        $view = $this->getView();

        $asset = ShareAsset::register($view);
    }
}
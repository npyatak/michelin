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
	public $showButtons = true;

    public function init()
    {
        $this->registerAssets();
    }

    public function run() {
    	$share = $this->share;
    	
    	$scheme = isset($_SERVER['REQUEST_SCHEME']) ? $_SERVER['REQUEST_SCHEME'] : true;
        $share['url'] = Url::current([], $scheme);
        $share['imageUrl'] = isset($share['image']) ? Url::to([$share['image']], $scheme) : null;

        $view = $this->getView();
		$view->registerMetaTag(['property' => 'og:description', 'content' => $share['text']], 'og:description');
		$view->registerMetaTag(['property' => 'og:title', 'content' => $share['title']], 'og:title');
		$view->registerMetaTag(['property' => 'og:url', 'content' => $share['url']], 'og:url');
		$view->registerMetaTag(['property' => 'og:type', 'content' => 'website'], 'og:type');

        if($share['image'] && $this->ifFileExists($share['imageUrl'])) {
            $view->registerMetaTag(['property' => 'og:image', 'content' => $share['imageUrl']], 'og:image');
			list($width, $height) = getimagesize($share['imageUrl']);
            if($width && $height) {
                $view->registerMetaTag(['property' => 'og:image:width', 'content' => $width], 'og:image:width');
                $view->registerMetaTag(['property' => 'og:image:height', 'content' => $height], 'og:image:height');
            }
		}

		if($this->showButtons) {
		    echo Html::a('<i class="fa fa-facebook-f"></i>', '', [
		        'class' => 'share result-facebook',
		        'data-type' => 'fb',
		        'data-url' => $share['url'],
		        'data-title' => $share['title'],
		        'data-image' => $share['imageUrl'],
		        'data-text' => $share['text'],
		        'rel' => 'nofollow',
		    ]);
		    echo Html::a('<i class="fa fa-vk"></i>', '', [
		        'class' => 'share result-vk',
		        'data-type' => 'vk',
		        'data-url' => $share['url'],
		        'data-title' => $share['title'],
		        'data-image' => $share['imageUrl'],
		        'data-text' => $share['text'],
		        'rel' => 'nofollow',
		    ]);
		}
    }

    private function registerAssets()
    {
        $view = $this->getView();

        $asset = ShareAsset::register($view);
    }

    public static function ifFileExists($url) 
    {
        $curl = curl_init($url);

        curl_setopt($curl, CURLOPT_NOBODY, true);

        $result = curl_exec($curl);

        $ret = false;

        if ($result !== false) {
            $statusCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);  

            if ($statusCode == 200) {
                $ret = true;   
            }
        }
        curl_close($curl);

        return $ret;
    }
}
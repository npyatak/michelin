<?php

use yii\helpers\Url;
use yii\helpers\Html;
use yii\web\View;

/** @var $this View */
/** @var $id string */
/** @var $services stdClass[] See EAuth::getServices() */
/** @var $action string */
/** @var $popup bool */
/** @var $assetBundle string Alias to AssetBundle */

Yii::createObject(['class' => $assetBundle])->register($this);

// Open the authorization dilalog in popup window.
if ($popup) {
	$options = [];
	foreach ($services as $name => $service) {
		$options[$service->id] = $service->jsArguments;
	}
	$this->registerJs('$("#' . $id . '").eauth(' . json_encode($options) . ');');
}

?>

<div id="<?php echo $id; ?>">
	<?php
	foreach ($services as $name => $service) {
		echo Html::a('', [$action, 'service' => $name, 'ref' => Url::current()], [
			'class' => $name,
			'data-eauth-service' => $service->id,
		]);
	}
	?>
</div>

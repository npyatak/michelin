<?php
namespace frontend\widgets\social;

class SocialWidget extends \nodge\eauth\Widget {

    public function run() {
		echo $this->render('widget', [
			'id' => $this->getId(),
			'services' => $this->services,
			'action' => $this->action ? $this->action : Url::toRoute(['site/login']),
			'popup' => $this->popup,
			'assetBundle' => $this->assetBundle,
		]);
    }
}
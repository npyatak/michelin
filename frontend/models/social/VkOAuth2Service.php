<?php
/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii2-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace frontend\models\social;

class VkOAuth2Service extends \nodge\eauth\services\VKontakteOAuth2Service {

	const SCOPE_EMAIL = 'email';
	const SCOPE_VIDEO = 'video';

	protected $scopes = [self::SCOPE_EMAIL, self::SCOPE_VIDEO];

	protected function fetchAttributes() {
		$tokenData = $this->getAccessTokenData();

		$access_token = $tokenData['access_token'];
		$email = isset($tokenData['params']['email']) ? $tokenData['params']['email'] : '';

		$info = $this->makeSignedRequest('users.get.json', [
			'query' => [
				'uids' => $tokenData['params']['user_id'],
				'v' => 5.73,
				'fields' => 'nickname, sex, bdate, city, country, timezone, photo, photo_medium, photo_big, photo_rec',
			],
		]);

		$info = $info['response'][0];

		$this->attributes = $info;
		$this->attributes['id'] = $info['id'];
		$this->attributes['name'] = $info['first_name'];
		$this->attributes['surname'] = $info['last_name'];
		$this->attributes['url'] = 'http://vk.com/id' . $info['id'];
		$this->attributes['photo_url'] = $info['photo_medium'];
		$this->attributes['email'] = $email;
		$this->attributes['access_token'] = $access_token;

		if (!empty($info['nickname'])) {
			$this->attributes['username'] = $info['nickname'];
		} else {
			$this->attributes['username'] = 'id' . $info['id'];
		}

		$this->attributes['gender'] = $info['sex'] == 1 ? 'F' : 'M';

		if (!empty($info['timezone'])) {
			$this->attributes['timezone'] = timezone_name_from_abbr('', $info['timezone'] * 3600, date('I'));
		}

		// $this->attributes['country'] = json_decode(file_get_contents('https://api.vk.com/method/database.getCountriesById' . '?' . urldecode(http_build_query(['country_ids' => $info['country']]))), true);
		// $this->attributes['country'] = $this->country['response'][0]['name'];
		
		// $this->attributes['city'] = json_decode(file_get_contents('https://api.vk.com/method/database.getCitiesById' . '?' . urldecode(http_build_query(['city_ids' => $info['city']]))), true);
		// $this->attributes['city'] = $this->city['response'][0]['name'];

		$smas=explode('.',$info['bdate']);
		$str = $smas[2]. '-' . $smas[1] . '-'. $smas[0];
		$timestamp = strtotime($str);
		$this->attributes['bdate'] = date('Y-n-d ', $timestamp);

		return true;
	}
}

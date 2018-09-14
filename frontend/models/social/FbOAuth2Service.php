<?php
/**
 * An example of extending the provider class.
 *
 * @author Maxim Zemskov <nodge@yandex.ru>
 * @link http://github.com/Nodge/yii2-eauth/
 * @license http://www.opensource.org/licenses/bsd-license.php
 */

namespace frontend\models\social;

class FbOAuth2Service extends \nodge\eauth\services\FacebookOAuth2Service
{
    const SCOPE_USER_ABOUT_ME = 'user_about_me';

    protected $scopes = [
        self::SCOPE_EMAIL,
        self::SCOPE_USER_BIRTHDAY,
        self::SCOPE_USER_HOMETOWN,
        self::SCOPE_USER_LOCATION,
        self::SCOPE_USER_PHOTOS,
        self::SCOPE_USER_ABOUT_ME,
    ];

    /**
     * http://developers.facebook.com/docs/reference/api/user/
     *
     * @see FacebookOAuth2Service::fetchAttributes()
     */
    protected function fetchAttributes()
    {
        $info = $this->makeSignedRequest('me', [
            'query' => [
                'fields' => join(',', [
                    'id',
                    'name',
                    'link',
                    'email',
                    'verified',
                    'first_name',
                    'last_name',
                    'gender',
                    'birthday',
                    'hometown',
                    'location',
                    'locale',
                    'timezone',
                    'updated_time',
                ])
            ]
        ]);
        
        $this->attributes = $info;
        $this->attributes['photo_url'] = $this->baseApiUrl.$this->getId().'/picture?width=100&height=100';
        $this->attributes['sex'] = $info['gender'] == 'male' ? 2 : 1;

        if(isset($info['birthday'])) {
            $exp=explode('/',$info['birthday']);
            $this->attributes['bdate'] = $exp[2]. '-' . $exp[1] . '-'. $exp[0];
        }
        if(isset($info['hometown'])) {
            $exp=explode(', ',$info['location']['name']);
            if(isset($exp[1])) $this->attributes['country'] = $exp[1];
            if(isset($exp[0])) $this->attributes['city'] = $exp[0];
        } elseif(isset($info['location'])) {
            $exp=explode(', ',$info['hometown']['name']);
            if(isset($exp[1])) $this->attributes['country'] = $exp[1];
            if(isset($exp[0])) $this->attributes['city'] = $exp[0];
        }

        return true;
    }
}

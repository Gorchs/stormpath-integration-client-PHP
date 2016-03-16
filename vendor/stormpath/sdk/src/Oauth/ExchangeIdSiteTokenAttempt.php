<?php
/*
 * Copyright 2016 Stormpath, Inc.
 *
 * Licensed under the Apache License, Version 2.0 (the "License");
 * you may not use this file except in compliance with the License.
 * You may obtain a copy of the License at
 *
 *     http://www.apache.org/licenses/LICENSE-2.0
 *
 * Unless required by applicable law or agreed to in writing, software
 * distributed under the License is distributed on an "AS IS" BASIS,
 * WITHOUT WARRANTIES OR CONDITIONS OF ANY KIND, either express or implied.
 * See the License for the specific language governing permissions and
 * limitations under the License.
 */


namespace Stormpath\Oauth;

use Stormpath\Resource\Resource;

class ExchangeIdSiteTokenAttempt extends Resource
{
    const TOKEN             = 'token';
    const GRANT_TYPE        = 'grant_type';

    public function setToken($token) {
        $this->setProperty(self::TOKEN, $token);
        return $this;
    }

    public function setGrantType($grantType) {
        $this->setProperty(self::GRANT_TYPE, $grantType);
        return $this;
    }

    public function getToken() {
        return $this->getProperty(self::TOKEN);
    }

    public function getGrantType() {
        return $this->getProperty(self::REFRESH_TOKEN);
    }
}
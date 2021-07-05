<?php

namespace Xyrotech\Traits;

trait AuthenticationTrait
{

    /**
     * Generate the request token
     *
     * @param string $username
     * @return object
     */
    public function request_token() : object
    {
        $this->parameters = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'User-Agent' => $this->config['DISCOGS_USER_AGENT'],
                'Authorization' => 'OAuth oauth_consumer_key=' . $this->config['DISCOGS_CONSUMER_KEY']
                    . ',oauth_nonce=' .  time() . ',oauth_signature=' . $this->config['DISCOGS_CONSUMER_SECRET']
                    . '&,oauth_signature_method=PLAINTEXT,oauth_timestamp=' . time() . ',oauth_callback='
                    . $this->config['OAUTH_CALLBACK'],
            ],
        ];

        return $this->response('GET', "/oauth/request_token");
    }

    /**
     * Generate the access token
     *
     * @param string $token
     * @param string $secret
     * @param string $verifier
     * @return object
     */
    public function access_token(string $oauth_token, string $oauth_token_secret, string $verifier) : object
    {
        $this->parameters = [
            'headers' => [
                'Content-Type' => 'application/x-www-form-urlencoded',
                'User-Agent' => $this->config['DISCOGS_USER_AGENT'],
                'Authorization' => 'OAuth oauth_consumer_key=' . $this->config['DISCOGS_CONSUMER_KEY']
                    . ',oauth_nonce=' .  time() . ',oauth_token=' . $oauth_token . ',oauth_signature='
                    . $this->config['DISCOGS_CONSUMER_SECRET'] . '&' . $oauth_token_secret
                    . ',oauth_signature_method=PLAINTEXT,oauth_timestamp=' . time() . ',oauth_verifier=' . $verifier,
            ],
        ];

        return $this->response('POST', "/oauth/access_token");
    }
}

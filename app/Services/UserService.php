<?php

namespace App\Services;

use Illuminate\Contracts\Auth\Authenticatable;

class UserService implements Authenticatable
{
    /**
     * @var \PHPOpenSourceSaver\JWTAuth\Payload
     */
    protected $payload;

    /**
     * @var array
     */
    protected $attributes = [];

    /**
     * @param $jwtPayload
     */
    public function __construct($jwtPayload)
    {
        $this->payload = $jwtPayload;
        $this->setAttribute();
    }

    /**
     * @return array
     */
    private function setAttribute()
    {
        return $this->attributes = [
            'id' => $this->payload['sub'],
        ];
    }

    /**
     * Get the name of the unique identifier for the user.
     *
     * @return string
     */
    public function getAuthIdentifierName()
    {
        dd($this->payload);
    }

    /**
     * Get the unique identifier for the user.
     *
     * @return mixed
     */
    public function getAuthIdentifier()
    {
        return $this->payload['sub'];
    }

    /**
     * Get the password for the user.
     *
     * @return string
     */
    public function getAuthPassword()
    {
        return null;
    }

    /**
     * Get the token value for the "remember me" session.
     *
     * @return string
     */
    public function getRememberToken()
    {
        return null;
    }

    /**
     * Set the token value for the "remember me" session.
     *
     * @param string $value
     *
     * @return bool
     */
    public function setRememberToken($value)
    {
        return true;
    }

    /**
     * Get the column name for the "remember me" token.
     *
     * @return string
     */
    public function getRememberTokenName()
    {
        return null;
    }

    /**
     * Dynamically retrieve attributes on the model.
     *
     * @param string $key
     *
     * @return mixed
     */
    public function __get($key)
    {
        return $this->attributes[$key];
    }
}

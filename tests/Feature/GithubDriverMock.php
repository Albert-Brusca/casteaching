<?php

namespace Tests\Feature;

class GithubDriverMock
{
    const ID = 4015406;
    const NAME = "Albert Brusca Manchón";
    const NICKNAME = "AlbertBrusca";
    const AVATAR = "TODO";
    const EMAIL = "abrusca@iesebre.com";
    const TOKEN = "TOKEN_HERE";
    const REFRESH_TOKEN = null;

    public $user;

    /**
     * @param $user
     */
    public function __construct($user = null)
    {
        if ($user) {
            $this->user = $user;
            return;
        }
        $this->setDefaultUser();
    }


    public function user()
    {
        return $this->user;
    }

    private function setDefaultUser()
    {
        $user = new \stdClass();
        $user->id = GithubDriverMock::ID;
        $user->email = GithubDriverMock::EMAIL;
        $user->name = GithubDriverMock::NAME;
        $user->avatar = GithubDriverMock::AVATAR;
        $user->nickname = GithubDriverMock::NICKNAME;
        $user->token = GithubDriverMock::TOKEN;
        $user->refreshToken = GithubDriverMock::REFRESH_TOKEN;
        $this->user = $user;
    }
}

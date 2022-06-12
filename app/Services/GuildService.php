<?php

namespace App\Services;

class GuildService
{
    /**
     * @return array[]
     */
    public function mockGuilds()
    {
        return [
            [
                'name'   => 'Plats Hanoi',
                'avatar' => asset('img/admin/demo/list/01.webp'),
            ],
            [
                'name'   => 'VAIX Hanoi',
                'avatar' => asset('img/admin/demo/guild/vaix_logo.png'),
            ],
            [
                'name'   => 'Moto Hanoi',
                'avatar' => asset('img/admin/demo/guild/moto.png'),
            ],
        ];
    }
}

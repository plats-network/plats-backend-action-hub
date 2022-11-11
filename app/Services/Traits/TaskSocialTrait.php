<?php

namespace App\Services\Traits;

trait TaskSocialTrait
{
    /**
     * @param \App\Models\Task $task
     * @param array $Socials
     */
    public function createSocial($task, $socials)
    {
        if (empty($socials)) {
            return true;
        }

        $socialData = [];
        foreach ($socials as $social) {
            $socialData[] = [
                'name'              => $social['name'],
                'url'               => $social['url'],
                'type'              => $social['type_social'],
                'platform'          => $social['platform']
            ];
        }

        if (!empty($socialData)) {
            $task->taskSocials()->createMany($socialData);
        }

        return true;
    }

    /**
     * @param $task
     * @param $socials
     *
     * @return bool|void
     */
    public function updateSocial($task, $socials)
    {
        if (empty($socials)) {
            return true;
        }

        foreach ($socials as $social) {
            $socialData = [
                'name'              => $social['name'],
                'url'               => $social['url'],
                'type'              => $social['type_social'],
                'platform'          => $social['platform']
            ];

            $task->taskSocials()->where('id', $social['id'])->update($socialData);
        }
    }
}

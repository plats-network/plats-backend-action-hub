<?php

namespace App\Services\Traits;

trait TaskLocationTrait
{
    /**
     * @param \App\Models\Task $task
     * @param array $locations
     */
    public function createLocation($task, $locations)
    {
        if (empty($locations)) {
            return true;
        }

        $locationData = [];
        foreach ($locations as $order => $location) {
            $longAndLat     = explode(',', preg_replace('/\s+/', '', $location['coordinate']));
            $locationData[] = [
                'name'    => $location['name'],
                'address' => $location['address'],
                'long'    => $longAndLat[0],
                'lat'     => $longAndLat[1],
                'sort'    => $order,
                'status'  => ACTIVE_LOCATION_TASK,
            ];
        }

        if (!empty($locationData)) {
            $task->locations()->createMany($locationData);
        }

        return true;
    }

    /**
     * @param $task
     * @param $locations
     *
     * @return bool|void
     */
    public function updateLocation($task, $locations)
    {
        if (empty($locations)) {
            return true;
        }

        foreach ($locations as $location) {
            $longAndLat     = explode(',', preg_replace('/\s+/', '', $location['coordinate']));
            $locationData = [
                'name'    => $location['name'],
                'address' => $location['address'],
                'long'    => $longAndLat[0],
                'lat'     => $longAndLat[1],
            ];

            $task->locations()->where('id', $location['id'])->update($locationData);
        }
    }
}

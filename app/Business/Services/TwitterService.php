<?php

namespace App\Business\Services;

use \Twitter;
use \Cache;

class TwitterService
{
    /**
     * @param string $user
     * @param int $number
     * @return array|mixed
     */
    public function getLastsTweets($user = 'bikebitants', $number = 2)
    {
        try {
            return Cache::remember("tweets_{$user}_{$number}", 60, function () use ($number, $user) {
                return Twitter::getUserTimeline(['screen_name' => $user, 'count' => $number]);
            });
        } catch (\Exception $e) {
            return [];
        }
    }
}
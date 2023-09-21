<?php
namespace App\Services;
class SpotifyCronService
{
    public function doSomething()
    {
        \Log::info('Log Test Cron ' . now());
    }
}

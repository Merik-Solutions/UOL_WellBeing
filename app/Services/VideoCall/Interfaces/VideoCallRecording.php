<?php

namespace App\Services\VideoCall\Interfaces;

use Illuminate\Http\Request;

interface VideoCallRecording
{
    public function recordAcquire($data);
    public function recordStart($data);
    public function callQuery($data);
    public function recordStop($data);
}

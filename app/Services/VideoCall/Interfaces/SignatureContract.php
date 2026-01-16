<?php

namespace App\Services\VideoCall\Interfaces;

use Illuminate\Http\Request;

interface SignatureContract
{
    public function generateSignature($channelName,$role_id);
}

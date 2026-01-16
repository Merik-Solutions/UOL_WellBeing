<?php

namespace App\Services\VideoCall\Interfaces;

use Illuminate\Foundation\Auth\User;
use Illuminate\Http\Request;

interface VideoCall
{
    public function find($meeting_id): array;

    public function generateToken(User $user): string;

    public function createMeeting(array $data): array;
}

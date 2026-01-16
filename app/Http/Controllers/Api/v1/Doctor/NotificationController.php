<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function notifications()
    {
        $notifications = auth()
            ->user()
            ->notifications()
            ->get(['data', 'type','read_at']);

        return responseJson(
            NotificationResource::collection($notifications),
            __('Loaded successfully'),
        );
    }

    public function read($id)
    {
        request()
            ->user()
            ->notifications()
            ->where('id', $id)
            ->first()
            ->markAsRead();

        return responseJson(null, __('Updated Successfully'));
    }

    public function readAll()
    {
        request()
            ->user()
            ->unreadNotifications->markAsRead();

        return responseJson(null, __('Updated Successfully'));
    }
}

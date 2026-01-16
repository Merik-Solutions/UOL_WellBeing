<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Http\Controllers\Controller;
use App\Http\Resources\NotificationResource;
use Illuminate\Http\Request;
use App\Models\Promocode;
use Carbon\Carbon;

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
            __('Loaded successfully')
        );
    }

    public function promocodes()
    {
        // $notifications = auth()
        //     ->user()
        //     ->notifications()
        //     ->where('data->title', 'promocode')
        //     ->get(['data', 'type']);
        $notifications = Promocode::whereDate('expired_at','>', Carbon::now())
        ->select(['id','code','percent','type','expired_at','created_at'])->get();
           
        return responseJson($notifications, __('Loaded successfully'));
    }

    public function read($id)
    {
        request()
            ->user()
            ->notifications()
            ->where('id', $id)
            ->first()
            ->markAsRead();

        return responseJson(null, __('Updated Sucessfully'));
    }

    public function readAll()
    {
        request()
            ->user()
            ->unreadNotifications->markAsRead();

        return responseJson(null, __('Updated Sucessfully'));
    }
}

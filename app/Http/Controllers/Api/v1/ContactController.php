<?php

namespace App\Http\Controllers\Api\v1;

use App\Http\Controllers\Controller;
use App\Http\Resources\Contact\ContactResource;
use App\Repositories\interfaces\BlockRepository;
use App\Repositories\interfaces\ContactRepository;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public function __invoke(Request $request, ContactRepository $repo)
    {
        $data = $request->validate([
            'email' => ['required', 'email:rfc,dns,spoof'],
            'subject' => 'nullable|string|max:191',
            'message' => 'required|string',
            'name' => ['required', 'string'],
            'phone' => [
                'required',
                'string',
                'phone:AE,EG,SA,BH',
                'regex:/^([0-9+])+$/',
                'regex:/^[+]/',
            ],
        ]);
        $contact = $repo->store($data);
        return responseJson(
            new ContactResource($contact),
            __('Saved Successfully'),
        );
    }
}

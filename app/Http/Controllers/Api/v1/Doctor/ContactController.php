<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Http\Controllers\Controller;
use App\Http\Resources\Contact\ContactResource;
use App\Repositories\interfaces\BlockRepository;
use App\Repositories\interfaces\ContactRepository;
use Illuminate\Http\Request;

class ContactController extends Controller
{
    public $repo;

    public function __construct(ContactRepository $repo)
    {
        $this->repo = $repo;
    }

    public function send(Request $request)
    {
        $this->validate($request, [
            'name' => 'nullable|string|max:191',
            'email' => 'nullable|email|max:191',
            'subject' => 'nullable|string|max:191',
            'message' => 'nullable|string',
        ]);

        $contact = $this->repo->store($request->all());

        $contact = new ContactResource($contact);
        return responseJson(compact('contact'), __('Loaded Successfully'));
    }
}

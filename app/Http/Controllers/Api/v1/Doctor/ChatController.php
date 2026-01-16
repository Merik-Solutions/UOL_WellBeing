<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Criteria\IsActiveCriteria;
use App\Criteria\OfDoctorCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Chat\Doctor\MessageRequest;
use App\Http\Resources\Chat\ChatResource;
use App\Http\Resources\Chat\MessageResource;
use App\Models\Chat;
use App\Models\Message;
use App\Notifications\NewMessageSent;
use App\Repositories\interfaces\ChatRepository;
use App\Repositories\interfaces\MessageRepository;
use App\Repositories\interfaces\UserDoctorPackageRepository;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Carbon\Carbon;

class ChatController extends Controller
{
    public $repo;

    public function __construct(ChatRepository $repo)
    {
        $this->repo = $repo->pushCriteria(
            new OfDoctorCriteria(auth('doctor_api')->id()),
        );
    }

    public function index()
    {
        $chats = $this->repo->DoctorInbox()->paginate(10);

         Message::where('seen_at', null)
        ->update(['seen_at' => Carbon::now(), 'seen_by' => auth()->id()]);

        return responseJson(
            ChatResource::Collection($chats),
            __('Loaded Successfully'),
        );
    }

    public function show($chat_id)
    {
        try {
            $chat = $this->repo->with(['user', 'patient'])->find($chat_id);
        } catch (ModelNotFoundException $exception) {
            return responseJson(null, __('Chat Not Found '), 404);
        }

        // $messages = $chat->messages()->with('sender')->paginate(10);

        return responseJson(
            [
                'chat' => new ChatResource($chat),
                // 'messages' => MessageResource::collection($messages),
            ],
            __('Loaded Successfully'),
        );
    }

    public function addMessage(
        MessageRequest $request,
        MessageRepository $messageRepo,
    ) {
        $message = $messageRepo->create($request->validated());
        return responseJson(
            new MessageResource($message),
            __('Loaded Successfully'),
        );
    }

    public function addImage(Request $request)
    {
        $inputs = $request->validate([
            'chat_id' => 'required|integer|exists:chats,id',
            'image' =>
                'sometimes|required_if:message,==,null|mimes:png,jpg,pdf,txt,jpeg',
            'message' => 'sometimes|required_if:image,==,null|string',
        ]);

        $chat = Chat::find($request->chat_id);

        if ($request->image !== null) {
            $url = $chat
                ->addMedia($inputs['image'])
                ->toMediaCollection('files')
                ->getUrl();
            $request->message = $url;
        }
        auth()
            ->user()
            ->messages()
            ->create([
                'chat_id' => $request->chat_id,
                'message' => $request->message,
                'user_doctor_packages_id' => $this->getUserDoctorPackageId($request->chat_id),
            ]);
        return responseJson(
            ['url' => $request->message],
            __('Saved Successfully'),
        );
    }

    public function getUserDoctorPackageId($chat_id)
    {
        return app(UserDoctorPackageRepository::class)
            ->pushCriteria(IsActiveCriteria::class)
            ->ofChat($chat_id)
            ->first(['id'])->id;
    }
}

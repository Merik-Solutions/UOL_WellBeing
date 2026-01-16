<?php

namespace App\Http\Controllers\Api\v1\Patient;

use App\Criteria\IsActiveCriteria;
use App\Http\Controllers\Controller;
use App\Http\Middleware\ShouldHavePatientId;
use App\Http\Requests\Chat\Patient\ChatRequest;
use App\Http\Resources\Chat\ChatResource;
use App\Http\Resources\Chat\MessageResource;
use App\Models\Chat;
use App\Models\Patient;
use App\Repositories\interfaces\ChatRepository;
use App\Repositories\interfaces\MessageRepository;
use DB;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Message;
use App\Repositories\interfaces\UserDoctorPackageRepository;
use Illuminate\Support\Facades\Log;

class ChatController extends Controller
{
    public $repo;

    public function __construct(ChatRepository $repo)
    {
        $this->middleware(ShouldHavePatientId::class);
        $this->repo = $repo;
    }

    public function index(Request $request)
    {
        $chats = $this->repo->PatientInbox()->paginate(10);

        Message::where('seen_at', null)
        ->update(['seen_at' => Carbon::now(), 'seen_by' => auth()->id()]);
        return responseJson(
            ChatResource::collection($chats),
            __('Loaded Successfully')
        );
    }
    public function create(ChatRequest $request, MessageRepository $messageRepo)
    {
        DB::beginTransaction();
        $chat = auth()
            ->user()
            ->chat()
            ->firstOrcreate([
                'doctor_id' => $request->doctor_id,
                'patient_id' => $request->patient_id,
            ]);
        /*  $message = $request->validated();
         $message['chat_id'] = $chat->id;
         $messageRepo->create($message);
 */
        DB::commit();

        $chat = $this->repo
            ->select('*')
            ->with('doctor')
            ->WithAvailableToSend()
            ->find($chat->id);
        return responseJson(
            new ChatResource($chat->load('doctor')),
            __('Loaded Successfully'),
        );
    }

    public function show($chat_id)
    {
        try {
            $chat = $this->repo
                ->select('*')
                ->with('doctor')
                ->WithAvailableToSend()
                ->find($chat_id);
        } catch (ModelNotFoundException $exception) {
            return responseJson(null, __('Chat Not Found '), 404);
        }

        $messages = $chat
            ->messages()
            ->with('sender')
            ->paginate(10);

        return responseJson(
            [
                'chat' => new ChatResource($chat),
                'messages' => MessageResource::collection($messages),
            ],
            __('Loaded Successfully'),
        );
    }

    public function addImage(Request $request)
    {
        $inputs = $request->validate([
            'chat_id' => 'required|integer|exists:chats,id',
            // 'patient_id' => 'required|integer|exists:chats,id',
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
            
            $image_url = explode('.com',$url);
        
            $request->image = $image_url[0] . '.com/kindahealth/public/' . $image_url[1];
        }

        $patient=Patient::findOrFail($request->patient_id);
        auth()
            ->user()
            ->messages()
            ->create([
                'chat_id' => $request->chat_id,
                'message' => $request->message,
                'patient_id' => $request->patient_id,
                'user_doctor_packages_id' => $this->getUserDoctorPackageId($request->chat_id),
            ]);
        return responseJson(
            ['url' => $request->image],
            __('Saved Successfully'),
        );
    }

    public function checkingChat(Request $req){
        $chat = Chat::where('doctor_id', $req->doctor_id)->where('patient_id',$req->patient_id)->first();
        return responseJson(
            ['chat' => $chat],
            __('Latest patient package.'),
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

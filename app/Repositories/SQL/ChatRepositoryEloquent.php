<?php

namespace App\Repositories\SQL;

use App\Events\Chat\MessageSent;
use App\Models\Attachment;
use App\Models\Message;
use App\Repositories\interfaces\MessageRepository;
use App\Repositories\SQL\BaseRepository;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Repositories\interfaces\ChatRepository;
use App\Models\Chat;

// use App\Validators\ChatValidator;

/**
 * Class ChatRepositoryEloquent.
 *
 * @package namespace App\Repositories\SQL;
 */
class ChatRepositoryEloquent extends BaseRepository implements ChatRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Chat::class;
    }

    /**
     * Boot up the repository, pushing criteria
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    public function DoctorInbox()
    {
        return $this->model
            ->query()
            ->lastMessage()
            ->unreadCount()
            ->WithAvailableToSend()
            ->ofDoctor(auth()->id())
            ->with('user', 'patient');
    }

    public function PatientInbox()
    {
        return $this->query()
            ->select('*')
            ->lastMessage()
            ->unreadCount()
            ->WithAvailableToSend()
            ->ofPatient(request('patient_id'))
            ->with('doctor');
    }

    public function getSelectedOrFirst($chats, ?int $chat_id = null)
    {
        if ($chat_id) {
            $chat = $this->with([
                'patient',
                'messages' => function (Builder $message) {
                    $message->with('sender');
                },
                'doctor',
            ])
                ->find($chat_id)
                ->setRelation('doctor', auth()->user());
        } else {
            $chat = optional($chats->first())
                // ->load('messages')
                ->setRelation('doctor', auth()->user());
        }

        return $chat;
    }
}

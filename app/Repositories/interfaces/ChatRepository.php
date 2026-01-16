<?php

namespace App\Repositories\interfaces;

use App\Models\Message;
use App\Repositories\interfaces\BaseInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

/**
 * Interface ChatRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface ChatRepository extends BaseInterface
{
    public function DoctorInbox();

    public function PatientInbox();

    public function getSelectedOrFirst($chats, ?int $chat_id = null);
}

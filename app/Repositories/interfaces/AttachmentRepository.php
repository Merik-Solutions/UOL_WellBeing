<?php

namespace App\Repositories\interfaces;

use App\Models\Attachment;
use App\Repositories\interfaces\BaseInterface;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;

/**
 * Interface AttachmentRepository.
 *
 * @package namespace App\Repositories\interfaces;
 */
interface AttachmentRepository extends BaseInterface
{
    /**
     * @param Request $request
     * @return Attachment
     */
    public function store(Request $request): Attachment;

    /**
     * get doctor certifications
     * @param int $id
     * @return mixed
     */
    public function getDoctorCertifications(int $id);
}

<?php

namespace App\Http\Controllers\Api\v1\Doctor;

use App\Criteria\OfDoctorCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\Note\StoreNoteRequest;
use App\Http\Requests\Api\Note\UpdateNoteRequest;
use App\Http\Resources\Note\NoteResource;
use App\Models\Note;
use App\Repositories\interfaces\NoteRepository;

class NoteController extends Controller
{
    protected $repo;

    public function __construct(NoteRepository $repo)
    {
        $this->repo = $repo;
    }

    public function index(NoteRepository $repo)
    {
        $notes = $repo
            ->pushCriteria(new OfDoctorCriteria(auth()->id()))
            ->with(['patient'])
            ->paginate();
        return responseJson(
            NoteResource::collection($notes),
            __('Created Successfully'),
        );
    }

    public function store(StoreNoteRequest $request)
    {
        $note = $this->repo->create($request->validated());

        return responseJson(
            new NoteResource($note),
            __('Created Successfully'),
        );
    }

    public function update($note_id, UpdateNoteRequest $request)
    {
        $note = $this->repo->update($request->validated(), $note_id);

        return responseJson(
            new NoteResource($note),
            __('Updated Successfully'),
        );
    }

    public function destroy(Note $note)
    {
        $note->delete();
        return responseJson(null, __('Deleted Successfully'));
    }
}

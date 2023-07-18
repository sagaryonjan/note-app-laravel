<?php

namespace App\Http\Controllers\Api;

use App\Models\Note;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\NoteResource;
use App\Http\Requests\Note\StoreValidation;
use Symfony\Component\HttpFoundation\Response;

class NoteController extends Controller
{
    public function index()
    {
        $notes = Note::with('user')->get();

        return NoteResource::collection($notes);
    }

    public function store(StoreValidation $request)
    {
        $note = Note::create($request->validated());

        return response()->json(new NoteResource($note), Response::HTTP_CREATED);
    }

    public function show(Note $note)
    {
        return response()->json(new NoteResource($note), Response::HTTP_OK);
    }

    public function update(Note $note, Request $request)
    {
        $attributes = $request->only('subject', 'note');

        $note->update($attributes);

        return response()->json(new NoteResource($note), Response::HTTP_OK);
    }

    public function destroy(Note $note)
    {
        $note->delete();

        return response()->json(null, Response::HTTP_NO_CONTENT);
    }
}
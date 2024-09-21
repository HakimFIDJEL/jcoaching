<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


// Models
use App\Models\Media;

// Requests
use App\Http\Requests\admin\medias\MediaRequest;


class MediaController extends Controller
{
    public function index() {
        $medias = Media::all();
        return view('admin.medias.index')->with(['medias' => $medias]);
    }

    public function create() {
        return view('admin.medias.create');
    }

    public function edit(Media $media) {
        return view('admin.medias.edit')->with(['media' => $media]);
    }

    public function store(MediaRequest $request) {

        if ($request->hasFile('file')) {

            $data = $request->validated();
            $path = $request->file('file')->store('public/medias');

            Media::create([
                'label' => $data['label'],
                'path' => $path,
                'type' => $request->file('file')->getMimeType(),
                'size' => $request->file('file')->getSize(),
                'extension' => $request->file('file')->extension(),
                'online' => $data['online'],
            ]);

            return redirect()->route('admin.medias.index')->with('success', 'Le média a bien été enregistré');            
        }
        return redirect()->back()->withInput()->with('error', 'Une erreur est survenue lors de l\'enregistrement du média');
    }

    public function update(MediaRequest $request, Media $media) {
            
        $data = $request->validated();

        if ($request->hasFile('file')) {

            Storage::delete($media->path);

            $path = $request->file('file')->store('public/medias');
            $media->update([
                'label' => $data['label'],
                'path' => $path,
                'type' => $request->file('file')->getMimeType(),
                'size' => $request->file('file')->getSize(),
                'extension' => $request->file('file')->extension(),
                'online' => $data['online'],
            ]);

        } else {
            $media->update([
                'label' => $data['label'],
                'online' => $data['online'],
            ]);
        }

        return redirect()->route('admin.medias.index')->with('success', 'Le média a bien été modifié');
    }

    public function download(Media $media) {
        return Storage::download($media->path);
    }

    public function softDelete(Media $media) {
        $media->delete();
        return redirect()->route('admin.medias.index')->with('success', 'Le média a bien été mis à la corbeille');
    }

    public function restore(int $id) {
        $media = Media::withTrashed()->findOrFail($id);
        $media->restore();
        return redirect()->back()->with('success', 'Le média a bien été restauré');
    }

    public function delete(int $id) {
        $media = Media::withTrashed()->findOrFail($id);
        Storage::delete($media->path);
        $media->forceDelete();
        return redirect()->back()->with('success', 'Le média a bien été supprimé');
    }
}

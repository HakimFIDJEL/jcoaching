<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Feedback;

// Requests
use App\Http\Requests\admin\feedbacks\FeedbackRequest;

class FeedbackController extends Controller
{
    // INDEX
    public function index() {
        $feedbacks = Feedback::all();
        return view('admin.feedbacks.index')->with(['feedbacks' => $feedbacks]);
    }

    // CREATE
    public function create() {
        return view('admin.feedbacks.create');
    }

    // EDIT
    public function edit(Feedback $feedback) {
        return view('admin.feedbacks.edit')->with(['feedback' => $feedback]);
    }

    // STORE
    public function store(FeedbackRequest $request) {
        $data = $request->validated();

        Feedback::create($data);

        return redirect()->route('admin.feedbacks.index')->with('success', 'Le feedback a bien été créé');
    }

    // UPDATE
    public function update(FeedbackRequest $request, Feedback $feedback) {
        $data = $request->validated();

        $feedback->update($data);

        return redirect()->route('admin.feedbacks.index')->with('success', 'Le feedback a bien été modifié');
    }

    // SOFT DELETE
    public function softDelete(Feedback $feedback) {
        $feedback->delete();
        return redirect()->route('admin.feedbacks.index')->with('success', 'Le feedback a bien été mis à la corbeille');
    }

    // RESTORE
    public function restore(int $id) {
        $feedback = Feedback::withTrashed()->findOrFail($id);
        $feedback->restore();
        return redirect()->back()->with('success', 'Le feedback a bien été restauré');
    }

    // DELETE
    public function delete(int $id) {
        $feedback = Feedback::withTrashed()->findOrFail($id);
        $feedback->forceDelete();
        return redirect()->back()->with('success', 'Le feedback a bien été supprimé');
    }

    

}

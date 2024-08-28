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
    public function index()
    {
        $feedbacks = Feedback::where('deleted_at', null)->get();
        return view('admin.feedbacks.index')->with(['feedbacks' => $feedbacks]);
    }

    // CREATE
    public function create()
    {
        return view('admin.feedbacks.create');
    }

    // EDIT
    public function edit(Feedback $feedback)
    {
        return view('admin.feedbacks.edit')->with(['feedback' => $feedback]);
    }

    // STORE
    public function store(FeedbackRequest $request)
    {
        $data = $request->validated();

        Feedback::create($data);

        return redirect()->route('admin.feedbacks.index')->with('success', 'Le feedback a bien été créé');
    }

    // UPDATE
    public function update(FeedbackRequest $request, Feedback $feedback)
    {
        $data = $request->validated();

        $feedback->update($data);

        return redirect()->route('admin.feedbacks.index')->with('success', 'Le feedback a bien été modifié');
    }

    // SOFT DELETE
    public function softDelete(Feedback $feedback)
    {
        $feedback->softDelete();
        return redirect()->route('admin.feedbacks.index')->with('success', 'Le feedback a bien été mis à la corbeille');
    }

    // RESTORE
    public function restore(Feedback $feedback)
    {
        $feedback->restore();
        return redirect()->route('admin.feedbacks.index')->with('success', 'Le feedback a bien été restauré');
    }

    // DELETE
    public function delete(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('admin.feedbacks.index')->with('success', 'Le feedback a bien été supprimé');
    }

    

}

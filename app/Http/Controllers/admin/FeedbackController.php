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
    public function index()
    {
        $feedbacks = Feedback::where('deleted_at', null)->get();
        return view('admin.feedbacks.index')->with(['feedbacks' => $feedbacks]);
    }

    public function create()
    {
        return view('admin.feedbacks.create');
    }

    public function edit(Feedback $feedback)
    {
        return view('admin.feedbacks.edit')->with(['feedback' => $feedback]);
    }

    public function store(FeedbackRequest $request)
    {
        $data = $request->validated();

        if(!isset($data['online'])) {
            $data['online'] = false;
        } else {
            $data['online'] = true;
        }

        Feedback::create($data);

        return redirect()->route('admin.feedbacks.index')->with('success', 'Le feedback a bien été créé');
    }

    public function update(FeedbackRequest $request, Feedback $feedback)
    {
        $data = $request->validated();

        if(!isset($data['online'])) {
            $data['online'] = false;
        } else {
            $data['online'] = true;
        };

        $feedback->update($data);

        return redirect()->route('admin.feedbacks.index')->with('success', 'Le feedback a bien été modifié');
    }

    public function softDelete(Feedback $feedback)
    {
        $feedback->softDelete();
        return redirect()->route('admin.feedbacks.index')->with('success', 'Le feedback a bien été mis à la corbeille');
    }

    public function delete(Feedback $feedback)
    {
        $feedback->delete();
        return redirect()->route('admin.feedbacks.index')->with('success', 'Le feedback a bien été supprimé');
    }

}

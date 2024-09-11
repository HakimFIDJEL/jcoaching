<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

// Models
use App\Models\Faq;

// Requests
use App\Http\Requests\admin\faqs\FaqRequest;

class FaqController extends Controller
{
    public function index() {
        $faqs = Faq::all();
        return view('admin.faqs.index')->with(['faqs' => $faqs]);
    }

    public function create() {
        return view('admin.faqs.create');
    }

    public function edit(Faq $faq) {
        return view('admin.faqs.edit')->with(['faq' => $faq]);
    }

    public function store(FaqRequest $request) {
        $data = $request->validated();

        Faq::create($data);

        return redirect()->route('admin.faqs.index')->with(['success' => 'La FAQ a bien été créée']);
    }

    public function update(FaqRequest $request) {
        $data = $request->validated();

        $faq = Faq::find($request->faq);
        $faq->update($data);

        return redirect()->route('admin.faqs.index')->with(['success' => 'La FAQ a bien été modifiée']);
    }

    public function softDelete(Faq $faq) {
        $faq->delete();
        return redirect()->route('admin.faqs.index')->with(['success' => 'La FAQ a bien été mise à la corbeille']);
    }

    public function restore(int $id) {
        $faq = Faq::withTrashed()->findOrFail($id);
        $faq->restore();
        return redirect()->route('admin.faqs.index')->with(['success' => 'La FAQ a bien été restaurée']);
    }

    public function delete(int $id) {
        $faq = Faq::withTrashed()->findOrFail($id);
        $faq->forceDelete();
        return redirect()->route('admin.faqs.index')->with(['success' => 'La FAQ a bien été supprimée']);
    }
}

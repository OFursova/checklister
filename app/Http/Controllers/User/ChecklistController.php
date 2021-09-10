<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Checklist;
use App\Services\ChecklistService;
use Illuminate\View\View;

class ChecklistController extends Controller
{
    public function show(Checklist $checklist): View
    {
        (new ChecklistService())->sync_checklist($checklist, auth()->id());

        return view('users.checklists.show', compact('checklist'));
    }

    public function tasklist($list_type): View
    {
        return view('users.checklists.tasklist', compact('list_type'));
    }
}

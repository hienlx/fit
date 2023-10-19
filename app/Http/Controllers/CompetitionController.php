<?php

namespace App\Http\Controllers;

use App\Models\Competition;
use Illuminate\Http\Request;

class CompetitionController extends Controller
{
    public function index(Request $req)
    {
        // dd($req->all());
        $competitions = Competition::all();
        return view('competitions.index', compact('competitions'));
    }
    public function create(Request $req)
    {
        return view('competitions.create');
    }
    public function store(Request $req)
    {
        // dd($req->all());
        Competition::create($req->all());
        return redirect(route('competitions.index'))
            ->with('success', 'Create competition success');
    }
}

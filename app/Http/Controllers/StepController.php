<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Step;

class StepController extends Controller
{
    public function update(Idea $idea, Step $step)
    {
        // authorize
        $step->update(['completed' => ! $step->completed]);

        return back();
    }
}

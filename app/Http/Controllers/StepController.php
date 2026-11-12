<?php

declare(strict_types=1);

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Models\Step;
use Illuminate\Support\Facades\Gate;

class StepController extends Controller
{
    public function update(Idea $idea, Step $step)
    {
        Gate::authorize('workWith', $idea);

        $step->update(['completed' => ! $step->completed]);

        return back();
    }
}

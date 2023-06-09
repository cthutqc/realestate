<?php

namespace App\Http\Controllers;

use App\Actions\SetMetaAction;
use App\Models\Page;
use Illuminate\Http\Request;

class HomeController extends Controller
{
    /**
     * Handle the incoming request.
     */
    public function __invoke(SetMetaAction $action)
    {
        $page = Page::where('slug', '/')->firstOrFail();

        $action->handle($page);

        return view('home');
    }
}

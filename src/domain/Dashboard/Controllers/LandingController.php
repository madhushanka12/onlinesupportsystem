<?php

namespace Domain\Dashboard\Controllers;

use Illuminate\Routing\Controller;
use Illuminate\View\View;

class LandingController extends Controller
{
    public const INDEX_ROUTE = 'front.index';

    public function index(
    ): View
    {
        return view(self::INDEX_ROUTE);
    }

}

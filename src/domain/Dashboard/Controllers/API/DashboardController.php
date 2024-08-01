<?php

namespace Domain\Dashboard\Controllers\API;

use Support\Helper\Helper;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
class DashboardController extends Controller
{
    use Helper;

    public function index(): JsonResponse {
        return response()->json([
            'status' => true,
            'message' => 'Successfully fetched dashboard',
        ]);
    }
}

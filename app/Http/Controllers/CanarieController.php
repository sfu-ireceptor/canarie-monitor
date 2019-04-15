<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CanarieController extends Controller
{

    public function page($page)
    {
        $url = 'http://ireceptor.irmacs.sfu.ca/platform/' . $page;

        if ($page == 'factsheet') {
            $url = 'http://www.canarie.ca/software/platforms/ireceptor/';
        } elseif ($page == 'provenance' || $page == 'licence') {
            $url = 'http://ireceptor.irmacs.sfu.ca/platform/doc';
        }

        $data = [];
        $data['title'] = $page;
        $data['page'] = $page;
        $data['url'] = $url;

        return view('link', $data);
    }

    public function stats(Request $request, Response $response)
    {
		$resetDate = Carbon::createFromDate(2019,4,15);
		$resetDateIso8601 = $resetDate->toDateString() . 'T' . $resetDate->toTimeString() . 'Z';

		$usageCount = 6;

        $t = [];
        $t['usageCount'] = $usageCount;
        $t['lastReset'] = $resetDateIso8601;

        if ($request->wantsJson()) {
            return response()->json($t);
        } else {
            $t['name'] = 'Stats';
            $t['key'] = 'Usage count';
            $t['val'] = $usageCount;

            return view('stats', $t);
        }
    }
}

<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;
use GuzzleHttp\Psr7;
use GuzzleHttp\Exception\TransferException;

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
        $service_url = "https://ipa4.ireceptor.org/";

		$resetDate = Carbon::createFromDate(2019,4,15);
		$resetDateIso8601 = $resetDate->toDateString() . 'T' . $resetDate->toTimeString() . 'Z';

        $defaults = [];
        $defaults['verify'] = false;    // accept self-signed SSL certificates
        $defaults['base_uri'] = $service_url;
        $defaults['timeout'] = 2;
        $client = new \GuzzleHttp\Client($defaults);

        $sample_list = [];
        try {
            $response = $client->request('POST', 'v2/samples');
            $json = $response->getBody();
            $sample_list = json_decode($json, true);
        } catch (TransferException $e) {
            abort(503);
        }

        if($response->getStatusCode() != 200) {
            abort(503);
        }

		$usageCount = count($sample_list);

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

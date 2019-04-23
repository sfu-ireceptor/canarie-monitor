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

    public function info(Request $request, Response $response)
    {
        $t = [];

        $t['name'] = config('app.name');
        $t['category'] = config('app.category');
        $t['synopsis'] = config('app.synopsis');
        $t['version'] = config('app.version');
        $t['institution'] = config('app.institution');
        $t['release_time'] = config('app.release_time');
        $t['research_subject'] = config('app.research_subject');
        $t['support_email'] = config('app.support_email');
        $t['tags'] = config('app.tags');

        if ($request->wantsJson()) {
            // use required JSON field names
            $t2 = $t;

            $t2['releaseTime'] = $t['release_time'];
            unset($t2['release_time']);

            $t2['researchSubject'] = $t['research_subject'];
            unset($t2['research_subject']);

            $t2['supportEmail'] = $t['support_email'];
            unset($t2['support_email']);

            $t2['tags'] = ["immunology","iReceptor"];

            return response()->json($t2);
        } else {
            return view('info', $t);
        }
    }

    public function stats(Request $request, Response $response)
    {
        $resetDate = Carbon::createFromDate(2019,4,15);
        $resetDateIso8601 = $resetDate->toDateString() . 'T' . $resetDate->toTimeString() . 'Z';

        $service_url_list = config('app.service_urls');
        $usageCount = 0;

        foreach ($service_url_list as $service_url) {
            $defaults = [];
            $defaults['verify'] = false;    // accept self-signed SSL certificates
            $defaults['base_uri'] = $service_url;
            $defaults['timeout'] = 5 * 60;
            $client = new \GuzzleHttp\Client($defaults);

            try {
                $response = $client->request('POST', config('app.service_usage_url'));

                $status_code = $response->getStatusCode();
                if($status_code != 200) {
                    $reason = $response->getReasonPhrase();
                    Log::error('Unsuccessful HTTP response from ' . $service_url . config('app.service_usage_url').  ': ' . $status_code . ': ' . $reason);
                    abort(503, 'Request to ' . $service_url . config('app.service_usage_url') . ' failed.');
                }

                $json = $response->getBody();
                $l = json_decode($json, true);
                $usageCount += count($l);
            } catch (TransferException $e) {
                Log::error('Unsuccessful request to ' . $service_url . config('app.service_usage_url'));
                abort(503, 'Request to ' . $service_url . config('app.service_usage_url') . ' failed.');
            }
        }

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

    public function page($page)
    {
        $url = config('app.' . $page);

        if($url == '') {
            abort(404);
        }

        $data = [];
        $data['title'] = $page;
        $data['page'] = $page;
        $data['url'] = $url;

        return view('link', $data);
    }
}

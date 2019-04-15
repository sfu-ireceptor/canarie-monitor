<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Log;

class CanarieController extends Controller
{

    public function linkPage($page)
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
}

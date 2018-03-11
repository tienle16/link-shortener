<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ShortenController extends Controller
{
    public function index()
    {
        return view('shorten');
    }

    public function shorten(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);
        $url = $request->get('url');

        if ( ! $this->checkUrlExists($url)) {
            return redirect()->route('clgt')->withErrors('Error');
        }
        return redirect()->route('clgt')->withFlashSuccess('Submit ok');
    }

    public function checkUrlExists($url)
    {
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_NOBODY, true);
        curl_setopt($ch,  CURLOPT_RETURNTRANSFER, true);
        curl_exec($ch);
        $response = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        return (!empty($response) && $response != 404);
    }
}

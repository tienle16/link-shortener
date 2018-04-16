<?php

namespace App\Http\Controllers;

use App\Shorten;
use Illuminate\Http\Request;

class ShortenController extends Controller
{
    /**
     * ShortenController constructor.
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     *  Homepage & show list short url
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        $shortUrls = Shorten::where(['user_id' => auth()->id()])->get(['full_url', 'short_code', 'counter', 'created_at']);

        return view('shorten')->with(['shortUrls' => $shortUrls]);
    }

    /**
     *  Shorten url
     * @param Request $request
     * @return $this
     */
    public function shorten(Request $request)
    {
        $request->validate([
            'url' => 'required|url'
        ]);
        $url     = $request->get('url');
        $urlInDB = $this->getUrlInDB($url);

        if ( ! $this->checkUrlExists($url)) {
            return redirect()->route('clgt')->withErrors('The url does not exist. Please try again');
        }

        if ($urlInDB) {
            $shortUrl = $request->getHost() . '/' . $urlInDB->short_code;

            return redirect()->route('clgt')->with([
                'flash_success' => 'The url already exist in database',
                'urlExist'      => $shortUrl
            ]);
        }

        $shortCode = $this->generateShortCode(auth()->id());
        $shorten   = Shorten::create(['user_id' => auth()->id(), 'short_code' => $shortCode, 'full_url' => $url]);

        if ($shorten) {
            return redirect()->route('clgt')->withFlashSuccess('The short url has been created successfully');
        }

        return redirect()->route('clgt')->withErrors('There was an error when trying to create short url. Please try again');
    }

    /**
     *  Check url working on internet
     * @param $url
     * @return bool
     */
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

    /**
     *  Generate short code
     * @param $userId
     * @return string
     */
    public function generateShortCode($userId)
    {
        $code = str_random(6);

        do {
            $shortCode = Shorten::where([['short_code', '=', $code], ['user_id', '=', $userId]])->get(['id']);

            if ($shortCode->isNotEmpty()) {
                $code = str_random(6);
            }

        } while ($shortCode->isNotEmpty());

        return $code;
    }

    /**
     *  Get url in db by user id logged
     * @param $url
     * @return bool
     */
    public function getUrlInDB($url)
    {
        $url = Shorten::where([['full_url', '=', $url], ['user_id', '=', auth()->id()]])->select(['full_url', 'short_code'])->first();

        if ($url) {
            return $url;
        }

        return false;
    }
}

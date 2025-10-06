<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Session;
use Symfony\Component\HttpFoundation\Response;

class SetLocale
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $availableLocales = ['fr', 'en', 'wo'];
        $defaultLocale = 'fr';

        if ($request->has('lang') && in_array($request->get('lang'), $availableLocales)) {
            $locale = $request->get('lang');
            Session::put('locale', $locale);
        } else {
            $locale = Session::get('locale', $defaultLocale);
        }

        if (! in_array($locale, $availableLocales)) {
            $locale = $defaultLocale;
        }

        App::setLocale($locale);

        return $next($request);
    }
}

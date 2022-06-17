<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\File;

class LangMiddlware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
     * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
     */
    public function handle(Request $request, Closure $next)
    {
        if ($lang = $request->session()->get('lang')) {
            App::setLocale($request->session()->get('lang'));
        }

        View::share(
            'translation',
            collect(File::allFiles(resource_path('lang/' . App::getLocale())))
                ->flatMap(
                    function ($file) {
                        return [
                            ($translation = $file->getBasename('.php')) => trans($translation),
                        ];
                    }
                )->toJson()
        );
        
        return $next($request);
    }
}

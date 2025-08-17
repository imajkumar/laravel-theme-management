<?php namespace Ayra\Theme\Middleware;

use Closure;
use Illuminate\Http\Request;
use Ayra\Theme\Facades\Theme;

class ThemePreview
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next)
    {
        // Check if theme preview is requested via query parameter
        if ($request->has('theme')) {
            $theme = $request->get('theme');
            
            // Validate theme exists
            if (Theme::exists($theme)) {
                // Set theme for this request only (don't persist)
                Theme::switch($theme, false);
                
                // Add theme info to response headers for debugging
                $response = $next($request);
                $response->headers->set('X-Theme-Preview', $theme);
                
                return $response;
            }
        }

        // Check if layout preview is requested
        if ($request->has('layout')) {
            $layout = $request->get('layout');
            Theme::layout($layout);
            
            $response = $next($request);
            $response->headers->set('X-Layout-Preview', $layout);
            
            return $response;
        }

        return $next($request);
    }
}

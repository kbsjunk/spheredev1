<?php

namespace Sphere\Http\Middleware;

use Closure;

use File;

class VerifyMailgun
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {

      if ($request->has('sample')) {
        $sample = json_decode(File::get(storage_path('mail/sample.json')), true);
        $sample['Message-Id'] = md5(time()).'@sphere.loc';
        $request->merge($sample);
        return $next($request);
      }
      
      if($this->verify(config('services.mailgun.secret'), $request->token, $request->timestamp, $request->signature)) {
        return $next($request);
      }
      
      abort(406);
      
    }
  
    private function verify($apiKey, $token, $timestamp, $signature)
    {
        //check if the timestamp is fresh
        if (time()-$timestamp>15) {
            return false;
        }

        //returns true if signature is valid
        return hash_hmac('sha256', $timestamp.$token, $apiKey) === $signature;
    }
}

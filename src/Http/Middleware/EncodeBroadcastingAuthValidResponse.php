<?php

namespace Mediumart\Echoio\Http\Middleware;

use Closure;
use Firebase\JWT\JWT;
use Illuminate\Contracts\Config\Repository as Config;

class EncodeBroadcastingAuthValidResponse
{
    /**
     * @var Config
     */
    protected $config;

    /**
     * Create a new middleware instance.
     * 
     * @param Config $config
     */
    public function __construct(Config $config)
    {
        $this->config = $config;
    }

    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * 
     * @return mixed
     */
    public function handle($request, Closure $next)
    {   
        return tap($next($request), function($response) use ($request) {
            if ($response->status() === 200) {
                $content = $this->merge(
                    $this->content($response), ['channel_name' => $request->channel_name]
                );

                $response->setContent($this->encode($content));
            }
        });
    }

    /**
     * Merge content with channel name array.
     * 
     * @param  $content    
     * @param  array  $channelName
     * 
     * @return array             
     */
    protected function merge($content, array $channelName)
    {
        if (is_bool($content)) {
            return $channelName;
        } 

        return array_merge((array) $content, $channelName);
    }

    /**
     * Get decoded response content.
     * 
     * @param  \Illuminate\Http\Response $response
     * 
     * @return array          
     */
    protected function content($response)
    {
        return json_decode($response->content(), true);
    }

    /**
     * HS256 JWT encode the given response content.
     * 
     * @param  array  $content
     * 
     * @return string       
     */
    protected function encode(array $content) 
    {
        return JWT::encode($content, $this->config->get('services.broadcast.key'));     
    }
}
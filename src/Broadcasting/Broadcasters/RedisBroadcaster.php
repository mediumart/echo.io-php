<?php 

namespace Mediumart\Echoio\Broadcasting\Broadcasters;

use Firebase\JWT\JWT;
use Illuminate\Contracts\Redis\Factory as Redis;
use Illuminate\Broadcasting\Broadcasters\RedisBroadcaster as Broadcaster;

class RedisBroadcaster extends Broadcaster
{
    /**
     * Secret key.
     * 
     * @var string
     */
    protected $key;

    /**
     * Create a new broadcaster instance.
     *
     * @param  \Illuminate\Contracts\Redis\Factory  $redis
     * @param  string  $connection
     * @return void
     */
    public function __construct(Redis $redis, $connection = null)
    {
        $this->redis = $redis;
        $this->key = $connection['key'];
        $this->connection = $connection['connection'];
    }

    /**
     * Return the valid authentication response.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  mixed  $result
     * @return mixed
     */
    public function validAuthenticationResponse($request, $result)
    {
        if (is_bool($result)) {
            return $this->tokenizeAuthenticationResponse([
                'channel_name' => $request->channel_name
            ]);
        }

        return $this->tokenizeAuthenticationResponse([
            'channel_name' => $request->channel_name,
            'channel_data' => [
                'user_id' => $request->user()->getAuthIdentifier(),
                'user_info' => $result,
            ]
        ]);
    }

    /**
     * HS256 JWT encode the given response.
     * 
     * @param  array  $response
     * @return string       
     */
    protected function tokenizeAuthenticationResponse($response)
    {
        return JWT::encode($response, $this->key);
    }
}

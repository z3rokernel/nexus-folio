<?php

namespace App\Filters;

use CodeIgniter\Filters\FilterInterface;
use CodeIgniter\HTTP\RequestInterface;
use CodeIgniter\HTTP\ResponseInterface;

/**
 * Cache-based rate limiter for POST /contact (5 requests per 60 seconds per IP).
 */
class ThrottleFilter implements FilterInterface
{
    public function before(RequestInterface $request, $arguments = null)
    {
        $limit  = isset($arguments[0]) ? (int) $arguments[0] : 5;
        $window = isset($arguments[1]) ? (int) $arguments[1] : 60;

        $ip  = $request->getIPAddress() ?: '127.0.0.1';
        $key = 'throttle_' . md5($ip);

        $cache = \Config\Services::cache();
        $hits  = (int) ($cache->get($key) ?? 0);

        if ($hits >= $limit) {
            return service('response')
                ->setStatusCode(429)
                ->setContentType('application/json')
                ->setJSON([
                    'status'  => 'error',
                    'code'    => 429,
                    'message' => 'RATE LIMIT EXCEEDED // Maximum 5 transmissions per minute. Please stand by.',
                ]);
        }

        $cache->save($key, $hits + 1, $window);

        return null;
    }

    public function after(RequestInterface $request, ResponseInterface $response, $arguments = null)
    {
    }
}

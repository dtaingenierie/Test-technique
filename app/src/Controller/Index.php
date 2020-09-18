<?php

namespace App\Controller;

use Symfony\Component\HttpFoundation\Response;

class Index
{
    public function form(): Response
    {
        return new Response(
            '<html><body>Test</body></html>'
        );
    }
}
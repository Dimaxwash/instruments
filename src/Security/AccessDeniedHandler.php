<?php

namespace App\Security;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;
use Symfony\Component\Security\Http\Authorization\AccessDeniedHandlerInterface;

class AccessDeniedHandler implements AccessDeniedHandlerInterface
{
    public function handle(Request $request, AccessDeniedException $accessDeniedException)
    {
        // ...
        $content = "<h2>Accès refusé</h2>
        <p><a href='/login' class='btn btn-primary'>Retour login</a></p>";
        return new Response($content, Response::HTTP_OK,
            ['content-type' => 'text/html']);
    }
}
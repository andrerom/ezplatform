<?php

namespace AppBundle\Controller;

use Symfony\Component\HttpFoundation\Response;
use eZ\Bundle\EzPublishCoreBundle\Controller;

class OauthController extends Controller
{
    public function action(string $slug)
    {
        $languages = implode(' ,', $this->getConfigResolver()->getParameter('languages'));


        return new Response(
            "<p>Url: {$slug}, Languages: {$languages}</p>"
        );


    }
}
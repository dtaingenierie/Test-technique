<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class SuccessController extends AbstractController
{

    public function success()
    {
        return $this->render('success/success.html.twig');
    }
}
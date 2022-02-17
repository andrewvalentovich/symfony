<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BundleCheckController extends AbstractController
{
    /**
     * @Route('/bundle/check', name: 'app_bundle_check')
     */

    public function index(): Response
    {
        return $this->render('bundle_check/index.html.twig', [
            'controller_name' => 'BundleCheckController',
        ]);
    }
}

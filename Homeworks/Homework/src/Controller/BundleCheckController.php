<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class BundleCheckController extends AbstractController
{
    /**
     * @Route("/bundle/check", name="app_bundle_check")
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */


    public function index()
    {
        return $this->render('bundle_check/index.html.twig', [
            'controller_name' => 'BundleCheckController',
        ]);
    }
}

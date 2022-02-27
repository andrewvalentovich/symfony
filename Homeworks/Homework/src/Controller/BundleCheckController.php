<?php

namespace App\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use SymfonySkillbox\HomeworkBundle\UnitFactory;

class BundleCheckController extends AbstractController
{
    /**
     * @var UnitFactory
     */
    private $factory;

    public function __construct(UnitFactory $factory)
    {
        $this->factory = $factory;
    }


    /**
     * @Route("/bundle/check", name="app_bundle_check")
     * @IsGranted("ROLE_ADMIN")
     * @return Response
     */


    public function index()
    {
        $this->factory->produceUnits(252);

        return $this->render('bundle_check/index.html.twig', [
            'controller_name' => 'BundleCheckController',
        ]);
    }
}

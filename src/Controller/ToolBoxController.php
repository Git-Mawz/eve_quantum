<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

/**
 * @Route("/toolbox", name="toolbox_")
 */
class ToolBoxController extends AbstractController
{
    /**
     * @Route("/clipboard", name="clipboard")
     */
    public function index()
    {
        return $this->render('toolbox/index.html.twig', [
            'controller_name' => 'ToolBoxController',
        ]);
    }
}

<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StartController extends AbstractController
{
    /**
     * @Route("/start", name="start")
     */
    public function number()
    {
        $jsonData = file_get_contents('bible-json/French_Parole_de_Vie.json');
        $jsonData = str_replace("\xEF\xBB\xBF", '', $jsonData);
        dd(json_decode($jsonData, true));
    }
}

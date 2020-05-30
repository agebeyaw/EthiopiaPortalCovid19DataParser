<?php


namespace App\Controller;


use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;

class DefaultController extends AbstractController
{

    public function index()
    {
        return JsonResponse::create([
            'version' => '1.0'
        ]);
    }

}

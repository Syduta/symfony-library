<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AdminHomeController extends AbstractController
{
    /**
     * @Route("/admin",name="admin-home")
     */

    public function home(){
        return $this->render('admin/home.html.twig');
//        dd("coucou");
    }
}
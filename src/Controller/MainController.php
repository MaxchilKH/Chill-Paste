<?php
/**
 * Created by PhpStorm.
 * User: maxchil
 * Date: 2/15/18
 * Time: 1:28 PM
 */

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Response;

class MainController extends Controller
{
    public function homepage(){

        return $this->render('homepage.html.twig');
    }

    public function dashboard(){
        $this->denyAccessUnlessGranted('IS_AUTHENTICATED_REMEMBERED');


        return $this->render('Dashboard/dashboard.html.twig');
    }
}
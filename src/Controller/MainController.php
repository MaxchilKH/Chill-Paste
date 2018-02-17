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

        return new Response("Witam!");
    }
}
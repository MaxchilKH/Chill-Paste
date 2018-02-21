<?php
/**
 * Created by PhpStorm.
 * User: maxchil
 * Date: 2/16/18
 * Time: 12:05 PM
 */

namespace App\Controller;

use App\Entity\PastebinUser;
use App\Form\SignInForm;
use App\Form\SignUpForm;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

class AuthenticationController extends Controller
{
    public function signUpAction(Request $request, UserPasswordEncoderInterface $encoder){
        if ($this->isGranted('IS_AUTHENTICATED_FULLY', $this->getUser()))
            return $this->redirectToRoute('homepage');

        $form = $this->createForm(SignUpForm::class);
        $form->add('Register', SubmitType::class);

        $form->handleRequest($request);

        if($form->isSubmitted() && $form->isValid()){
            $user = $form->getData();
            $em = $this->getDoctrine()->getManager();

            $user->setHash($encoder->encodePassword($user, $user->getPlainPassword()));

            $em->persist($user);
            $em->flush();

            return $this->redirectToRoute('homepage');
        }

        return $this->render('formdisplay.html.twig', array(
            'form_template' => 'Forms/signupform.html.twig',
            'form' => $form->createView()
        ));
    }

    public function signInAction(Request $request)
    {
        if ($this->isGranted('IS_AUTHENTICATED_FULLY', $this->getUser()))
            return $this->redirectToRoute('homepage');

        $form = $this->createForm(SignInForm::class);
        $form->add('Login', SubmitType::class);

        //Security takes over at this point

        return $this->render('formdisplay.html.twig', array(
            'form_template' => 'Forms/signinform.html.twig',
            'form' => $form->createView()
        ));
    }

    public function recoverAccountAction(Request $request){
        $form = $this->createForm(SignUpForm::class);

        return $this->render('formdisplay.html.twig', array(
            'form_template' => 'Forms/signupform.html.twig',
            'form' => $form->createView()
        ));
    }

}
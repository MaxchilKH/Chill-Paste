<?php
/**
 * Created by PhpStorm.
 * User: maxchil
 * Date: 2/17/18
 * Time: 10:28 PM
 */

namespace App\Controller;


use App\Entity\Paste;
use App\Form\PasteForm;
use Doctrine\DBAL\ConnectionException;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class PastebinController extends Controller
{
    public function createPasteAction(Request $request){
        $paste = new Paste();
        $form = $this->createForm(PasteForm::class, $paste, array(
            'supported_languages' => $this->container->getParameter('supported_languages')
        ));
        $form->add('Submit', SubmitType::class);

        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()){
            $time_now = new \DateTime('now');
            $em = $this->getDoctrine()->getManager();

            $paste->setEditDate($time_now);
            $paste->setAuthor($this->getUser());

            $filename = sha1("paste".$time_now->getTimestamp());
            $paste->setFilename($filename);

            file_put_contents($this->getPasteDir().$filename, $paste->getContent());

            $em->persist($paste);
            $em->flush();

            return $this->redirectToRoute('display', array('paste_name' => $filename));
        }

        return $this->render('formdisplay.html.twig', array(
            'form_template' => 'Forms/pasteform.html.twig',
            'form' => $form->createView()
        ));
    }

    public function displayPasteAction(Request $request, $paste_name){

        $paste = $this->getDoctrine()->getRepository(Paste::class)
            ->findOneBy(array( 'file_name' => $paste_name));

        $paste->setContent(file_get_contents($this->getPasteDir().$paste_name));

        return $this->render('pastedisplay.html.twig', array(
            'paste' => $paste
        ));
    }

    private function getPasteDir(){
        return $this->container->getParameter('pastes_dir') . "/";
    }

    //************** AJAX CONTROLLER *****************//

    public function getUserPastes(Request $request){
        if ($this->getUser()){
            $pastes = $this->getDoctrine()->getRepository(Paste::class)
                ->findBy(array('author' => $this->getUser()));

            return $this->render('Dashboard/pastelist.html.twig', array(
                'pastes' => $pastes
            ));
        }
        return new Response();
    }

    //TODO: AJAX action for adding to favourite, deleting from fav, editing, and deleting paste
}
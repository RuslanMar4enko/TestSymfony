<?php

namespace AppBundle\Controller;

use AppBundle\Form\UserType;
use Doctrine\DBAL\Schema\Table;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Form\PropertieType;
use AppBundle\Entity\Propertie;
use AppBundle\Entity\User;


class PropertiesController extends FOSRestController
{

    /**
     * @return array
     */
    public function indexAction(Request $request)
    {
        $token = $request->headers->get('X-AUTH-TOKEN');
        $user_id = $request->headers->get ('X-USER-ID');
        $em = $this->getDoctrine()->getManager();
        $reposytory = $em->getRepository('AppBundle:User');
        $user = $reposytory->findOneBy(['token'=>$token, 'user_id'=>$user_id]);

        if($user){
            $properties = $this->getDoctrine()->getRepository('AppBundle:Propertie')->findAll();
            if ($properties === null) {
                return ['message' => 'there are no Propertie exist'];
            }
            return ['data' => $properties];
        }else{

            return new View(["message" => "Mismatches of the token or the user's private key"], Response::HTTP_NOT_ACCEPTABLE);
        }


    }


    public function showAction($id, Request $request)
    {
        $token = $request->headers->get('X-AUTH-TOKEN');
        $user_id = $request->headers->get ('X-USER-ID');
        $em = $this->getDoctrine()->getManager();
        $reposytory = $em->getRepository('AppBundle:User');
        $user = $reposytory->findOneBy(['token'=>$token, 'user_id'=>$user_id]);

        if($user){
            $properties = $this->getDoctrine()->getRepository('AppBundle:Propertie')->find($id);
            if ($properties === null) {
                return ['message' => ' Propertie not found'];
            }
            return ['data' => $properties];
        }else{
            return new View(["message" => "Mismatches of the token or the user's private key"], Response::HTTP_NOT_ACCEPTABLE);
        }


    }


    public function createAction(Request $request)
    {

        $token = $request->headers->get('X-AUTH-TOKEN');
        $user_id = $request->headers->get ('X-USER-ID');
        $em = $this->getDoctrine()->getManager();
        $reposytory = $em->getRepository('AppBundle:User');
        $user = $reposytory->findOneBy(['token'=>$token, 'user_id'=>$user_id]);

        if($user){
            $body = $request->request->all();
            $properties = new Propertie();
            $form = $this->createForm(PropertieType::class, $properties, [
                'csrf_protection' => false,
            ]);
            $form->submit($body);

            $em = $this->getDoctrine()->getManager();
            $em->persist($properties);
            $em->flush();

            return ['data' => $properties];
        }else{
            return new View(["message" => "Mismatches of the token or the user's private key"], Response::HTTP_NOT_ACCEPTABLE);
        }


    }


    public function updateAction($id, Request $request)
    {
        $token = $request->headers->get('X-AUTH-TOKEN');
        $user_id = $request->headers->get ('X-USER-ID');
        $em = $this->getDoctrine()->getManager();
        $reposytory = $em->getRepository('AppBundle:User');
        $user = $reposytory->findOneBy(['token'=>$token, 'user_id'=>$user_id]);
        if($user){
            $body = $request->request->all();
            $properties = $this->getDoctrine()->getRepository('AppBundle:Propertie')->find($id);
            if ($properties) {
                $form = $this->createForm(PropertieType::class, $properties, [
                    'csrf_protection' => false,
                ]);
                $form->submit($body);
                $em = $this->getDoctrine()->getManager();
                $em->persist($properties);
                $em->flush();
                return new View(["message" => "Propertie Updated Successfully"], Response::HTTP_OK);
            } else {
                return new View(["message" => "Properties  cannot be empty"], Response::HTTP_NOT_ACCEPTABLE);
            }
        }else{
            return new View(["message" => "Mismatches of the token or the user's private key"], Response::HTTP_NOT_ACCEPTABLE);
        }

    }


    public function deleteAction($id, Request $request)
    {
        $token = $request->headers->get('X-AUTH-TOKEN');
        $user_id = $request->headers->get ('X-USER-ID');
        $em = $this->getDoctrine()->getManager();
        $reposytory = $em->getRepository('AppBundle:User');
        $user = $reposytory->findOneBy(['token'=>$token, 'user_id'=>$user_id]);
        if($user){
            $sn = $this->getDoctrine()->getManager();
            $properties = $this->getDoctrine()->getRepository('AppBundle:Propertie')->find($id);
            if (!$properties) {
                return new View("property not found", Response::HTTP_NOT_FOUND);
            } else {
                $sn->remove($properties);
                $sn->flush();
            }
            return new View("deleted successfully", Response::HTTP_OK);
        }else{
            return new View(["message" => "Mismatches of the token or the user's private key"], Response::HTTP_NOT_ACCEPTABLE);
        }
    }





}
<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Form\PropertieType;
use AppBundle\Entity\Propertie;


class PropertiesController extends FOSRestController
{

    public function indexAction()
    {
        $properties = $this->getDoctrine()->getRepository('AppBundle:Propertie')->findAll();
        if ($properties === null) {
            return ['message' => 'there are no Propertie exist'];
        }
        return ['data' => $properties];
    }


    public function showAction($id)
    {
        $properties = $this->getDoctrine()->getRepository('AppBundle:Propertie')->find($id);
        if ($properties === null) {
            return ['message' => ' Propertie not found'];
        }
        return ['data' => $properties];
    }


    public function createAction(Request $request)
    {

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
    }


    public function updateAction($id, Request $request)
    {
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
    }


    public function deleteAction($id)
    {
        $sn = $this->getDoctrine()->getManager();
        $properties = $this->getDoctrine()->getRepository('AppBundle:Propertie')->find($id);
        if (!$properties) {
            return new View("user not found", Response::HTTP_NOT_FOUND);
        } else {
            $sn->remove($properties);
            $sn->flush();
        }
        return new View("deleted successfully", Response::HTTP_OK);
    }

}
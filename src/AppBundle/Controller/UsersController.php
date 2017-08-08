<?php

namespace AppBundle\Controller;

use Sensio\Bundle\FrameworkExtraBundle\Configuration\Route;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use FOS\RestBundle\View\View;
use AppBundle\Form\UserType;
use AppBundle\Entity\User;


class UsersController extends FOSRestController
{
    /**
     * @param Request $request
     * @return \Symfony\Component\Form\Form
     *
     */

    public function registerAction(Request $request)
    {

        $data = $request->request->all();
        $user = new User();
        $form = $this->createForm(UserType::class, $user, [
            'csrf_protection' => false,
        ]);
        $data['token'] = bin2hex(random_bytes(100));
        $data['user_id'] = md5(uniqid(rand(), true));
        $form->submit($data);
        if (!$form->isValid()) {
            $errors = $this->getErrorMessages($form);
            $data = array(
                'type' => 'validation_error',
                'title' => 'There was a validation error',
                'errors' => $errors
            );

            return $data;
        }
        $em = $this->getDoctrine()->getManager();

        $em->persist($user);
        $em->flush();


        return ['data' => ['token' =>$user->getToken(),'user_id' => $user->getUserId()]];
    }

    public function oauthAction(Request $request)
    {
        $email = $request->get('email');
        $password = $request->get('password');

        $em = $this->getDoctrine()->getManager();
        $reposytory = $em->getRepository('AppBundle:User');
        $user = $reposytory->findOneBy(['email'=>$email, 'password'=>$password]);

        if($user){
            return ['data' => ['token' =>$user->getToken(),'user_id' => $user->getUserId()]];
        }else{
            return (['message'=> 'User does not exist']);
        }
    }

    private function getErrorMessages(\Symfony\Component\Form\Form $form)
    {
        $errors = array();

        foreach ($form->getErrors() as $key => $error) {
            if ($form->isRoot()) {
                $errors['#'][] = $error->getMessage();
            } else {
                $errors[] = $error->getMessage();
            }
        }

        foreach ($form->all() as $child) {
            if (!$child->isValid()) {
                $errors[$child->getName()] = $this->getErrorMessages($child);
            }
        }

        return $errors;
    }


}
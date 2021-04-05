<?php

namespace App\Controller\User;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\User\User;
use Symfony\Component\HttpFoundation\JsonResponse;

class UserController extends AbstractController
{
    /**
     * @Route("/users", name="user_list", methods={"GET"})
     */
    public function list()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findBy([],['name' => 'ASC']);

        return $this->render("user/user_list.html.twig", [
            'users' => $users
        ]);
        // return $this->json($users);
    }

    /**
     * @Route("/users", name="user_new", methods={"POST"})
     */
    public function createUser(Request $request)
    {
        $submittedToken = $request->request->get('token');
        if (!$this->isCsrfTokenValid('create-user', $submittedToken)) {
            throw new \Exception("Requisição invalida");
        }

        $userName = $request->request->get('user_name');
        
        $em = $this->getDoctrine()->getManager();

        $user = new User();
        $user->setName($userName);

        $em->persist($user);
        $em->flush($user);

        return $this->redirectToRoute('user_list');
        // return $this->json($user);
    }

    /**
     * @Route("/users/{id}", name="user_edit", methods={"POST,PUT"})
     */
    public function editUser(int $id, Request $request)
    {
        $userName = $request->request->get('user_name');

        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy($id);
        $user->setName($userName);
        $em->flush($user);

        return $this->render("user/user_show.html.twig", [
            'user' => $user
        ]);
        // return $this->json($user);
    }

    /**
     * @Route("/users/{id}", name="user_show", methods={"GET"})
     */
    public function showUser(int $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $user = $em->getRepository(User::class)->findOneBy($id);

        return $this->render("user/user_show.html.twig", [
            'user' => $user
        ]);
        // return $this->json($user);
    }
}
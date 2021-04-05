<?php

namespace App\Controller\Inventory;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Inventory\Item;
use App\Entity\User\User;

class ItemMovementController extends AbstractController
{
    /**
     * @Route("/item/movement", name="item_movement", methods={"GET"})
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();
        $items = $em->getRepository(Item::class)->findAll();

        return $this->render('inventory/item_movement.html.twig', [
            'users' => $users,
            'items' => $items,
        ]);
    }

    /**
     * @Route("/item/movement", name="item_movement_save", methods={"POST"})
     */
    public function saveMovement(Request $request)
    {
        $submittedToken = $request->request->get('token');
        if (!$this->isCsrfTokenValid('item-movement', $submittedToken)) {
            throw new \Exception("Requisição invalida");
        }

        $userId = $request->request->get('user_select');
        $itemId = $request->request->get('item_select');

        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository(Item::class)->findOneById($itemId);
        $user = $em->getRepository(User::class)->findOneById($userId);

        $item->setUser($user);
        $em->flush();

        return $this->redirectToRoute('item_list');
    }
}
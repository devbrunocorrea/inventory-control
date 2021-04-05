<?php

namespace App\Controller\Inventory;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Inventory\Item;

class ItemController extends AbstractController
{
    /**
     * @Route("/items", name="item_list", methods={"GET"})
     */
    public function list()
    {
        $em = $this->getDoctrine()->getManager();
        $items = $em->getRepository(Item::class)->findBy([],['name' => 'ASC']);

        return $this->render("inventory/item_list.html.twig", [
            'items' => $items
        ]);
    }

    /**
     * @Route("/items", name="item_new", methods={"POST"})
     */
    public function createItem(Request $request)
    {
        $submittedToken = $request->request->get('token');
        if (!$this->isCsrfTokenValid('create-item', $submittedToken)) {
            throw new \Exception("Requisição invalida");
        }

        $itemName = $request->request->get('item_name');
        $itemDescription = $request->request->get('item_description');

        $em = $this->getDoctrine()->getManager();

        $item = new Item();
        $item->setName($itemName);
        $item->setDescription($itemDescription);

        $em->persist($item);
        $em->flush($item);

        return $this->redirectToRoute('item_list');
    }

    /**
     * @Route("/items/{id}", name="item_edit", methods={"POST,PUT"})
     */
    public function editItem(int $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository(Item::class)->findOneBy($id);

        $itemName = $request->request->get('item_name');
        $itemDescription = $request->request->get('item_description');

        $item->setName($itemName);
        $item->setDescription($itemDescription);

        $em->persist($item);
        $em->flush($item);

        return $this->redirectToRoute('item_list');
    }

    /**
     * @Route("/items/{id}", name="item_show", methods={"GET"})
     */
    public function showItem(int $id, Request $request)
    {
        $em = $this->getDoctrine()->getManager();
        $item = $em->getRepository(Item::class)->findOneBy($id);

        return $this->render("inventory/item_list.html.twig", [
            'item' => $item
        ]);
    }
}
<?php

namespace App\Controller\Inventory;

use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use App\Entity\Inventory\Item;
use App\Entity\User\User;

class ItemReportController extends AbstractController
{
    /**
     * @Route("/dashboard", name="item_report", methods={"GET"})
     */
    public function index()
    {
        $em = $this->getDoctrine()->getManager();
        $users = $em->getRepository(User::class)->findAll();
        $items = $em->getRepository(Item::class)->findAll();

        return $this->render('inventory/item_report.html.twig', [
            'users' => $users,
            'items' => $items,
        ]);
    }

}
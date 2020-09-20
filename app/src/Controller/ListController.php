<?php

namespace App\Controller;

use App\Entity\Customer;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class ListController extends AbstractController {

    private function getAllCustomers() {
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $records = $entityManager->getRepository('App:Customer')->findAll();
            return $records;
        } catch (\Exception $e) {

        }

    }

    public function list() {
        return $this->render('customer/list.html.twig', [
            'customers' => $this->getAllCustomers(),
        ]
        );
    }
}
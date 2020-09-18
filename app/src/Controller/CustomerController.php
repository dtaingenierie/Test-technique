<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\Type\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends AbstractController
{
    public function form(Request $request) {

        $customer = new Customer();
        $customer->setFirstName('John');
        $customer->setLastName('Doe');
        $customer->setPhoneNumber('0607082509');
        $customer->setCountry('France');

        $form = $this->createForm(CustomerType::class);

        return $this->render('customer/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\Type\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Form\Extension\Core\Type\TextType;
use Symfony\Component\Form\Extension\Core\Type\SubmitType;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;

class CustomerController extends AbstractController
{
    public function send(Request $request) {

        $customer = new Customer();
        $customer->setFirstName('John');
        $customer->setLastName('Doe');
        $customer->setPhoneNumber('0607082509');
        $customer->setCountry('France');

        $form = $this->createForm(CustomerType::class, $customer);
    }

    public function form(): Response
    {
        return new Response(
            '<html><body>Test</body></html>'
        );
    }
}
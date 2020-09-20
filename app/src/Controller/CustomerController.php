<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\Type\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerController extends AbstractController
{
    private $client;
    private $errors = ['firstname' => false, 'lastname' => false, 'phonenumber' => false, 'creating' => false];

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function createCustomer(Customer $customer) {
        // Doesn't work "An exception occurred in driver: SQLSTATE[HY000] [2002] No such file or directory"
        try {
            $entityManager = $this->getDoctrine()->getManager();
            $entityManager->persist($customer);
            $entityManager->flush();
        } catch (\Exception $e) {
            $this->errors['creating'] = true;
        }
    }

    public function fetchNumberInfos(String $phoneNumber, String $countryCode) {
        $json = '[{"phoneNumber":"'.$phoneNumber.'","countryCode":"'.$countryCode.'"}]';
        $response = $this->client->request(
            'POST',
            $this->getParameter('phone.valid.url'),
            [
                'auth_basic' => [$this->getParameter('phone.valid.user'), $this->getParameter('phone.valid.password')],
                'headers' => [
                    'accept' => 'application/json',
                    'Content-Type' => 'application/json',
                ],
                'body' => $json
            ]
        );
        $statusCode = $response->getStatusCode();
        if ($statusCode == 200) {
            return $response->toArray();
        }
        return null;
    }

    public function isFormValid($form) {
        $firstName = $form->get('firstname')->getData();
        $lastName = $form->get('lastname')->getData();

        if (strlen($firstName) < 3 || preg_match('/[^A-Za-z]/', $firstName)) {
            $this->errors['firstname'] = true;
        }
        if (strlen($lastName) < 3 || preg_match('/[^A-Za-z]/', $lastName)) {
            $this->errors['lastname'] = true;
        }
        return ($this->errors['firstname'] == false && $this->errors['lastname'] == false);

    }

    public function isNumberValid($form): bool {
        $country = $form->get('country')->getData();
        $phoneNumber = $form->get('phonenumber')->getData();
        $firstName = $form->get('firstname')->getData();
        $lastName = $form->get('lastname')->getData();
        if (preg_match('/[^0-9]/', $phoneNumber)) {
            var_dump("KO");
            $this->errors['phonenumber'] = true;
            return false;
        }

        $res = $this->fetchNumberInfos($phoneNumber, $country);
        if ($res !== null) {
            $content = $res[0];
            $output = $content["output"];
            $this->errors['phonenumber'] = !$output["isValid"];
            if ($output["isValid"]) {
                $customer = new Customer();
                $customer->setFirstName($firstName);
                $customer->setLastName($lastName);
                $customer->setCountry($output["country"]);
                $customer->setPhoneNumber($output["national"]);
                $customer->setInternational($output["international"]);
                $this->createCustomer($customer);
            }
            return $output["isValid"];
        }
        return false;
    }

    public function form(Request $request) {

        $form = $this->createForm(CustomerType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($this->isFormValid($form) && $this->isNumberValid($form) && $this->errors['creating'] == false) {
                return $this->redirectToRoute('success');
            }
        }
        return $this->render('customer/form.html.twig', [
            'form' => $form->createView(),
            'errors' => $this->errors,
        ]
        );
    }
}
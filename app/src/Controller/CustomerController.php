<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\Type\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\Constraints\Length;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerController extends AbstractController
{
    private $client;
    private $errors = ['firstname' => false, 'lastname' => false, 'phonenumber' => false];
    private $username = 'username';
    private $pwd = 'password';
    private $url = 'url';

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchNumberInfos(String $phoneNumber, String $countryCode) {
        $json = '[{"phoneNumber":"'.$phoneNumber.'","countryCode":"'.$countryCode.'"}]';
        $obj = json_decode($json);
        $response = $this->client->request(
            'POST',
            $this->url,
            [
                'auth_basic' => [$this->username, $this->pwd],
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

    public function isNumberValid($phoneNumber, $country): bool {

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
            return $output["isValid"];
        }
        return false;
    }

    public function form(Request $request) {

        $form = $this->createForm(CustomerType::class);
        $form->handleRequest($request);
        if ($form->isSubmitted()) {
            if ($this->isFormValid($form) && $this->isNumberValid($form->get('phonenumber')->getData(), $form->get('country')->getData())) {
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
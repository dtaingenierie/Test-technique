<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\Type\CustomerType;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class CustomerController extends AbstractController
{
    private $client;

    public function __construct(HttpClientInterface $client)
    {
        $this->client = $client;
    }

    public function fetchNumberInfos(String $phoneNumber, String $countryCode) {
        $json = '[{"phoneNumber":"'.$phoneNumber.'","countryCode":"'.$countryCode.'"}]';
        $obj = json_decode($json);
        $response = $this->client->request(
            'POST',
            'http://163.172.67.144:8042/api/v1/validate',
            [
                'auth_basic' => ['api','azpihviyazfb'],
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

    public function isValid($phoneNumber, $country): bool {

        $res = $this->fetchNumberInfos($phoneNumber, $country);
        if ($res !== null) {
            $content = $res[0];
            $output = $content["output"];
            return $output["isValid"];
        }
        return false;
    }

    public function form(Request $request) {

        $form = $this->createForm(CustomerType::class);
        $form->handleRequest($request);
        // $form->submit($form);
        if ($form->isSubmitted()) {
            if ($this->isValid($form->get('phonenumber')->getData(), $form->get('country')->getData())) {
                var_dump('OK');
                return $this->redirectToRoute('success');
            } else {
                var_dump($form->get('country')->getData());
            }
        }
        return $this->render('customer/form.html.twig', [
            'form' => $form->createView(),
        ]);
    }
}
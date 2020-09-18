<?php

namespace App\Controller;

use App\Entity\Customer;
use App\Form\Type\CustomerType;
use stdClass;
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

    public function fetchNumberInfos(String $countryCode, String $phoneNumber): array {
        $json = '[{"phoneNumber":"0659487512","countryCode":"FR"}]';
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
        $content = $response->toArray();

        return $content;
    }

    public function form(): Response {
        $res = $this->fetchNumberInfos('FR', '0652561932');
        $content = $res[0];
        $output = $content["output"];
        var_dump($output["isValid"]);
        return new Response(
            '<html>
                <body>
                '.!$output["isValid"].'
                </body>
            </html>'
        );
    }
    public function test(Request $request) {

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
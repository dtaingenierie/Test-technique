<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CustomerRepository")
 */
class Customer {
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $firstname;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $lastname;
    /**
     * @ORM\Column(type="string", length=2)
     */
    private $country;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $phonenumber;
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $international;

    public function getId() {
        return $this->id;
    }

    public function getFirstName() {
        return $this->firstname;
    }

    public function setFirstName($firstname) {
        $this->firstname = $firstname;
    }

    public function getLastName() {
        return $this->lastname;
    }

    public function setLastName($lastname) {
        $this->lastname = $lastname;
    }

    public function getCountry() {
        return $this->country;
    }

    public function setCountry($country) {
        $this->country = $country;
    }

    public function getPhoneNumber() {
        return $this->phonenumber;
    }

    public function setPhoneNumber($phonenumber) {
        $this->phonenumber = $phonenumber;
    }

    public function getInternational() {
        return $this->international;
    }

    public function setInternational($international) {
        $this->international = $international;
    }
}
<?php

namespace App\Entity;

class Customer {
    protected $firstname;
    protected $lastname;
    protected $country;
    protected $phonenumber;

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
}
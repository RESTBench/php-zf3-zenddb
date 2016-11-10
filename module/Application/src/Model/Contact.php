<?php

namespace Application\Model;

class Contact
{

    public $id;
    public $firstName;
    public $lastName;
    public $age;

    public function exchangeArray($data)
    {
        $this->id = !empty($data['id']) ? $data['id'] : null;
        $this->firstName = !empty($data['first_name']) ? $data['first_name'] : null;
        $this->lastName = !empty($data['last_name']) ? $data['last_name'] : null;
        $this->age = !empty($data['age']) ? $data['age'] : null;
    }

    public function getArrayCopy()
    {
        return [
            'id' => $this->id,
            'first_name' => $this->firstName,
            'last_name' => $this->lastName,
            'age' => $this->age
        ];
    }

}

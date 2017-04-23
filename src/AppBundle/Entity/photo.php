<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
* @ORM\Entity
* @ORM\Table(name="gallery")
*/
class photo
{
    /**
     * @ORM\Id
     * @ORM\Column(type="integer")
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank(message="Please, upload the product brochure as a jpg file.")
     * @Assert\File(maxSize="8Mi")
     */
    private $photo;


   /**
     * @Assert\NotBlank()
     * @ORM\Column(type="string", unique=true)
     */
    private $name;

    public function getphoto()
    {
        return $this->photo;
    }

    public function setphoto($photo)
    {
        $this->photo = $photo;
        return $this;
    }

    public function getid()
    {
        return $this->id;
    }

    public function getname()
    {
       return $this->name;    
    }

     public function setname($name)
    {
     $this->name =$name;
     return $this;        
    }

}
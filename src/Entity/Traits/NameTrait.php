<?php

namespace App\Entity\Traits;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

trait NameTrait
{
    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=120, unique=true)
     * @Assert\NotNull(message="validator.not_blank")
     * @Assert\NotBlank(message="validator.not_blank")
     */
    protected $name;

    /**
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * @param string $name
     *
     * @return self
     */
    public function setName($name)
    {
        $this->name = trim($name);

        return $this;
    }

    public function __toString()
    {
        if (true === empty($this->name)) {
            return '';
        }

        return $this->getName();
    }
}

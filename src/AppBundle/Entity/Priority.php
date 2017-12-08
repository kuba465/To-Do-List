<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use JsonSerializable;
use Symfony\Component\Validator\Constraints as Assert;


/**
 * Priority
 *
 * @ORM\Table(name="priority")
 * @ORM\Entity(repositoryClass="AppBundle\Repository\PriorityRepository")
 */
class Priority implements JsonSerializable
{
    /**
     * @var int
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="name", type="string", length=255)
     * @Assert\NotBlank(message="You must add some name to priority")
     */
    private $name;

    /**
     * @var int
     *
     * @ORM\Column(name="value", type="integer")
     * @Assert\Type(
     *     type="integer",
     *     message="Value of priority must be an integer"
     * )
     */
    private $value;

    /**
     * @ORM\OneToMany(targetEntity="Task", mappedBy="priority")
     */
    private $tasks;

    /**
     * Get id
     *
     * @return int
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set name
     *
     * @param string $name
     *
     * @return Priority
     */
    public function setName($name)
    {
        $this->name = $name;

        return $this;
    }

    /**
     * Get name
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Set value
     *
     * @param integer $value
     *
     * @return Priority
     */
    public function setValue($value)
    {
        $this->value = $value;

        return $this;
    }

    /**
     * Get value
     *
     * @return int
     */
    public function getValue()
    {
        return $this->value;
    }

    public function jsonSerialize()
    {
        return [
            'id' => $this->getId(),
            'name' => $this->getName(),
            'value' => $this->getValue()
        ];
    }
}

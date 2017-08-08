<?php

namespace AppBundle\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * Class User
 * @package AppBundle\Entity
 *
 * @ORM\Entity
 * @ORM\Table(name="user")
 * @ORM\HasLifecycleCallbacks()
 * @UniqueEntity(fields="email", message="Sorry, this email address is already in use.")
 */

class User
{
    /**
     * @ORM\Column(type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    protected $id;


    /**
     * @ORM\Column(type="string", unique=true)
     * @Assert\NotBlank()
     * @Assert\Email()
     */
    protected $email;

    /**
     * @ORM\Column(type="text")
     */
    protected  $token;

    /**
     * @ORM\Column(type="string")
     */
    protected  $user_id;

    /**
     * @ORM\Column(type="string", length=64)
     * @Assert\NotBlank()
     * @Assert\Regex(
     *  pattern="/(?=.*[A-Z])(?=.*[a-z])(?=.*[0-9]).{7,}/",
     *  message="Password must be seven or more characters long and contain at least one digit, one upper- and one lowercase character."
     * )
     */
    protected  $password;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="created", type="datetime", nullable=true)
     */
    private $created;
    /**
     * @var \DateTime
     *
     * @ORM\Column(name="updated", type="datetime", nullable=true)
     */
    private $updated;
    /**
     * Get id
     *
     * @return int
     */


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
     * Set title
     *
     * @param string $email
     *
     * @return User
     */
    public function setEmail($email)
    {
        $this->email = $email;
        return $this;
    }
    /**
     * Get title
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set title
     *
     * @param text $token
     *
     * @return User
     */
    public function setToken($token)
    {
        $this->token = $token;

        return $token;
    }
    /**
     * Get title
     *
     * @return text
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * Set title
     *
     * @param string $user_id
     *
     * @return User
     */
    public function setUserId($user_id)
    {
        $this->user_id = $user_id;

        return $user_id;
    }
    /**
     * Get title
     *
     * @return string
     */
    public function getUserId()
    {
        return $this->user_id;
    }

    /**
     * Set title
     *
     * @param string $password
     *
     * @return User
     */
    public function setPassword($password)
    {
        $this->password = $password;
        return $password;
    }
    /**
     * Get title
     *
     * @return string
     */
    public function getPassword()
    {
        return $this->password;
    }

    /**
     * Set created
     *
     * @param \DateTime $created
     * @ORM\PrePersist
     * @return User
     */
    public function setCreated()
    {
        $this->created = new \DateTime('now');
        return $this;
    }
    /**
     * Get created
     *
     * @return \DateTime
     */
    public function getCreated()
    {
        return $this->created;
    }
    /**
     * Set updated
     *
     * @param \DateTime $updated
     * @ORM\PreUpdate
     * @return User
     */
    public function setUpdated()
    {
        $this->updated = new \DateTime('now');
        return $this;
    }
    /**
     * Get updated
     *
     * @return \DateTime
     */
    public function getUpdated()
    {
        return $this->updated;
    }


}
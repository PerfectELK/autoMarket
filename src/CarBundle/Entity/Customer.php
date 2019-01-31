<?php

namespace CarBundle\Entity;

/**
 * Customer
 */
class Customer
{
    /**
     * @var int
     */
    private $id;

    /**
     * @var string
     */
    private $name;

    /**
     * @var string
     */
    private $email;

    /**
     * @var int
     */
    private $phone;


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
     * @return Customer
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
     * Set email
     *
     * @param string $email
     *
     * @return Customer
     */
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

    /**
     * Get email
     *
     * @return string
     */
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * Set phone
     *
     * @param integer $phone
     *
     * @return Customer
     */
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get phone
     *
     * @return int
     */
    public function getPhone()
    {
        return $this->phone;
    }
    /**
     * @var string
     */
    private $type;

    /**
     * @var string
     */
    private $passport;

    /**
     * @var string
     */
    private $driverNum;


    /**
     * Set type
     *
     * @param string $type
     *
     * @return Customer
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get type
     *
     * @return string
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set passport
     *
     * @param string $passport
     *
     * @return Customer
     */
    public function setPassport($passport)
    {
        $this->passport = $passport;

        return $this;
    }

    /**
     * Get passport
     *
     * @return string
     */
    public function getPassport()
    {
        return $this->passport;
    }

    /**
     * Set driverNum
     *
     * @param string $driverNum
     *
     * @return Customer
     */
    public function setDriverNum($driverNum)
    {
        $this->driverNum = $driverNum;

        return $this;
    }

    /**
     * Get driverNum
     *
     * @return string
     */
    public function getDriverNum()
    {
        return $this->driverNum;
    }
}

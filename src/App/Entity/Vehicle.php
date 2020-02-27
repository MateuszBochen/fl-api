<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\VehicleRepository")
 */
class Vehicle
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private ?int $id;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $registrationNumber;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $brand;

    /**
     * @var string
     * @ORM\Column(type="string", nullable=true)
     */
    private ?string $model;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $createDate;

    /**
     * @var \DateTime
     * @ORM\Column(type="datetime", nullable=true)
     */
    private ?\DateTime $lastUpdate;

    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getRegistrationNumber(): ?string
    {
        return $this->registrationNumber;
    }

    /**
     * @param string|null $registrationNumber
     * @return Vehicle
     */
    public function setRegistrationNumber(?string $registrationNumber): Vehicle
    {
        $this->registrationNumber = $registrationNumber;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getBrand(): ?string
    {
        return $this->brand;
    }

    /**
     * @param string|null $brand
     * @return Vehicle
     */
    public function setBrand(?string $brand): Vehicle
    {
        $this->brand = $brand;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getModel(): ?string
    {
        return $this->model;
    }

    /**
     * @param string|null $model
     * @return Vehicle
     */
    public function setModel(?string $model): Vehicle
    {
        $this->model = $model;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getCreateDate(): ?\DateTime
    {
        return $this->createDate;
    }

    /**
     * @param \DateTime|null $createDate
     * @return Vehicle
     */
    public function setCreateDate(?\DateTime $createDate): Vehicle
    {
        $this->createDate = $createDate;
        return $this;
    }

    /**
     * @return \DateTime|null
     */
    public function getLastUpdate(): ?\DateTime
    {
        return $this->lastUpdate;
    }

    /**
     * @param \DateTime|null $lastUpdate
     * @return Vehicle
     */
    public function setLastUpdate(?\DateTime $lastUpdate): Vehicle
    {
        $this->lastUpdate = $lastUpdate;
        return $this;
    }


}

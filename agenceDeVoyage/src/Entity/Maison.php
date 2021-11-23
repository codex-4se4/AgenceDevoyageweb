<?php

namespace App\Entity;

use App\Repository\MaisonRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=MaisonRepository::class)
 */
class Maison extends Hebergement
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="float")
     */
    private $surfaceJardin;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getSurfaceJardin(): ?float
    {
        return $this->surfaceJardin;
    }

    public function setSurfaceJardin(float $surfaceJardin): self
    {
        $this->surfaceJardin = $surfaceJardin;

        return $this;
    }
}

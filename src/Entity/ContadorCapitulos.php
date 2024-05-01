<?php

namespace App\Entity;

use App\Repository\ContadorCapitulosRepository;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: ContadorCapitulosRepository::class)]
class ContadorCapitulos
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\ManyToOne(inversedBy: 'contadorCapitulos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Usuario $usuario = null;

    #[ORM\ManyToOne(inversedBy: 'contadorCapitulos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Serie $serie = null;

    #[ORM\ManyToOne(inversedBy: 'contadorCapitulos')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Temporada $temporada = null;

    #[ORM\Column]
    private ?int $capitulo_actual = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getUsuario(): ?Usuario
    {
        return $this->usuario;
    }

    public function setUsuario(?Usuario $usuario): static
    {
        $this->usuario = $usuario;

        return $this;
    }

    public function getSerie(): ?Serie
    {
        return $this->serie;
    }

    public function setSerie(?Serie $serie): static
    {
        $this->serie = $serie;

        return $this;
    }

    public function getTemporada(): ?Temporada
    {
        return $this->temporada;
    }

    public function setTemporada(?Temporada $temporada): static
    {
        $this->temporada = $temporada;

        return $this;
    }

    public function getCapituloActual(): ?int
    {
        return $this->capitulo_actual;
    }

    public function setCapituloActual(int $capitulo_actual): static
    {
        $this->capitulo_actual = $capitulo_actual;

        return $this;
    }
}

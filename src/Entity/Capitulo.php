<?php

namespace App\Entity;

use App\Repository\CapituloRepository;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: CapituloRepository::class)]
class Capitulo
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero_cap = null;

    #[ORM\ManyToOne(inversedBy: 'capitulos_entity')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Temporada $id_temporada = null;

    #[ORM\Column(type: Types::DATETIME_MUTABLE)]
    private ?\DateTimeInterface $FechaCreacion = null;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroCap(): ?int
    {
        return $this->numero_cap;
    }

    public function setNumeroCap(int $numero_cap): static
    {
        $this->numero_cap = $numero_cap;

        return $this;
    }

    public function getIdTemporada(): ?Temporada
    {
        return $this->id_temporada;
    }

    public function setIdTemporada(?Temporada $id_temporada): static
    {
        $this->id_temporada = $id_temporada;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->FechaCreacion;
    }

    public function setFechaCreacion(\DateTimeInterface $FechaCreacion): static
    {
        $this->FechaCreacion = $FechaCreacion;

        return $this;
    }
}

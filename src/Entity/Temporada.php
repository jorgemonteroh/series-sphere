<?php

namespace App\Entity;

use App\Repository\TemporadaRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\DBAL\Types\Types;
use Doctrine\ORM\Mapping as ORM;

#[ORM\Entity(repositoryClass: TemporadaRepository::class)]
class Temporada
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column]
    private ?int $numero_temp = null;

    #[ORM\ManyToOne(inversedBy: 'temporada')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Serie $Serie = null;

    #[ORM\Column(type: Types::DATE_MUTABLE)]
    private ?\DateTimeInterface $fecha_creacion = null;

    #[ORM\Column(nullable: true)]
    private ?int $capitulos = null;

    #[ORM\OneToMany(mappedBy: 'temporada', targetEntity: ContadorCapitulos::class)]
    private Collection $contadorCapitulos;

    #[ORM\OneToMany(mappedBy: 'id_temporada', targetEntity: Capitulo::class)]
    private Collection $capitulos_entity;

    public function __construct()
    {
        $this->contadorCapitulos = new ArrayCollection();
        $this->capitulos_entity = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNumeroTemp(): ?int
    {
        return $this->numero_temp;
    }

    public function setNumeroTemp(int $numero_temp): static
    {
        $this->numero_temp = $numero_temp;

        return $this;
    }

    public function getSerie(): ?Serie
    {
        return $this->Serie;
    }

    public function setSerie(?Serie $Serie): static
    {
        $this->Serie = $Serie;

        return $this;
    }

    public function getFechaCreacion(): ?\DateTimeInterface
    {
        return $this->fecha_creacion;
    }

    public function setFechaCreacion(\DateTimeInterface $fecha_creacion): static
    {
        $this->fecha_creacion = $fecha_creacion;

        return $this;
    }

    public function getTemporadaSerie() {
        return $this->getSerie()." - Temporada ".$this->getNumeroTemp();
    }
    

    public function __toString(): string
    {
        return $this->getTemporadaSerie();
    }

    public function getCapitulos(): ?int
    {
        return $this->capitulos;
    }

    public function setCapitulos(?int $capitulos): static
    {
        $this->capitulos = $capitulos;

        return $this;
    }

    /**
     * @return Collection<int, ContadorCapitulos>
     */
    public function getContadorCapitulos(): Collection
    {
        return $this->contadorCapitulos;
    }

    public function addContadorCapitulo(ContadorCapitulos $contadorCapitulo): static
    {
        if (!$this->contadorCapitulos->contains($contadorCapitulo)) {
            $this->contadorCapitulos->add($contadorCapitulo);
            $contadorCapitulo->setTemporada($this);
        }

        return $this;
    }

    public function removeContadorCapitulo(ContadorCapitulos $contadorCapitulo): static
    {
        if ($this->contadorCapitulos->removeElement($contadorCapitulo)) {
            // set the owning side to null (unless already changed)
            if ($contadorCapitulo->getTemporada() === $this) {
                $contadorCapitulo->setTemporada(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection<int, Capitulo>
     */
    public function getCapitulosEntity(): Collection
    {
        return $this->capitulos_entity;
    }

    public function addCapitulosEntity(Capitulo $capitulosEntity): static
    {
        if (!$this->capitulos_entity->contains($capitulosEntity)) {
            $this->capitulos_entity->add($capitulosEntity);
            $capitulosEntity->setIdTemporada($this);
        }

        return $this;
    }

    public function removeCapitulosEntity(Capitulo $capitulosEntity): static
    {
        if ($this->capitulos_entity->removeElement($capitulosEntity)) {
            // set the owning side to null (unless already changed)
            if ($capitulosEntity->getIdTemporada() === $this) {
                $capitulosEntity->setIdTemporada(null);
            }
        }

        return $this;
    }
}

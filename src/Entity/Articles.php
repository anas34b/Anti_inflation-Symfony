<?php

namespace App\Entity;

use App\Repository\ArticlesRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use phpDocumentor\Reflection\Types\Void_;

#[ORM\Entity(repositoryClass: ArticlesRepository::class)]
class Articles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\Column]
    private ?float $prix = null;

    #[ORM\ManyToOne(inversedBy: 'relation')]
    #[ORM\JoinColumn(nullable: false)]
    private ?Types $types = null;

    #[ORM\ManyToMany(targetEntity: ListeArticles::class, mappedBy: 'relation')]
    private Collection $listeArticles;

    public function __construct()
    {
        $this->listeArticles = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNom(): ?string
    {
        return $this->nom;
    }

    public function setNom(string $nom): self
    {
        $this->nom = $nom;

        return $this;
    }

    public function getPrix(): ?float
    {
        return $this->prix;
    }

    public function setPrix(float $prix): self
    {
        $this->prix = $prix;

        return $this;
    }

    public function getTypes(): ?Types
    {
        return $this->types;
    }

    public function setTypes(?Types $types): self
    {
        $this->types = $types;

        return $this;
    }

    /**
     * @return Collection<int, ListeArticles>
     */
    public function getListeArticles(): Collection
    {
        return $this->listeArticles;
    }

    public function addListeArticle(ListeArticles $listeArticle): self
    {
        if (!$this->listeArticles->contains($listeArticle)) {
            $this->listeArticles->add($listeArticle);
            $listeArticle->addRelation($this);
        }

        return $this;
    }

    public function removeListeArticle(ListeArticles $listeArticle): self
    {
        if ($this->listeArticles->removeElement($listeArticle)) {
            $listeArticle->removeRelation($this);
        }

        return $this;
    }


}

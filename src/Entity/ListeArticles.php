<?php

namespace App\Entity;

use App\Entity\Articles;
use Doctrine\ORM\Mapping as ORM;
use App\Repository\ListeArticlesRepository;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

#[ORM\Entity(repositoryClass: ListeArticlesRepository::class)]
class ListeArticles
{
    #[ORM\Id]
    #[ORM\GeneratedValue]
    #[ORM\Column]
    private ?int $id = null;

    #[ORM\Column(length: 255)]
    private ?string $nom = null;

    #[ORM\ManyToMany(targetEntity: Articles::class, inversedBy: 'listeArticles')]
    private Collection $relation;

    public function __construct()
    {
        $this->relation = new ArrayCollection();
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

    /**
     * @return Collection<int, Articles>
     */
    public function getRelation(): Collection
    {
        return $this->relation;
    }

    public function addRelation(Articles $relation): self
    {
        if (!$this->relation->contains($relation)) {
            $this->relation->add($relation);
            $relation->addListeArticle($this);
        }

        return $this;
    }

    public function removeRelation(Articles $relation): self
    {
        $this->relation->removeElement($relation);

        return $this;
    }

    /**
     * Calcule le prix total de la liste
     */
    public function getTotalPrixListe(): float
    {
        $total = 0;
        foreach ($this->relation as $relation) {
            $total += $relation->getPrix();
        }
        return $total;
    }


    public function articlesChers(ListeArticles $liste)
{
    $articles = $liste->getRelation();
    
    if(count($articles) > 0) {
        $articlePlusCher = $articles[0];
        
        foreach ($articles as $article) {
            if($article->getPrix() > $articlePlusCher->getPrix()) {
                $articlePlusCher = $article;
            }
        }
        
        return $articlePlusCher->getNom();
    } else {
        return null;
    }
}
public function articlePasChers(ListeArticles $liste)
{
    $articles = $liste->getRelation();
    
    if(count($articles) > 0) {
        $articleMoinsCher = $articles[0];
        
        foreach ($articles as $article) {
            if($article->getPrix() < $articleMoinsCher->getPrix()) {
                $articleMoinsCher = $article;
            }
        }
        
        return $articleMoinsCher->getNom();
    } else {
        return null;
    }
}

public function compterArticles(ListeArticles $liste)
{
    $counts=0;
    $articles = $liste->getRelation();
    foreach ($articles as $article){
        if(!$article)
            $counts=$counts+1;
    }
    return $counts;
}
}

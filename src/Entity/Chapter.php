<?php

namespace App\Entity;

use App\Repository\ChapterRepository;
use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=ChapterRepository::class)
 */
class Chapter
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $name;

    /**
     * @ORM\Column(type="integer")
     */
    private $number;

    /**
     * @ORM\ManyToOne(targetEntity=Book::class, inversedBy="chapters")
     * @ORM\JoinColumn(nullable=false)
     */
    private $book;

    /**
     * @ORM\OneToMany(targetEntity=Verse::class, mappedBy="chapterr", orphanRemoval=true)
     */
    private $verses;

    public function __construct()
    {
        $this->verses = new ArrayCollection();
    }


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name;
    }

    public function setName(string $name): self
    {
        $this->name = $name;

        return $this;
    }

    public function getBook(): ?Book
    {
        return $this->book;
    }

    public function setBook(?Book $book): self
    {
        $this->book = $book;

        return $this;
    }

    /**
     * @return Collection|Verse[]
     */
    public function getVerses(): Collection
    {
        return $this->verses;
    }

    public function addVerse(Verse $verse): self
    {
        if (!$this->verses->contains($verse)) {
            $this->verses[] = $verse;
            $verse->setChapterr($this);
        }

        return $this;
    }

    public function removeVerse(Verse $verse): self
    {
        if ($this->verses->contains($verse)) {
            $this->verses->removeElement($verse);
            // set the owning side to null (unless already changed)
            if ($verse->getChapterr() === $this) {
                $verse->setChapterr(null);
            }
        }

        return $this;
    }

    public function getNumber(): ?int
    {
        return $this->number;
    }

    public function setNumber(?int $number): self
    {
        $this->number = $number;

        return $this;
    }

}

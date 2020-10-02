<?php

namespace App\Entity;

use App\Repository\VerseRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=VerseRepository::class)
 */
class Verse
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text", nullable=true)
     */
    private $content;

    /**
     * @ORM\ManyToOne(targetEntity=Chapter::class, inversedBy="verses")
     * @ORM\JoinColumn(nullable=false)
     */
    private $chapterr;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $number;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    public function setContent(?string $content): self
    {
        $this->content = $content;

        return $this;
    }


    public function getChapterr(): ?Chapter
    {
        return $this->chapterr;
    }

    public function setChapterr(?Chapter $chapterr): self
    {
        $this->chapterr = $chapterr;

        return $this;
    }

    public function getNumber(): ?string
    {
        return $this->number;
    }

    public function setNumber(string $number): self
    {
        $this->number = $number;

        return $this;
    }
}

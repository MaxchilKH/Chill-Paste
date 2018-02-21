<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\PasteRepository")
 */
class Paste
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $language;

    /**
     * @ORM\Column(type="string")
     * @Assert\NotBlank
     */
    private $title;

    /** @ORM\Column(type="datetime") */
    private $edit_date;

    /**
     * @ORM\ManyToOne(targetEntity="PastebinUser", inversedBy="pastes")
     * @ORM\JoinColumn(name="author_id", referencedColumnName="id", nullable=true)
     */
    private $author;

    /** @ORM\Column(type="string") */
    private $file_name;

    /** @ORM\Column(type="boolean") */
    private $visibility;
    //TODO: Add "visibility" field


    /**
     * @Assert\NotBlank
     */
    private $content;

    //*************** GETTERS & SETTERS ******************//

    public function getId()
    {
        return $this->id;
    }

    public function setId($id): void
    {
        $this->id = $id;
    }

    public function getLanguage()
    {
        return $this->language;
    }

    public function setLanguage($language): void
    {
        $this->language = $language;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle($title): void
    {
        $this->title = $title;
    }

    public function getContent()
    {
        return $this->content;
    }

    public function setContent($content): void
    {
        $this->content = $content;
    }

    public function getEditDate()
    {
        return $this->edit_date;
    }

    public function setEditDate($edit_date): void
    {
        $this->edit_date = $edit_date;
    }

    public function getAuthor()
    {
        return $this->author;
    }

    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    public function getFilename()
    {
        return $this->file_name;
    }

    public function setFilename($file_name): void
    {
        $this->file_name = $file_name;
    }


}

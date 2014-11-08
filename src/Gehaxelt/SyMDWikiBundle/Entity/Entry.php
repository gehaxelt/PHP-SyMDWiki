<?php

namespace Gehaxelt\SyMDWikiBundle\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * Entry
 *
 * @ORM\Table()
 * @ORM\Entity(repositoryClass="Gehaxelt\SyMDWikiBundle\Entity\EntryRepository")
 */
class Entry
{
    /**
     * @var integer
     *
     * @ORM\Column(name="id", type="integer")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(name="title", type="string", length=255)
     */
    private $title;

    /**
     * @var string
     *
     * @ORM\Column(name="content", type="text")
     */
    private $content;

    /**
     * @var \DateTime
     *
     * @ORM\Column(name="lastmodified", type="datetime")
     */
    private $lastmodified;

    /**
     * @var integer
     *
     * @ORM\Column(name="sortid", type="integer", )
     */
    private $sortid;


    public function __construct() {
        $this->sortid = 0;
        $this->content = "";
        $this->lastmodified = new \DateTime();
    }

    /**
     * Get id
     *
     * @return integer 
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * Set title
     *
     * @param string $title
     * @return Entry
     */
    public function setTitle($title)
    {
        $this->title = $title;

        return $this;
    }

    /**
     * Get title
     *
     * @return string 
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Set content
     *
     * @param string $content
     * @return Entry
     */
    public function setContent($content)
    {
        $this->content = $content;

        return $this;
    }

    /**
     * Get content
     *
     * @return string 
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * Set lastmodified
     *
     * @param \DateTime $lastmodified
     * @return Entry
     */
    public function setLastmodified($lastmodified)
    {
        $this->lastmodified = $lastmodified;

        return $this;
    }

    /**
     * Get lastmodified
     *
     * @return \DateTime 
     */
    public function getLastmodified()
    {
        return $this->lastmodified;
    }

    /**
     * Set sortid
     *
     * @param integer $sortid
     * @return Entry
     */
    public function setSortid($sortid)
    {
        $this->sortid = $sortid;

        return $this;
    }

    /**
     * Get sortid
     *
     * @return integer 
     */
    public function getSortid()
    {
        return $this->sortid;
    }

    public function parseMarkdown() 
    {
        $parsedown = new \Parsedown();
        return $parsedown->text($this->content);
    }
}

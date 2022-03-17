<?php
namespace App\Model;

/**
 * Permet de créer un formulaire de recherche grace à un SearchType
 */
class Search
{
    /**
     * @var string
     */
    private $string = '';

    /**
     * @var array
     */
    private $categories = [];

    /**
     * Get the value of string
     */ 
    public function getString()
    {
        return $this->string;
    }

    /**
     * Set the value of string
     *
     * @return  self
     */ 
    public function setString($string)
    {
        $this->string = $string;

        return $this;
    }

    /**
     * Get the value of categories
     */ 
    public function getCategories()
    {
        return $this->categories;
    }

    /**
     * Set the value of categories
     *
     * @return  self
     */ 
    public function setCategories($categories)
    {
        $this->categories = $categories;

        return $this;
    }
}
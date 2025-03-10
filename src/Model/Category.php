<?php
namespace App\Model;

class Category{
    private $id;
    private $name;
    private $slug;

    public function getID(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return e($this->name);
    }

    public function getSlug(): ?string
    {
        return e($this->slug);
    }
}
?>

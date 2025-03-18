<?php
namespace App\Model;

use App\Helpers\Text;
use DateTime;

class Post{
    private $id;
    private $name;
    private $slug;
    private $content;
    private $created_at;
    private $categories = [];



    public function addCategory(Category $category): void
    {
        $this->categories[] = $category;
        $category->setPost($this);
    }

    //GETTERS

    public function getID(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return htmlentities($this->name);
    }

    public function getExcerpt(): ?string
    {
        if($this->content === null){
            return null;
        }
        return nl2br(htmlentities(Text::excerpt($this->content, POST_LIMIT) . '...'));
    }

    public function getCreatedAt(): DateTime
    {
        return new DateTime($this->created_at);
    }

    public function getSlug(): ?string
    {
        return htmlentities($this->slug);
    }

    public function getFormattedContent(): ?string
    {
        return nl2br(htmlentities($this->content));
    }

    public function getContent(): ?string
    {
        return $this->content;
    }

    /**
     * return Category[]
     */
    public function getCategories(): array
    {
        return $this->categories;
    }

    //SETTERS

    public function setID(int $id): void
    {
        $this->id = $id;
    }

    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }

    public function setContent(string $content): void
    {
        $this->content = $content;
    }

}
<?php
namespace App\Model;

class Category{
    private $id;
    private $name;
    private $slug;
    private $post_id;
    private $post;

    //GETTERS
    public function getID(): ?int
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->name !== null ? e($this->name) : null;
    }

    public function getSlug(): ?string
    {
        return $this->slug !== null ? e($this->slug) : null;
    }

    public function getPostId(): ?int
    {
        return $this->post_id;
    }

    //SETTERS
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    public function setSlug(string $slug): void
    {
        $this->slug = $slug;
    }

    public function setPostId(int $post_id): void
    {
        $this->post_id = $post_id;
    }

    public function setPost(Post $post): void
    {
        $this->post = $post;
    }

    public function setId(int $id): void
    {
        $this->id = $id;
    }
}
?>

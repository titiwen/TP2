<?php
namespace App\Model;

class Category{
    private $id;
    private $name;
    private $slug;
    private $post_id;
    private $post;

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

    public function getPostId(): ?int
    {
        return $this->post_id;
    }

    public function setPost(Post $post): void
    {
        $this->post = $post;
    }
}
?>

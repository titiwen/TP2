<?php
namespace App;

use App\Connection;
use Exception;
use PDO;

class PaginatedQuery{

    private $query;
    private $queryCount;
    private $pdo;
    private $pages;
    private $count;
    private $items;

    public function __construct(
        string $query,
        string $queryCount,
        ?\PDO $pdo = null)
    {
        $this->query = $query;
        $this->queryCount = $queryCount;
        $this->pdo = $pdo ?: Connection::getPDO();
        $this->pages = $this->getCurrentPage();
    }

    public function getItems(string $classMapping): array
    {
        if($this->items === null){
            $page = $this->getCurrentPage();
            $pages = $this->getPages();
            if($page > $pages){
                throw new Exception('Cette page n\'existe pas');
            }
            $offset = $page > 1 ? $page * PER_PAGE - PER_PAGE : 0;
            $this->items = $this->pdo
            ->query($this->query . " LIMIT " . PER_PAGE . " OFFSET $offset")
            ->fetchAll(PDO::FETCH_CLASS, $classMapping);
        }

        return $this->items;
    }

    public function getCurrentPage(): int
    {
        return URL::getPositiveInt('page', 1);
    }

    public function previousLink(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        if($currentPage <= 1) return null;
        if($currentPage > 2) $link .= '?page=' . ($currentPage - 1);
        return <<<HTML
            <a href="{$link}" class="ant-btn ant-btn-primary">&laquo; Page précédente</a>
HTML;
    }

    public function nextLink(string $link): ?string
    {
        $currentPage = $this->getCurrentPage();
        $pages = $this->getPages();
        if($currentPage >= $pages) return null;
        $link .= '?page=' . ($currentPage + 1);
        return <<<HTML
            <a href="{$link}" class="ant-btn ant-btn-primary">Page suivante &raquo;</a>
HTML;
    }

    private function getPages(): int
    {
        if($this->count === null){
            $count = (int)$this->pdo->query($this->queryCount)->fetch(PDO::FETCH_NUM)[0];
        }
        return $this->pages = ceil($count / PER_PAGE);
    }
}
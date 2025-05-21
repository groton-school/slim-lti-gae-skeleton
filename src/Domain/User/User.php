<?php

declare(strict_types=1);

namespace App\Domain\User;

class User
{
    private string $locator;
    private array $data;
    private bool $dirty = false;

    public function __construct(string $locator, array $data,)
    {
        $this->locator = $locator;
        $this->data = $data;
    }

    public function getLocator()
    {
        return $this->locator;
    }

    public function getId()
    {
        return $this->data['id'];
    }

    public function getData()
    {
        return $this->data;
    }

    public function isDirty()
    {
        return $this->dirty;
    }

    public function setDirty(bool $dirty)
    {
        $this->dirty = $dirty;
    }
}

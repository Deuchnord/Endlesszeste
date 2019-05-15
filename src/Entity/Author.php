<?php

/*
 * This file is part of Endlesszeste.
 *
 * Endlesszeste is free software: you can redistribute it and/or modify
 * it under the terms of the GNU Affero General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * Endlesszeste is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU Affero General Public License for more details.
 *
 * You should have received a copy of the GNU Affero General Public License
 * along with Endlesszeste.  If not, see <https://www.gnu.org/licenses/agpl.html>.
 */

declare(strict_types=1);

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AuthorRepository")
 */
class Author
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $identifier;

    /**
     * @ORM\Column(type="boolean")
     */
    private $banned;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Extract", mappedBy="author")
     */
    private $extracts;

    public function __construct()
    {
        $this->extracts = new ArrayCollection();
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getIdentifier(): ?string
    {
        return $this->identifier;
    }

    public function setIdentifier(string $identifier): self
    {
        $this->identifier = $identifier;

        return $this;
    }

    public function isBanned(): ?bool
    {
        return $this->banned;
    }

    public function setBanned(bool $banned): self
    {
        $this->banned = $banned;

        return $this;
    }

    /**
     * @return Collection|Extract[]
     */
    public function getExtracts(): Collection
    {
        return $this->extracts;
    }

    public function addExtract(Extract $extract): self
    {
        if (!$this->extracts->contains($extract)) {
            $this->extracts[] = $extract;
            $extract->setAuthor($this);
        }

        return $this;
    }

    public function removeExtract(Extract $extract): self
    {
        if ($this->extracts->contains($extract)) {
            $this->extracts->removeElement($extract);
            // set the owning side to null (unless already changed)
            if ($extract->getAuthor() === $this) {
                $extract->setAuthor(null);
            }
        }

        return $this;
    }
}

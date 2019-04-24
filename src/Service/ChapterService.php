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

namespace App\Service;

use App\Entity\Chapter;
use App\Repository\ChapterRepository;

class ChapterService
{
    private $repository;

    public function __construct(ChapterRepository $repository)
    {
        $this->repository = $repository;
    }

    public function getChapter(int $number): ?Chapter
    {
        return $this->repository->findOneByNumber($number);
    }

    /**
     * Return true if and only if given chapter is the last.
     *
     * @param int|Chapter $chapter
     *
     * @return bool
     */
    public function isLast($chapter): bool
    {
        if ($chapter instanceof Chapter) {
            $number = $chapter->getNumber();
        } elseif (is_numeric($chapter)) {
            $number = $chapter;
        } else {
            throw new \InvalidArgumentException(\sprintf(
                '$chapter argument must be either numeric or an instance of %s (got %s)',
                Chapter::class,
                get_class($chapter)
            ));
        }

        $chapter1 = $this->getChapter($number + 1);

        return null === $chapter1;
    }

    public function getNumberOfChapters(): int
    {
        return $this->repository->count([]);
    }
}

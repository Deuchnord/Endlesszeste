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

use App\Entity\Author;

class AuthorService
{
    const ALGORITHM = 'sha512';

    public function createAuthor(string $ipAddress, bool $banned = false): Author
    {
        return (new Author())
            ->setIdentifier($this->hash($ipAddress))
            ->setBanned($banned)
        ;
    }

    protected function hash($ipAddress)
    {
        return \hash(self::ALGORITHM, $ipAddress);
    }
}

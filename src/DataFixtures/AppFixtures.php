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

namespace App\DataFixtures;

use App\Entity\Chapter;
use App\Entity\Extract;
use App\Service\AuthorService;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use joshtronic\LoremIpsum;

class AppFixtures extends Fixture
{
    private $loremIpsum;
    private $authorService;

    public function __construct(AuthorService $authorService)
    {
        $this->loremIpsum = new LoremIpsum();
        $this->authorService = $authorService;
    }

    public function load(ObjectManager $manager)
    {
        $authors = [
            $this->authorService->createAuthor('127.0.0.1'),
            $this->authorService->createAuthor('127.0.0.2', true),
            $this->authorService->createAuthor('127.0.0.3'),
            $this->authorService->createAuthor('127.0.0.4', true),
        ];

        foreach ($authors as $author) {
            $manager->persist($author);
        }

        for ($i = 0; $i < 3; ++$i) {
            $chapter = (new Chapter())
                ->setNumber($i + 1)
                ->setTitle($this->loremIpsum->words(4))
            ;
            $manager->persist($chapter);

            for ($j = 0; $j < rand(5, 10); ++$j) {
                $contents = $this->loremIpsum->paragraphs(rand(1, 3), false, true);

                foreach ($contents as $content) {
                    $isDialog = rand(1, 20) <= 5;

                    if ($isDialog) {
                        $content = sprintf('- %s', $content);
                    }

                    $content = str_replace(' lorem ', ' [censured] ', $content);
                    $content = str_replace(' et ', ' _et_ ', $content);

                    $extract = (new Extract())
                        ->setAuthor($authors[rand(0, 3)])
                        ->setChapter($chapter)
                        ->setPublicationDate(new \DateTime('-1 week'))
                        ->setContent($content)
                    ;

                    $manager->persist($extract);
                }
            }
        }

        $manager->flush();
    }
}

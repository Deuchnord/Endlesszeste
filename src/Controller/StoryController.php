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

namespace App\Controller;

use App\Form\ExtractType;
use App\Service\ChapterService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;

class StoryController extends AbstractController
{
    private $chapterService;

    public function __construct(ChapterService $chapterService)
    {
        $this->chapterService = $chapterService;
    }

    /**
     * @Route("/", name="homepage")
     */
    public function index(): Response
    {
        return $this->getViewForChapter(1);
    }

    /**
     * @Route("/chapter-{number}", name="chapter")
     */
    public function chapter(int $number): Response
    {
        return $this->getViewForChapter($number);
    }

    /**
     * @Route("/new-chapter", name="chapter_new")
     */
    public function newChapter(): Response
    {
        return $this->render('new-chapter.html.twig');
    }

    /**
     * @Route("/chapter-{chapter}/fix", name="fix-chapter")
     */
    public function fixChapter(): Response
    {
        return $this->render('rules.html.twig');
    }

    /**
     * @Route("/help", name="help")
     */
    public function rules(): Response
    {
        return $this->render('rules.html.twig');
    }

    private function getViewForChapter(int $number): Response
    {
        $chapter = $this->chapterService->getChapter($number);

        if (null === $chapter) {
            throw $this->createNotFoundException('Chapter not found');
        }

        $extractForm = $this->chapterService->isLast($chapter) ? $this->createForm(ExtractType::class) : null;

        return $this->render('chapter.html.twig', ['chapter' => $chapter, 'form' => $extractForm ? $extractForm->createView() : null]);
    }
}

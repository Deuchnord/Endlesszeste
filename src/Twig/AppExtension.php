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

namespace App\Twig;

use App\Service\ChapterService;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;
use Twig\Extension\AbstractExtension;
use Twig\TwigFilter;
use Twig\TwigFunction;

class AppExtension extends AbstractExtension
{
    private $chapterService;
    private $urlGenerator;
    private $translator;

    public function __construct(ChapterService $chapterService, UrlGeneratorInterface $urlGenerator, TranslatorInterface $translator)
    {
        $this->chapterService = $chapterService;
        $this->urlGenerator = $urlGenerator;
        $this->translator = $translator;
    }

    public function getFilters()
    {
        return [
            new TwigFilter('story', [$this, 'parseStory'], ['is_safe' => ['all']]),
        ];
    }

    public function getFunctions()
    {
        return [
            new TwigFunction('pagination', [$this, 'generatePagination'], ['is_safe' => ['all']]),
        ];
    }

    public function parseStory(string $text): string
    {
        $parsedText = sprintf('<p>%s</p>', $text);
        $parsedText = $this->makeParagraphs($parsedText);
        $parsedText = $this->makeNonBreakingSpaces($parsedText);
        $parsedText = $this->makeDialogs($parsedText);
        $parsedText = $this->makeItalics($parsedText);

        return $this->makeCensures($parsedText);
    }

    public function generatePagination(int $currentChapterNumber): string
    {
        $pagination = '<nav class="pagination">'.PHP_EOL;

        if (1 != $currentChapterNumber) {
            $pagination .= sprintf(
                '<span class="item"><a href="%s" aria-label="%s">&lsaquo;</a></span>',
                $this->urlGenerator->generate('chapter', ['number' => $currentChapterNumber - 1]),
                $this->translator->trans('site.pagination.previous')
            );
        }

        for ($i = 1; $i <= $this->chapterService->getNumberOfChapters(); ++$i) {
            $current = ($i == $currentChapterNumber) ? ' current' : '';
            $pagination .= sprintf(
                '<span class="item%s"><a href="%s">%d</a></span>',
                $current,
                $this->urlGenerator->generate('chapter', ['number' => $i]),
                $i
            );
        }

        if ($this->chapterService->isLast($currentChapterNumber)) {
            $pagination .= sprintf(
                '<span class="item"><a href="%s" title="%s">&plus;</a></span>',
                $this->urlGenerator->generate('chapter_new'),
                $this->translator->trans('site.pagination.new')
            );
        } else {
            $pagination .= sprintf(
                '<span class="item"><a href="%s" aria-label="%s">&rsaquo;</a></span>',
                $this->urlGenerator->generate('chapter', ['number' => $currentChapterNumber + 1]),
                $this->translator->trans('site.pagination.next')
            );
        }

        $pagination .= '</nav>';

        return $pagination;
    }

    private function makeParagraphs(string $text): string
    {
        $replacement = str_replace("\n", "</p>\n<p>", $text);

        return preg_replace('#(<p></p>)+#', '', $replacement);
    }

    private function makeDialogs(string $text): string
    {
        return str_replace('<p>- ', '<p>—&nbsp;', $text);
    }

    private function makeItalics(string $text): string
    {
        $replacement = '<span class="italic">$1</span>';

        $parsed = preg_replace('/_([^_]+)_/', $replacement, $text);

        return preg_replace('/\*([^*]+)\*/', $replacement, $parsed);
    }

    private function makeCensures(string $text): string
    {
        $replacement = '<span class="censured">censuré</span>';

        $parsed = str_replace('[censured]', $replacement, $text);

        return str_replace('[censuré]', $replacement, $parsed);
    }

    private function makeNonBreakingSpaces(string $text): string
    {
        return preg_replace('/[ ]?([?!;:%]+)/', '&nbsp;$1', $text);
    }
}

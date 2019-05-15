<?php


namespace App\Tests\Twig;


use App\Service\ChapterService;
use App\Twig\AppExtension;
use PHPUnit\Framework\TestCase;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Contracts\Translation\TranslatorInterface;

class AppExtensionTest extends TestCase
{
    private $appExtension;

    protected function setUp()
    {
        $this->appExtension = new AppExtension($this->createMock(ChapterService::class), $this->createMock(UrlGeneratorInterface::class), $this->createMock(TranslatorInterface::class));
    }

    public function testParseStory()
    {
        $story = $this->appExtension->parseStory(<<<STORY
Clem se trémoussait sur l'air que jouait Deuch' quand soudain, _Paf !_, un saucisson surgit et l'emmena. Clem n'eut pas le temps de réagir et elle vit soudain sa destination.
- Non, par pitié, pas le pressoir à oranges ! hurla-t-elle en se débattant.
La musique s'arrêta au beau milieu d'un *mi* bémol.
- [censuré] de [censured], c'est qu'il lui en veut, à not' Clem, fit informaticienzero.
- Quel langage ! remarqua Deuch'.
STORY
        );

        $expected = <<<PARSED_STORY
<p>Clem se trémoussait sur l'air que jouait Deuch' quand soudain, <span class="italic">Paf&nbsp;!</span>, un saucisson surgit et l'emmena. Clem n'eut pas le temps de réagir et elle vit soudain sa destination.</p>
<p>—&nbsp;Non, par pitié, pas le pressoir à oranges&nbsp;! hurla-t-elle en se débattant.</p>
<p>La musique s'arrêta au beau milieu d'un <span class="italic">mi</span> bémol.</p>
<p>—&nbsp;<span class="censured">censuré</span> de <span class="censured">censuré</span>, c'est qu'il lui en veut, à not' Clem, fit informaticienzero.</p>
<p>—&nbsp;Quel langage&nbsp;! remarqua Deuch'.</p>
PARSED_STORY;

        self::assertEquals($expected, $story);
    }
}

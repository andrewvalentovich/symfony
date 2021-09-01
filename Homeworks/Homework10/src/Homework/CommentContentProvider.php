<?php


namespace App\Homework;

use App\Homework\PasteWords\PasteWords;

class CommentContentProvider implements CommentContentProviderInterface
{
    /**
     * CommentContentProvider constructor.
     */
    private $pasteWords;

    public function __construct(PasteWords $pasteWords)
    {
        $this->pasteWords = $pasteWords;
    }

    public function get(string $word = null, int $wordsCount = 0): string
    {
        $content = [
            'Ясность нашей позиции очевидна: убеждённость некоторых оппонентов, в своём классическом представлении, *допускает внедрение форм воздействия*. В 
частности, начало повседневной работы по формированию позиции позволяет выполнить важные задания по разработке направлений прогрессивного развития.',
            'Предварительные выводы неутешительны: начало повседневной работы по формированию позиции не оставляет шанса для дальнейших направлений развития. 
Банальные, но неопровержимые выводы.',
            'Следует отметить, что постоянное информационно-пропагандистское обеспечение нашей деятельности играет важную роль в формировании поэтапного и последовательного развития общества.',
            'Приятно, граждане, наблюдать, как тщательные исследования конкурентов, инициированные исключительно синтетически, описаны максимально подробно. 
Независимые государства, вне зависимости от их уровня, должны быть разоблачены.',
            'Внезапно, явные признаки победы институционализации освещают чрезвычайно интересные особенности картины в целом, однако конкретные выводы, разумеется, 
объявлены нарушающими общечеловеческие нормы этики и морали.'
        ];

        return $this->pasteWords->paste($content[rand(0, 4)], $word, $wordsCount);
    }
}
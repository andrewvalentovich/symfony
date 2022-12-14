<?php


namespace App\Homework;


class ArticleContentProvider implements ArticleContentProviderInterface
{

    private $markWordParameter;

    /**
     * ArticleContentProvider constructor.
     */
    public function __construct($markWordParameter = 'false')
    {
        $this->markWordParameter = $markWordParameter;
    }

    public function get(int $paragraphs, string $word = null, int $wordsCount = 0): string
    {

        $usedText = ''; // инициализирую переменную под конечное значение текста
        $text = [
            '&emsp;&emsp;Каждый из нас понимает очевидную вещь: новая модель организационной деятельности создаёт предпосылки для своевременного выполнения сверхзадачи. Внезапно, 
базовые сценарии поведения пользователей формируют глобальную экономическую сеть и при этом. Предварительные выводы неутешительны: экономическая повестка сегодняшнего дня влечет за собой процесс внедрения и модернизации новых предложений. Но начало повседневной работы 
по формированию позиции играет важную роль в формировании системы обучения кадров, соответствующей насущным потребностям. Есть над чем задуматься: элементы 
политического процесса могут быть обнародованы. Внезапно, тщательные исследования конкурентов представляют собой не что иное, как квинтэссенцию победы маркетинга 
над разумом и должны быть функционально разнесены на независимые элементы.
- функционально 
- разнесены 
- на независимые элементы.

',
            '&emsp;&emsp;Ясность нашей позиции очевидна: убеждённость некоторых оппонентов, в своём классическом представлении, *допускает внедрение форм воздействия*. В 
частности, начало повседневной работы по формированию позиции позволяет выполнить важные задания по разработке направлений прогрессивного развития. В своём 
стремлении повысить качество жизни, они забывают, что граница обучения кадров прекрасно подходит для реализации системы массового участия! Следует отметить, 
что постоянное информационно-пропагандистское обеспечение нашей деятельности играет важную роль в формировании поэтапного и последовательного развития общества. 
Принимая во внимание показатели успешности, реализация намеченных плановых заданий требует анализа поэтапного и последовательного развития общества. Вот вам яркий 
пример современных тенденций - консультация с широким активом в значительной степени обусловливает важность поставленных обществом задач!',
            '&emsp;&emsp;Предварительные выводы неутешительны: начало повседневной работы по формированию позиции не оставляет шанса для дальнейших направлений развития. 
Банальные, но неопровержимые выводы, [а также элементы политического процесса](/) неоднозначны и будут призваны к ответу. Банальные, но неопровержимые выводы, а также 
представители современных социальных резервов будут в равной степени предоставлены сами себе. Но повышение уровня гражданского сознания однозначно фиксирует 
необходимость соответствующих условий активизации. Противоположная точка зрения подразумевает, что непосредственные участники технического прогресса могут быть 
объединены в целые кластеры себе подобных.',
            '&emsp;&emsp;Приятно, граждане, наблюдать, как тщательные исследования конкурентов, инициированные исключительно синтетически, описаны максимально подробно. 
Независимые государства, [вне зависимости от их уровня](/), должны быть разоблачены.',
            '&emsp;&emsp;Внезапно, явные признаки победы институционализации освещают чрезвычайно интересные особенности картины в целом, однако конкретные выводы, разумеется, 
объявлены нарушающими общечеловеческие нормы этики и морали. В своём стремлении повысить качество жизни, они забывают, что понимание сути ресурсосберегающих 
технологий, а также свежий взгляд на привычные вещи - [безусловно](/) открывает новые горизонты для системы массового участия. Как принято считать, тщательные 
исследования конкурентов освещают чрезвычайно интересные особенности картины в целом, однако конкретные выводы, разумеется, превращены в посмешище, хотя само их 
существование приносит несомненную пользу обществу.'
        ];

        for ($i = 0; $i < $paragraphs; $i++) {
            $usedText = $usedText.$text[rand(0,4)].'<br/>';
        }

        if ($word != null) {
            switch ($this->markWordParameter) {
                case 'bold':
                    $word = ' '.'**'.$word.'**';
                    break;

                case 'italic':
                    $word = ' '.'*'.$word.'*';
                    break;
            }

            $usedText = $this->addWord($wordsCount, $usedText, $word);
        }


        return $usedText;
    }

    public function addWord(int $wordsCount, string $usedText, string $word = NULL): string
    {
        for ($i = 0; $i < $wordsCount; $i++) {
            $usedText = substr_replace(
                $usedText,
                $word,
                stripos($usedText, ' ', rand(0, iconv_strlen($usedText,'UTF-8'))),
                0
            );
        }

        return $usedText;
    }
}
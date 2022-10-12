<html lang="en">
<head>
    <title>Article Preview</title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
</head>
<body><div class="limiter"><div class="data-wrapper">
        <?php if (array_key_exists('article-text', $_POST) && array_key_exists('article-link', $_POST)): ?>
            <p>
                <?php
                    $ARTICLE_PREVIEW_LEN = 200;
                    $ARTICLE_LINK_WORDS_NUM = 3;
                    $articleText = $_POST['article-text'];
                    $articleLink = $_POST['article-link'];

                    $articleText = trim($articleText);

                    /**
                    *   Если длина строки меньше 200 символов, обрезаем её,
                    *   если нет многоточия на конце полученной обрезанной строки, добавляем его.
                    *   Внимания заслуживает тот случай, когда в тексте меньше 200 символов,
                    *   в таком случае логичным поведением будет не добавлять многоточия. В случае,
                    *   если в тексте меньше трёх слов, некоторые индексы при вычислении будут отрицательными,
                    *   функции при этом ведут себя ожидаемо. Если слов меньше трёх, ссылками будут все слова
                    *   из исходного текста.
                    */
                    if (strlen($articleText) > $ARTICLE_PREVIEW_LEN) {
                        $articleText = substr($articleText, 0, $ARTICLE_PREVIEW_LEN);
                        $subStr = substr($articleText, $ARTICLE_PREVIEW_LEN - 3, 3);
                        if ($subStr != '...') $articleText .= '...';
                    }

                    /**
                    *   Выделяем слова, которые будут являться ссылкой, создаём для них отдельный массив
                    */
                    $words = preg_split('/[\s,]+/', $articleText);
                    $articleLinkWords = array_slice($words,
                        count($words) - $ARTICLE_LINK_WORDS_NUM,
                        $ARTICLE_LINK_WORDS_NUM,
                        true);

                    /**
                    *   Вычисляем длину слов-ссылок и выводим подстроку с сокращённым текстом статьи
                    */
                    $articleLinkWordsLen = 0;
                    foreach ($articleLinkWords as $word) $articleLinkWordsLen += strlen($word) + 1;
                    $articleLinkWordsLen--;

                    echo substr($articleText, 0, strlen($articleText) - $articleLinkWordsLen) . ' ';
                ?>
                <a href="<?= $articleLink ?>"><?php foreach ($articleLinkWords as $item) echo $item . ' ' ?></a>
            </p>
        <?php else: ?>
            <h3>Enter article data</h3>
            <form action="index.php" method="post">
                <div>
                    <label>
                        <input type="text" name="article-link" required placeholder="Enter link">
                    </label>
                </div>
                <div>
                    <label>
                        <textarea name="article-text" required placeholder="Enter text here"></textarea>
                    </label>
                </div>
                <input type="submit" value="Submit">
            </form>
        <?php endif; ?>
    </div></div></body>
</html>

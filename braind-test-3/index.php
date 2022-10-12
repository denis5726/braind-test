<html lang="en">
<head>
    <title>Strange Math</title>
    <link rel="stylesheet" href="css/main.css" type="text/css">
    <?php
        /**
        * @param $array - массив произвольных элементов
        * @param $comparator - функция, определяющая отношение порядка между элементами массива
        * @return array - отсортированный массив
        *
        */
        function heap_sort($array, $comparator): array {
            /**
             * @param $array - массив, на основе которого будет построена куча
             * @param $i - индекс элемента массива, который является родительским узлом
             * @param $n - размер массива (указывается, для работы сортировки, где последовательно уменьшается
             * размер массива)
             * @param $comparator - функция, определяющая отношение порядка между элементами массива
             * @return array - массив, с перестроенной для родительского и всех дочерних элементов кучей. Куча
             * перестраивается рекурсивно для всех поддеревьев дерева с корнем, имеющим индекс i.
             */
            function build_heap($array, $i, $n, $comparator): array {
                $largest = $i;
                $leftChild = $i * 2 + 1;
                $rightChild = $i * 2 + 2;

                if ($leftChild < $n && $comparator($array[$leftChild], $array[$i]) > 0) $largest = $leftChild;
                if ($rightChild < $n && $comparator($array[$rightChild], $array[$largest]) > 0) $largest = $rightChild;
                if ($largest != $i) {
                    $t = $array[$largest];
                    $array[$largest] = $array[$i];
                    $array[$i] = $t;

                    return build_heap($array, $largest, $n, $comparator);
                }

                return $array;
            }

            $n = count($array);

            for ($i = intdiv($n, 2) - 1; $i >= 0; --$i) $array = build_heap($array, $i, $n, $comparator);

            for ($i = $n - 1; $i >= 0; $i--) {
                $t = $array[$i];
                $array[$i] = $array[0];
                $array[0] = $t;

                $array = build_heap($array, 0, $i, $comparator);
            }

            return $array;
        }

        /**
        *   Функция задаёт отношение лексикографического порядка между двумя строками
        *   @param $obj1 - первая строка
        *   @param $obj2 - вторая строка
        *   @return int - функция возвращает 1, если первая строка больше второй
        *                                    0, если строки равны
        *                                    -1, если первая строка меньше второй
        */
        function compare($obj1, $obj2): int {
            $obj1 = (string)$obj1;
            $obj2 = (string)$obj2;

            $minLength = min(strlen($obj1), strlen($obj2));

            for ($i = 0; $i < $minLength; $i++) {
                if ($obj1[$i] > $obj2[$i]) return 1;
                elseif ($obj1[$i] < $obj2[$i]) return -1;
            }

            if (strlen($obj1) == strlen($obj2)) return 0;
            else return (strlen($obj1) > strlen($obj2)) ? 1 : -1;
        }

        /**
        * Функция ищет $value в массиве $array используя $comparator для сравнения $value с элементами массива
        * $array
        * @param $array - массив, по которому осуществляется поиск. Массив должен быть отсортирован
        * в соответствии с отношением порядка $comparator и не иметь пропусков (то есть не должно быть
        * значений, которые лежат между двумя элементами массива, не находясь при этом в нём)
        * @param $value - искомое значение
        * @param $comparator - функция, задающая отношение порядка с искомым значением в массиве
        * @return int - возвращает искомого значения в массиве,
        *   если значения нет в массиве возвращает -1
        */
        function binary_search($array, $value, $comparator): int {
            $n = count($array);
            $l = -1;
            $r = $n;
            $m = intdiv($l + $r, 2);

            if ($comparator($array[$n - 1], $value) < 0) return -1;

            while ($l + 1 < $r) {
                if ($comparator($array[$m], $value) > 0) $r = $m;
                else $l = $m;

                $m = intdiv($l + $r, 2);
            }

            return $l;
        }
    ?>
</head>
<body><div class="limiter"><div class="data-wrapper">
        <?php if (array_key_exists('n', $_POST) && array_key_exists('k', $_POST)): ?>
            <p>
                Position of number K:
                <?php
                    $n = $_POST['n'];
                    $k = $_POST['k'];
                    $array = [];

                    /**
                    *   Проверяем, входит ли $k в границы массива чисел, среди которых его будут искать
                    */
                    if ($k > $n || $k <= 0) echo -1 . "\n";
                    else {
                        for ($i = 0; $i < $n; $i++) $array[$i] = $i + 1;

                        $array = heap_sort($array, function ($obj1, $obj2) {
                            return compare($obj1, $obj2);
                        });

                        $position = binary_search($array, $k, function ($obj1, $obj2) {
                            return compare($obj1, $obj2);
                        });

                        echo $position . "\n";
                    }
                    ?>
                </p>
        <?php else: ?>
            <form action="index.php" method="post">
                <input name="n" type="number" min="0" required placeholder="N number">
                <input name="k" type="number" min="0" required placeholder="K number">
                <input type="submit" value="Submit">
            </form>
        <?php endif; ?>
    </div></div></body>
</html>






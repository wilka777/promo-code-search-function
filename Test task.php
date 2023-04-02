<?php
// Массив входных данных для теста, три массива для разных случаев
$orders = [1 => // Массив для случая "Полное совпадение промокода только одной продажи"
    [ 101 =>   // Ордер 1
        [
            "price" => 100,
            "buyer" => [
                'name' => 'Nick',
                'promoCode' => [
                    'abc1',
                    'abc2',
                    'abv5',
                    'abc4',
                ]
            ]
        ],
        102 => // Ордер 2
            [
                "price" => 200,
                "buyer" => [
                    'name' => 'Sam',
                    'promoCode' => [
                        'abc1',
                        'abc2',
                        'abc3',
                        'abc4',
                    ]
                ]
            ],
        103 => // Ордер 3
            [
                "price" => 300,
                "buyer" => [
                    'name' => 'Sam',
                    'promoCode' => [
                        'abc1',
                        'abc2',
                        'abc3',
                        'abc4',
                    ]
                ]
            ]
    ],
    2 => // Массив для случая "Полное совпадение промокода с двумя продажами"
        [ 201 =>   // Ордер 1
            [
                "price" => 100,
                "buyer" => [
                    'name' => 'Nick',
                    'promoCode' => [
                        'abc1',
                        'abv5',
                        'abc3',
                        'abc4',
                    ]
                ]
            ],
            202 => // Ордер 2
                [
                    "price" => 200,
                    "buyer" => [
                        'name' => 'Sam',
                        'promoCode' => [
                            'abc1',
                            'abc2',
                            'abc3',
                            'abc4',
                        ]
                    ]
                ],
            203 => // Ордер 3
                [
                    "price" => 300,
                    "buyer" => [
                        'name' => 'Sam',
                        'promoCode' => [
                            'abc1',
                            'abc2',
                            'abv5',
                            'abc4',
                        ]
                    ]
                ]
        ], 3 => // Проверочный массив для случая "Полное совпадение промокода с одной продажей и частичное совпадение с двумя продажами"
        [ 301 =>   // Ордер 1
            [
                "price" => 100,
                "buyer" => [
                    'name' => 'Nick',
                    'promoCode' => [
                        'abc1',
                        'abc2',
                        'abv5',
                        'abc4',
                    ]
                ]
            ],
            302 => // Ордер 2
                [
                    "price" => 200,
                    "buyer" => [
                        'name' => 'Sam',
                        'promoCode' => [
                            'abc1',
                            'abv2',
                            'abc3',
                            'abc4',
                        ]
                    ]
                ],
            303 => // Ордер 3
                [
                    "price" => 300,
                    "buyer" => [
                        'name' => 'Sam',
                        'promoCode' => [
                            'abc1',
                            'sbv5',
                            'abc3',
                            'abc4',
                        ]
                    ]
                ]
        ]
];

$promoCode = 'abv5'; // Верный промокод

// Код программы
const PROMO_CODE_LENGTH = 4; // Зададим длинну промокода в виде константы
const PROMO_CODE_MIN_SYMBOL_TRUE = 3; // Длина промокода, для частичного совпадения


function FindOrdersByPromoCode($orders, $promoCode): array // Функция принимающая входные данные и возвращающая массив с номерами ордеров
{
    $out = []; // Массив выводных данных
    foreach ($orders as $orderId => $order) { // Вынимаем все промокоды для каждого ордера
        if (DoesOrderHavePromocode($order, $promoCode)) { // Если ордер содержит промокод, то записываем номер ордера в массив выводных данных
            $out[] = $orderId;
        }
    }
    return $out; // После завершения работы функции возвращаем массив
}


function DoesOrderHavePromoCode(array $order, string $promoCode): bool // Функция принимающая все промокоды одного ордера и проверяет наличие в ней промокода, возвращает True are False
{
    $arrPromoCode = $order['buyer']['promoCode']; // Массив во всеми прокодами ордера
    foreach ($arrPromoCode as $sCode) { // Достаём каждый промокод
        if (comparePromoCodes($sCode, $promoCode)) { // Если проверяем промокод содержит больше трёх схожих символов
            return true; // возвращаем True
        }
    }

    return false; // иначе False
}

function comparePromoCodes(string $a, string $b): bool // Функция посимвольной проверки промокодов
{
    $symbolsAmount = 0; // вводим счётчик совпавших символов
    for ($i = 0; $i < PROMO_CODE_LENGTH; $i++) { // Проходимся по каждому символу промокода
        if ($a[$i] === $b[$i]) { // Если символ проверяемого совпадает с символом заданного то
            $symbolsAmount++; // увеличиваем счётчик на 1
        }
    }

    return $symbolsAmount >= PROMO_CODE_MIN_SYMBOL_TRUE; // Возвращаем True если счётчик больше или равен 3
}


// Проверка и вывод условий
$testOne = FindOrdersByPromoCode($orders[1], $promoCode); // Вызов функции для первого случая
$testTwo = FindOrdersByPromoCode($orders[2], $promoCode); // Вызов функции для второго случая
$testThree = FindOrdersByPromoCode($orders[3], $promoCode); // Вызов функции для третьего случая
echo "<pre>";
echo "Проверка первого условия - Полное совпадение промокода только с одной продажей \n";
print_r($orders[1]);
echo "Результат работы программы для первого условия \n";
print_r($testOne);
echo "<br>";

echo "Проверка второго условия - Полное совпадение промокода с двумя продажами \n";
print_r($orders[2]);
echo "Результат работы программы для второго условия \n";
print_r($testTwo);
echo "<br>";

echo "Проверка третьего условия - Полное совпадение промокода с одной продажей и частичное совпадение с двумя продажами \n";
print_r($orders[3]);
echo "Результат работы программы для третьего условия \n";
print_r($testThree);
echo "<br>";

echo "</pre>";




?>

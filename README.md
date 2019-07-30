# filter.date
Show different filter columns to month and year from iblock properties

# Код вызова компонента:
$APPLICATION->IncludeComponent(
    "flxmd:filter.date",
    "",
    Array(
        "IBLOCK_ID" => $arParams["IBLOCK_ID"]
    ),
    $component
);

$arParams["IBLOCK_ID"] - id инфоблока

<?php
function route($folderType, $pathParts) {
    $templateMap = [
        'categories' => empty($pathParts[2]) ? 'categories_aRHFv0YTQy' : 'categorieslisting_Cg8fAElUNE',
        'series' => empty($pathParts[2]) ? 'series_UcpaobSROX' : 'serieslisting_345435af',
        'login' => 'login_fEvc8cJ2EnLYNT8',
        'register' => 'register_cmjB6y7Qgs',
        'logout' => 'logout_iwEs6WpLzx74W7W', 
    ];
    return $templateMap[$folderType]??'404_adkfwelr';
}
$path = filter_input(INPUT_SERVER, 'REQUEST_URI', FILTER_SANITIZE_URL);
$path = parse_url($path, PHP_URL_PATH);
$pathParts = explode('/', rtrim($path, '/'));
$folderType = $pathParts[1]??'';
if (empty($folderType)) {
    include __DIR__ . "/index_adfadfe.php";
    exit();
}
$template = route($folderType, $pathParts);
$allowedTemplates = [
    'categories_aRHFv0YTQy',
    'categorieslisting_Cg8fAElUNE',
    'series_UcpaobSROX', 
    'serieslisting_345435af', 
    'index_adfadfe', 
    'login_fEvc8cJ2EnLYNT8', 
    'logout_iwEs6WpLzx74W7W', 
    'register_cmjB6y7Qgs', 
    '404_adkfwelr'
];
$templatePath = __DIR__ . "/$template.php";
if (in_array($template, $allowedTemplates) && file_exists($templatePath)) {
    include $templatePath;
} else {
    include __DIR__ . "/404.php";
}
exit();
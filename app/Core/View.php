<?php
declare(strict_types=1);

namespace App\Core;

final class View
{
    public static function render(string $template, array $data = [], string $layout = 'app'): string
    {
        $templatePath = self::pathFor($template);
        $layoutPath = self::pathFor('layouts/' . $layout);

        extract($data, EXTR_SKIP);

        ob_start();
        require $templatePath;
        $content = (string) ob_get_clean();

        ob_start();
        require $layoutPath;

        return (string) ob_get_clean();
    }

    public static function partial(string $template, array $data = []): string
    {
        $templatePath = self::pathFor($template);

        extract($data, EXTR_SKIP);

        ob_start();
        require $templatePath;

        return (string) ob_get_clean();
    }

    private static function pathFor(string $template): string
    {
        return dirname(__DIR__) . '/Views/' . $template . '.php';
    }
}

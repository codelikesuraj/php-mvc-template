<?php

namespace App\Helpers;

class View
{
    protected const DIR = __DIR__;
    protected const EXT = '.view.php';
    public array $with;
    public string $filePath;

    public function __construct(string $file, array $with = [])
    {
        // parse view file separated by '.'
        $filePath = self::DIR . '/../Views/' . $this->toFilePath($file) . self::EXT;

        if (!file_exists($filePath)) {
            throw new \Exception("View '{$file}' not found ");
        }

        $this->with = $with;
        $this->filePath = $filePath;

        return $this;
    }

    protected function toFilePath(string $file): string
    {
        $file = trim($file);

        if (empty($file)) {
            return "";
        }

        if (strpos($file, '.')) {
            return str_replace('.', '/', $file);
        }

        return $file;
    }

    public static function display(View $view)
    {
        extract($view->with);
        require_once($view->filePath);
    }
}

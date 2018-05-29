<?php

namespace App\View;

/**
 * Class View
 *
 * @package App\View
 */
class View
{
    /**
     * @var string
     */
    private $template;

    /**
     * @var array
     */
    private $args;

    /**
     * @var string
     */
    private $title;

    /**
     * @var string
     */
    private $content;

    /**
     * View constructor.
     *
     * @param string $template
     * @param array  $args
     */
    public function __construct($template, array $args = [])
    {
        $this->template = $template;
        $this->args     = $args;
    }

    public function render()
    {
        extract($this->args, EXTR_SKIP);
        $file = dirname(__DIR__) . "/../$this->template";
        if (is_readable($file)) {
            ob_start();
            require $file;
            $this->content = ob_get_clean();
        } else {
            throw new \Exception("$file not found");
        }

        $layoutFile = __DIR__ . '/layout/layout.phtml';
        require $layoutFile;
    }

    /**
     * @param string $title
     *
     * @return View
     */
    public function setTitle(string $title)
    {
        $this->title = $title;
        return $this;
    }
}
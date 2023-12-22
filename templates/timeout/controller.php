<?php

require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/abstarct-template-controller.php';
class Gm_Timeout_Controller extends Abstract_Template_Controller
{
    protected function setting()
    {
        parent::setting();
    }

    private function render()
    {
        require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/header.php';
        require 'view.php';
        require_once ABSPATH . 'wp-content/themes/sango-theme-child-garage/templates/_common/footer.php';
    }

    public function action()
    {
        if (!empty($_SESSION)){
            session_destroy();
        }

        // 画面描画
        $this->render();
    }
}

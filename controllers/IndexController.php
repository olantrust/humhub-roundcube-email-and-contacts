<?php

namespace olan\roundcube\controllers;

use humhub\components\Controller;

class IndexController extends Controller
{

    public $subLayout = "@roundcube/views/layouts/default";

    /**
     * Renders the index view for the module
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

}


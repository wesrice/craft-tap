<?php
namespace Craft;

use Tap\Tap;

class TapController extends BaseController
{
    protected $allowAnonymous = true;

    public function actionTap(array $variables = array())
    {
        unset($variables['matches']);
        $tap = new Tap($variables);

        $results = $tap->execute();

        $this->returnJson($results);
    }
}

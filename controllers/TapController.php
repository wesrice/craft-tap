<?php
namespace Craft;

use Tap\Request;
use Tap\Response;

class TapController extends BaseController
{
    /**
     * Allow anonymous calls to this controller
     *
     * @var boolean
     */
    protected $allowAnonymous = true;

    /**
     * Action - Tap
     *
     * @param array $variables Variables
     *
     * @return mixed Results
     */
    public function actionTap(array $variables = array())
    {
        unset($variables['matches']);

        $request = new Request();
        $request->setVariables($variables);
        $request->execute();

        $response = new Response($request);
        $response->execute();
        $results = $response->getResults();

        $this->returnJson($results);
    }
}

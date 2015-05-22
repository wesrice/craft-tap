<?php
namespace Craft;

use Tap\Request;
use \CDbException;
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
        $request = new Request();
        $response = new Response();

        try {
            $request->handle();
            $response->setRequest($request);
        } catch(CDbException $exception) {
            $response->respondWithError(500, 'CDbException', 'Something is wrong.');
        }

        $response->send();
    }
}

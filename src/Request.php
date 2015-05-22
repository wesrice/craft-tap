<?php
namespace Tap;

use Craft\Craft;
use League\Fractal\TransformerAbstract;
use Tap\Validators\ValidatorAbstract;
use Tap\Actions\IndexAction;
use Tap\Actions\ShowAction;
use Tap\Actions\StoreAction;
use Tap\Actions\DestroyAction;

class Request
{
    /**
     * Element Type
     *
     * @var string
     */
    protected $elementType;

    /**
     * Element ID
     *
     * @var string
     */
    protected $elementId;

    /**
     * Element Action
     *
     * @var string
     */
    protected $elementAction;

    /**
     * Params
     *
     * @var array
     */
    protected $params = [];

    /**
     * Request Type
     *
     * @var string
     */
    protected $requestType;

    /**
     * Validator
     *
     * @var Tap\Validators\ValidatorAbstract
     */
    protected $validator;

    /**
     * Results
     *
     * @var array
     */
    protected $results;

    /**
     * Constructor
     */
    public function __construct()
    {
        $variables = craft()->urlManager->getRouteParams()['variables'];
        unset($variables['matches']);
        $this->setVariables($variables);

        $this->setRequestType(craft()->request->getRequestType());

        $this->setParams(array_merge(craft()->request->getQuery(), craft()->request->getPost()));
    }

    /**
     * Set Variables
     *
     * @param array $variables [description]
     */
    public function setVariables(array $variables) {
        foreach ($variables as $property => $value) {
            $this->setProperty($property, $value);
        }

        $validator = '\\Tap\\Validators\\'.$this->elementType.'Validator';
        $this->setValidator(new $validator);
    }

    /**
     * __get Magic Method
     *
     * @param string $property Property
     *
     * @return mixed Property
     */
    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    /**
     * __set Magic Method
     *
     * @param string $property Property
     * @param string $value    Value
     */
    public function __set($property, $value) {
        $this->setProperty($property, $value);

        return $this;
    }

    /**
     * Set Request Type
     *
     * @param string $requestType Request Type
     */
    public function setRequestType($requestType)
    {
        $this->requestType = $requestType;
    }

    /**
     * Set Property
     *
     * @param string $property Property
     * @param string $value    Value
     */
    public function setProperty($property, $value)
    {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }
    }

    /**
     * Set Params
     *
     * @param array $params Params
     */
    public function setParams(array $params)
    {
        if ($this->elementId) {
            $this->params['id'] = $this->elementId;
        }

        $this->params = array_merge($this->params, $params);
    }


    /**
     * Set Validator
     *
     * @param ValidatorAbstract $validator Validator
     */
    public function setValidator(ValidatorAbstract $validator)
    {
        $this->validator = $validator;
    }

    /**
     * Get Config
     *
     * @return array Config
     */
    public function getConfig()
    {
        return [
            'elementType'   => $this->elementType,
            'elementId'     => $this->elementId,
            'elementAction' => $this->elementAction,
            'params'        => $this->params,
        ];
    }

    /**
     * Handle
     *
     * @return mixed Results
     */
    public function handle()
    {
        $action = $this->getAction();

        $this->results = $action->execute();
    }

    /**
     * Results
     *
     * @return array Results
     */
    public function getResults()
    {
        return $this->results;
    }

    /**
     * Get Action
     *
     * @return ActionAbstract Action
     */
    private function getAction()
    {
        if ($this->requestType === 'GET' && !$this->elementId) {
            return new IndexAction($this);
        }

        if ($this->requestType === 'GET' && $this->elementId) {
            return new ShowAction($this);
        }

        if ($this->requestType === 'POST') {
            return new StoreAction($this);
        }

        if ($this->requestType === 'PUT') {
            return new UpdateAction($this);
        }

        if ($this->requestType === 'DELETE') {
            return new DestroyAction($this);
        }
    }
}

/**
 * Returns the current craft() instance. This is a wrapper function for the Craft::app() instance.
 *
 * @return WebApp|ConsoleApp
 */
function craft()
{
    return \Craft\craft();
}

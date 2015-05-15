<?php
namespace Tap;

use Craft\Craft;
use League\Fractal\TransformerAbstract;
use Tap\Actions\IndexAction;
use Tap\Actions\ShowAction;
use Tap\Actions\StoreAction;
use Tap\Actions\DestroyAction;

class Tap
{
    protected $elementType;
    protected $elementId;
    protected $elementAction;
    protected $params = [];

    protected $requestType;

    protected $serializer = '\\League\\Fractal\\Serializer\\DataArraySerializer';
    protected $transformer;
    protected $error_transformer;
    protected $validator;

    public function __construct(array $config = array())
    {
        $this->requestType = craft()->request->getRequestType();

        foreach ($config as $property => $value) {
            if (property_exists($this, $property)) {
                $this->$property = $value;
            }
        }

        $this->setParams(array_merge(craft()->request->getQuery(), craft()->request->getPost()));

        $transformer = '\\Tap\\Transformers\\'.$this->elementType.'Transformer';
        $this->setTransformer(new $transformer);

        $this->setErrorTransformer(new \Tap\Transformers\ErrorTransformer);

        $validator = '\\Tap\\Validators\\'.$this->elementType.'Validator';
        $this->setValidator(new $validator);
    }

    public function __get($property) {
        if (property_exists($this, $property)) {
            return $this->$property;
        }
    }

    public function __set($property, $value) {
        if (property_exists($this, $property)) {
            $this->$property = $value;
        }

        return $this;
    }

    public function setParams(array $params)
    {
        if ($this->elementId) {
            $this->params['id'] = $this->elementId;
        }

        $this->params = array_merge($this->params, $params);
    }

    public function setTransformer(TransformerAbstract $transformer)
    {
        $this->transformer = $transformer;
    }

    public function setErrorTransformer(TransformerAbstract $transformer)
    {
        $this->error_transformer = $transformer;
    }

    public function setValidator($validator)
    {
        $this->validator = $validator;
    }

    public function getConfig()
    {
        return [
            'elementType'   => $this->elementType,
            'elementId'     => $this->elementId,
            'elementAction' => $this->elementAction,
            'params'        => $this->params,
        ];
    }

    public function execute()
    {
        $action = $this->getAction();

        return $action->execute();
    }

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

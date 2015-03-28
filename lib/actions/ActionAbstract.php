<?php
namespace Tap\Actions;

use Tap\Tap;
use League\Fractal\Manager;

abstract class ActionAbstract
{
    protected $requestType;
    protected $elementType;
    protected $elementId;
    protected $elementAction;
    protected $params;
    protected $transformer;
    protected $serializer;

    public function __construct(Tap $tap)
    {
        $this->requestType   = $tap->requestType;
        $this->elementType   = $tap->elementType;
        $this->elementId     = $tap->elementId;
        $this->elementAction = $tap->elementAction;
        $this->params        = $tap->params;
        $this->transformer   = $tap->transformer;
        $this->serializer    = $tap->serializer;
    }

    abstract public function run();

    public function execute()
    {
        $manager = new Manager();
        $manager->setSerializer(new $this->serializer);

        $results = $this->run();

        return $manager->createData($results)->toArray();
    }

    public function getRecord()
    {
        $record_class = '\\Craft\\'.$this->elementType.'Record';
        return new $record_class($this->params);
    }

    public function getModel()
    {
        $model_class = '\\Craft\\'.$this->elementType.'Model';
        return new $model_class($this->params);
    }
}

function craft()
{
    return \Craft\craft();
}

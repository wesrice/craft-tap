<?php
namespace Tap;

use Craft\craft;
use Tap\Request;
use Tap\Transformers\ErrorTransformer;
use League\Fractal\Serializer\DataArraySerializer;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

class Response
{
    /**
     * Request
     *
     * @var Tap\Request
     */
    protected $request;

    /**
     * Serializer
     *
     * @var string
     */
    protected $serializer;

    /**
     * Transformer
     *
     * @var League\Fractal\TransformerAbstract
     */
    protected $transformer;

    /**
     * Error Transformer
     *
     * @var  League\Fractal\TransformerAbstract
     */
    protected $error_transformer;

    /**
     * Results
     *
     * @var array
     */
    protected $results;

    /**
     * Constructor
     *
     * @param Request $request Request
     */
    public function __construct(Request $request)
    {
        $this->request = $request;

        $transformer = '\\Tap\\Transformers\\'.$request->elementType.'Transformer';
        $this->setTransformer(new $transformer);

        $this->setErrorTransformer(new ErrorTransformer);
        $this->setSerializer(new DataArraySerializer);
    }

    /**
     * Execute
     *
     * @return void
     */
    public function execute()
    {
        $results = $this->request->getResults();

        $manager = new Manager();
        $manager->setSerializer($this->serializer);

        if (is_array($results)) {
            $data = new Collection($results, $this->transformer);
        } else {
            $data = new Item($results, $this->transformer);
        }

        $this->results = $manager->createData($data)->toArray();
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
     * Set Seralizer
     *
     * @param DataArraySerializer $serializer Serializer
     */
    public function setSerializer(DataArraySerializer $serializer)
    {
        $this->serializer = $serializer;
    }

    /**
     * Set Transformer
     *
     * @param TransformerAbstract $transformer Transfromer
     */
    public function setTransformer(TransformerAbstract $transformer)
    {
        $this->transformer = $transformer;
    }

    /**
     * Set Error Transformer
     *
     * @param TransformerAbstract $transformer Transformer
     */
    public function setErrorTransformer(TransformerAbstract $transformer)
    {
        $this->error_transformer = $transformer;
    }
}

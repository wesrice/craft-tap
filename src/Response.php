<?php
namespace Tap;

use Craft\craft;
use Tap\Request;
use Tap\Transformers\ErrorTransformer;
use League\Fractal\Serializer\DataArraySerializer;
use Craft\JsonHelper;
use League\Fractal\Manager;
use League\Fractal\TransformerAbstract;
use League\Fractal\Resource\Item;
use League\Fractal\Resource\Collection;

use Tap\Paginators\CraftPaginateVariableAdapter;

class Response
{
    /**
     * Manager
     *
     * @var League\Fractal\Manager
     */
    protected $manager;

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
     * HTTP Status Code
     *
     * @var int
     */
    protected $http_status_code = 200;

    /**
     * Error Code
     *
     * @var int
     */
    protected $error_code;

    /**
     * Error Message
     *
     * @var string
     */
    protected $error_message;

    /**
     * Constructor
     *
     * @param Request $request Request
     */
    public function __construct()
    {
        $this->manager = new Manager();

        $this->setErrorTransformer(new ErrorTransformer);

        $this->setSerializer(new DataArraySerializer);
    }

    /**
     * Set Request
     *
     * @param Request $request Request
     */
    public function setRequest(Request $request)
    {
        $this->request = $request;

        $transformer = '\\Tap\\Transformers\\'.$request->elementType.'Transformer';
        $this->setTransformer(new $transformer);
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

    /**
     * Add Header
     *
     * @param string $key   Key
     * @param string $value Value
     */
    public function addHeader($key, $value)
    {
        HeaderHelper::setHeader([$key => $value]);
    }

    /**
     * Set Http Status Code
     *
     * @param int $http_status_code Http Status Code
     */
    public function setHttpStatusCode($http_status_code)
    {
        $this->http_status_code = (int) $http_status_code;
    }

    /**
     * Set Error Code
     *
     * @param string $error_code Error Code
     */
    public function setErrorCode($error_code)
    {
        $this->error_code = $error_code;
    }

    /**
     * Set Error Message
     *
     * @param string $error_message Error Message
     */
    public function setErrorMessage($error_message)
    {
        $this->error_message = $error_message;
    }

    /**
     * Responde with Error
     *
     * @param string $http_status_code Http Status Code
     * @param string $error_code       Error Code
     * @param string $error_message    Error Message
     */
    public function respondWithError($http_status_code, $error_code, $error_message)
    {
        $this->setHttpStatusCode($http_status_code);
        $this->setErrorCode($error_code);
        $this->setErrorMessage($error_message);
    }

    /**
     * Send
     *
     * @return void
     */
    public function send()
    {
        $body = $this->hasError() ? $this->getError() : $this->getResults();

        http_response_code($this->http_status_code);

        JsonHelper::sendJsonHeaders();

        // Output it into a buffer, in case TasksService wants to close the connection prematurely
        ob_start();
        echo JsonHelper::encode($body);

        craft()->end();
    }

    public function hasError()
    {
        return ($this->error_code);
    }

    private function getError()
    {
        return [
            'error' => [
                'code'    => $this->error_code,
                'message' => $this->error_message,
            ]
        ];
    }

    /**
     * Get Results
     *
     * @return array Results
     */
    private function getResults()
    {
        $this->manager->setSerializer($this->serializer);

        $results = $this->request->getResults();

        if (is_array($results)) {
            $data = new Collection($results[1], $this->transformer);
            $data->setMetaValue('pagination', $results[0]);
        } else {
            $data = new Item($results, $this->transformer);
        }

        return $this->manager->createData($data)->toArray();
    }
}

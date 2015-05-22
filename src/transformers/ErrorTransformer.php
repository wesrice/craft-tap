<?php
namespace Tap\Transformers;

use League\Fractal\TransformerAbstract;
use stdClass;
use Craft\Craft;

class ErrorTransformer extends TransformerAbstract
{
    public function transform(stdClass $errors)
    {
        return (array) $errors;
    }
}

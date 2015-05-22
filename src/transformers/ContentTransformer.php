<?php
namespace Tap\Transformers;

use League\Fractal\TransformerAbstract;
use Craft\EntryModel;
use Craft\RichTextData;
use Craft\Craft;

class ContentTransformer extends TransformerAbstract
{
    public function transform(EntryModel $entry)
    {
        $transformed = [];

        $content = $entry->getContent();

        foreach ($content->getAttributeConfigs() as $attribute => $config) {

            if ($entry->$attribute instanceof RichTextData) {
                $transformed[$attribute] = $entry->$attribute->getRawContent();
            }

            if ($entry->$attribute instanceof ElementCriteriaModel) {
                $transformed[$attribute] = $entry->$attribute->find();
            }

        }

        return $transformed;
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

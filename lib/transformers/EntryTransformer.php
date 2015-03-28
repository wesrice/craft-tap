<?php
namespace Tap\Transformers;

use League\Fractal\TransformerAbstract;
use Craft\EntryModel;
use Craft\Craft;

class EntryTransformer extends TransformerAbstract
{
    public function transform(EntryModel $element)
    {
        return [
            'id'            => (int) $element->id,
            'enabled'       => (int) $element->enabled,
            'archived'      => (int) $element->archived,
            'locale'        => $element->locale,
            'localeEnabled' => (int) $element->localeEnabled,
            'slug'          => $element->slug,
            'uri'           => $element->uri,
            'dateCreated'   => $element->dateCreated,
            'dateUpdated'   => $element->dateUpdated,
            'root'          => $element->root,
            'lft'           => (int) $element->lft,
            'rgt'           => (int) $element->rgt,
            'level'         => (int) $element->level,
            'sectionId'     => (int) $element->sectionId,
            'typeId'        => (int) $element->typeId,
            'authorId'      => (int) $element->authorId,
            'postDate'      => $element->postDate,
            'expiryDate'    => $element->expiryDate,
            'parentId'      => (int) $element->parentId,
            'revisionNotes' => $element->revisionNotes,
        ];
    }
}

<?php
namespace Tap\Transformers;

use Craft\AssetModel;

class AssetTransformer extends TransformerAbstract
{
    public function transform(AssetModel $element)
    {
        return [
            'id'            => (int) $element->id,
            'enabled'       => (int) $element->enabled,
            'archived'      => (int) $element->archived,
            'locale'        => $element->locale,
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

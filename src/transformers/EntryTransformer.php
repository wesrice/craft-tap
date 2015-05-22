<?php
namespace Tap\Transformers;

use League\Fractal\TransformerAbstract;
use Craft\EntryModel;
use Craft\Craft;

class EntryTransformer extends TransformerAbstract
{
    /**
     * List of resources to automatically include
     *
     * @var array
     */
    protected $defaultIncludes = [
        'author',
        'content',
    ];

    public function transform(EntryModel $entry)
    {
        return [
            'id'            => (int) $entry->id,
            'enabled'       => (int) $entry->enabled,
            'archived'      => (int) $entry->archived,
            'locale'        => $entry->locale,
            'localeEnabled' => (int) $entry->localeEnabled,
            'slug'          => $entry->slug,
            'uri'           => $entry->uri,
            'dateCreated'   => $entry->dateCreated,
            'dateUpdated'   => $entry->dateUpdated,
            'root'          => $entry->root,
            'lft'           => (int) $entry->lft,
            'rgt'           => (int) $entry->rgt,
            'level'         => (int) $entry->level,
            'sectionId'     => (int) $entry->sectionId,
            'typeId'        => (int) $entry->typeId,
            'authorId'      => (int) $entry->authorId,
            'postDate'      => $entry->postDate,
            'expiryDate'    => $entry->expiryDate,
            'parentId'      => (int) $entry->parentId,
            'revisionNotes' => $entry->revisionNotes,
        ];
    }

    /**
     * Include Author
     *
     * @param EntryModel $entry
     * @return \League\Fractal\Resource\Item
     */
    public function includeAuthor(EntryModel $entry)
    {
        $author = $entry->getAuthor();

        if ($author) {
            return $this->item($author, new UserTransformer);
        }
    }

    /**
     * Include Content
     *
     * @param EntryModel $entry
     * @return \League\Fractal\Resource\Item
     */
    public function includeContent(EntryModel $entry)
    {
        if ($entry) {
            return $this->item($entry, new ContentTransformer);
        }
    }

}

<?php

namespace Fogs\TaggingBundle\Traits;

use DoctrineExtensions\Taggable\Taggable;
use Doctrine\Common\Collections\ArrayCollection;
use Fogs\TaggingBundle\Service\TagManager;


trait TaggableTrait  
{
	private $tags;
	
	public function getTags()
	{
		if (!$this->tags) {
			$this->tags = new ArrayCollection();
			if ($this->tagManager) {
				$this->tagManager->loadTagging($this);
			}
		}
	
		return $this->tags;
	}
	
	/**
	 * @param array $tags
	 */
	
	public function setTags(array $tags)
	{
		$this->tags = new ArrayCollection($tags);
		if ($this->tagManager) {
			$this->tagManager->markDirty($this);
		}
	}
	
	public function getTaggableType()
	{
		return get_class($this);
	}
	
	public function getTaggableId()
	{
		return $this->getId();
	}
	
	/**
	 * @var TagManager
	 */
	protected $tagManager;
	
	public function setTagManager(TagManager $tagManager)
	{
		$this->tagManager = $tagManager;
	}
	
}

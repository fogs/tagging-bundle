<?php

namespace Fogs\TaggingBundle\Form;

use Symfony\Component\Form\AbstractType;
use Symfony\Component\Form\FormBuilderInterface;
use DoctrineExtensions\Taggable\TagManager;

class TagsType extends AbstractType
{
	/**
	 * @var TagManager
	 */
	protected $tagManager;
	
	public function __construct(TagManager $tagManager)
	{
		$this->tagManager = $tagManager;
	}

	public function buildForm(FormBuilderInterface $builder, array $options)
	{
		$transformer = new TagsTransformer($this->tagManager);
		$builder->addModelTransformer($transformer);
	}

	public function getParent()
	{
		return 'Symfony\Component\Form\Extension\Core\Type\TextType';
	}

	public function getName()
	{
		return 'tags';
	}
}

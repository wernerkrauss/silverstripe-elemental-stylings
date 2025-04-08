<?php

namespace Fractas\ElementalStylings;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class StylingSize extends \SilverStripe\Core\Extension
{
    private static $db = [
        'Size' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static $singular_name = 'Size';

    /**
     * @var string
     */
    private static $plural_name = 'Sizes';

    /**
     * @config
     *
     * @var array
     */
    private static $size = [];

    public function getStylingSizeNice($key)
    {
        return (!empty($this->getOwner()->config()->get('size')[$key])) ? $this->getOwner()->config()->get('size')[$key] : $key;
    }

    public function getStylingSizeData()
    {
        return \SilverStripe\Model\ArrayData::create([
           'Label' => self::$singular_name,
           'Value' => $this->getStylingSizeNice($this->getOwner()->Size),
       ]);
    }

    /**
     * @return string
     */
    public function getSizeVariant()
    {
        $size = $this->getOwner()->Size;
        $sizes = $this->getOwner()->config()->get('size');

        if (isset($sizes[$size])) {
            $size = strtolower($size);
        } else {
            $size = '';
        }

        return 'size-'.$size;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $size = $this->getOwner()->config()->get('size');
        if ($size && count($size) > 1) {
            $fields->addFieldsToTab('Root.Styling', DropdownField::create('Size', _t(self::class.'.SIZE', 'Size'), $size));
        } else {
            $fields->removeByName('Size');
        }

        return $fields;
    }

    public function populateDefaults()
    {
        $size = $this->getOwner()->config()->get('size');
        $size = reset($size);

        $this->getOwner()->Size = $size;
    }
}

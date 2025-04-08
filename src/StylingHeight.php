<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class StylingHeight extends \SilverStripe\Core\Extension
{
    private static $db = [
        'Height' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static $singular_name = 'Height';

    /**
     * @var string
     */
    private static $plural_name = 'Heights';

    /**
     * @config
     *
     * @var array
     */
    private static $height = [];

    public function getStylingHeightNice($key)
    {
        return (!empty($this->getOwner()->config()->get('height')[$key])) ? $this->getOwner()->config()->get('height')[$key] : $key;
    }

    public function getStylingHeightData()
    {
        return \SilverStripe\Model\ArrayData::create([
           'Label' => self::$singular_name,
           'Value' => $this->getStylingHeightNice($this->getOwner()->Height),
       ]);
    }

    /**
     * @return string
     */
    public function getHeightVariant()
    {
        $height = $this->getOwner()->Height;
        $heights = $this->getOwner()->config()->get('height');

        if (isset($heights[$height])) {
            $height = strtolower($height);
        } else {
            $height = '';
        }

        return 'height-'.$height;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $height = $this->getOwner()->config()->get('height');
        if ($height && count($height) > 1) {
            $fields->addFieldsToTab('Root.Styling', StylingOptionsetField::create('Height', _t(self::class.'.HEIGHT', 'Height Size'), $height));
        } else {
            $fields->removeByName('Height');
        }

        return $fields;
    }

    public function populateDefaults()
    {
        $height = $this->getOwner()->config()->get('height');
        $height = reset($height);

        $this->getOwner()->Height = $height;
    }
}

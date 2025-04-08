<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class StylingWidth extends \SilverStripe\Core\Extension
{
    private static $db = [
        'Width' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static $singular_name = 'Width';

    /**
     * @var string
     */
    private static $plural_name = 'Widths';

    /**
     * @config
     *
     * @var array
     */
    private static $width = [];

    public function getStylingWidthNice($key)
    {
        return (!empty($this->getOwner()->config()->get('width')[$key])) ? $this->getOwner()->config()->get('width')[$key] : $key;
    }

    public function getStylingWidthData()
    {
        return \SilverStripe\Model\ArrayData::create([
           'Label' => self::$singular_name,
           'Value' => $this->getStylingWidthNice($this->getOwner()->Width),
       ]);
    }

    /**
     * @return string
     */
    public function getWidthVariant()
    {
        $width = $this->getOwner()->Width;
        $widths = $this->getOwner()->config()->get('width');

        if (isset($widths[$width])) {
            $width = strtolower($width);
        } else {
            $width = '';
        }

        return $width;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $width = $this->getOwner()->config()->get('width');
        if ($width && count($width) > 1) {
            $fields->addFieldsToTab('Root.Styling', StylingOptionsetField::create('Width', _t(self::class.'.WIDTH', 'Width Size'), $width));
        } else {
            $fields->removeByName('Width');
        }

        return $fields;
    }

    public function populateDefaults()
    {
        $width = $this->getOwner()->config()->get('width');
        $width = reset($width);

        $this->getOwner()->Width = $width;
    }
}

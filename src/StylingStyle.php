<?php

namespace Fractas\ElementalStylings;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class StylingStyle extends \SilverStripe\Core\Extension
{
    /**
     * @var string
     */
    private static $singular_name = 'Style';

    /**
     * @var string
     */
    private static $plural_name = 'Styles';

    /**
     * @config
     *
     * @var array
     */
    private static $style = [];

    public function getStylingStyleNice($key)
    {
        return (empty($this->getOwner()->config()->get('styles')[$key])) ? $key : $this->getOwner()->config()->get('styles')[$key];
    }

    public function getStylingStyleData()
    {
        return \SilverStripe\Model\ArrayData::create([
               'Label' => self::$singular_name,
               'Value' => $this->getStylingStyleNice($this->getOwner()->Style),
           ]);
    }

    public function getStylingTitleData()
    {
        return \SilverStripe\Model\ArrayData::create([
               'Label' => 'Title',
               'Value' => $this->getOwner()->obj('ShowTitle')->Nice(),
           ]);
    }

    /**
     * @return string
     */
    public function updateStyleVariant(&$style)
    {
        $style = isset($style) ? strtolower((string) $style) : '';
        $style = 'style-'.$style;

        return $style;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $style = $this->getOwner()->config()->get('styles');
        if ($style && count($style) > 1) {
            $fields->addFieldsToTab('Root.Styling', DropdownField::create('Style', _t(self::class.'.STYLE', 'Style'), $style));
        } else {
            $fields->removeByName('Style');
        }

        return $fields;
    }

    public function populateDefaults()
    {
        $style = $this->getOwner()->config()->get('styles');
        $style = array_key_first($style);

        $this->getOwner()->Style = $style;
    }
}

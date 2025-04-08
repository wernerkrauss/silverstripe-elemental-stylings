<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class StylingTextAlign extends \SilverStripe\Core\Extension
{
    private static $db = [
        'TextAlign' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static $singular_name = 'Text Align';

    /**
     * @var string
     */
    private static $plural_name = 'Text Aligns';

    /**
     * @config
     *
     * @var array
     */
    private static $textalign = [];

    public function getStylingTextAlignNice($key)
    {
        return (!empty($this->getOwner()->config()->get('textalign')[$key])) ? $this->getOwner()->config()->get('textalign')[$key] : $key;
    }

    public function getStylingTextAlignData()
    {
        return \SilverStripe\Model\ArrayData::create([
               'Label' => self::$singular_name,
               'Value' => $this->getStylingTextAlignNice($this->getOwner()->TextAlign),
           ]);
    }

    /**
     * @return string
     */
    public function getTextAlignVariant()
    {
        $textalign = $this->getOwner()->TextAlign;
        $textaligns = $this->getOwner()->config()->get('textalign');

        if (isset($textaligns[$textalign])) {
            $textalign = strtolower($textalign);
        } else {
            $textalign = '';
        }

        return 'textalign-'.$textalign;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('TextAlign');
        $textalign = $this->getOwner()->config()->get('textalign');
        if ($textalign && count($textalign) > 1) {
            $fields->addFieldsToTab(
                'Root.Styling',
                StylingOptionsetField::create('TextAlign', _t(self::class.'.TEXTALIGN', 'Text Align'), $textalign)
            );
        }

        return $fields;
    }

    public function populateDefaults()
    {
        $textalign = $this->getOwner()->config()->get('textalign');
        $textalign = key($textalign);

        $this->getOwner()->TextAlign = $textalign;
    }
}

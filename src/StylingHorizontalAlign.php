<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class StylingHorizontalAlign extends \SilverStripe\Core\Extension
{
    private static $db = [
        'HorAlign' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static $singular_name = 'Horizontal Align';

    /**
     * @var string
     */
    private static $plural_name = 'Horizontal Aligns';

    /**
     * @config
     *
     * @var array
     */
    private static $horalign = [];

    public function getStylingHorizontalAlignNice($key)
    {
        return (!empty($this->getOwner()->config()->get('horalign')[$key])) ? $this->getOwner()->config()->get('horalign')[$key] : $key;
    }

    public function getStylingHorizontalAlignData()
    {
        return \SilverStripe\Model\ArrayData::create([
               'Label' => self::$singular_name,
               'Value' => $this->getStylingHorizontalAlignNice($this->getOwner()->HorAlign),
           ]);
    }

    /**
     * @return string
     */
    public function getHorAlignVariant()
    {
        $horalign = $this->getOwner()->HorAlign;
        $horaligns = $this->getOwner()->config()->get('horalign');

        if (isset($horaligns[$horalign])) {
            $horalign = strtolower($horalign);
        } else {
            $horalign = '';
        }

        return 'horalign-'.$horalign;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('HorAlign');
        $horalign = $this->getOwner()->config()->get('horalign');
        if ($horalign && count($horalign) > 1) {
            $fields->addFieldsToTab(
                'Root.Styling',
                StylingOptionsetField::create('HorAlign', _t(self::class.'.HORIZONTALALIGN', 'Horizontal Align'), $horalign)
            );
        }

        return $fields;
    }

    public function populateDefaults()
    {
        $horalign = $this->getOwner()->config()->get('horalign');
        $horalign = key($horalign);

        $this->getOwner()->HorAlign = $horalign;
    }
}

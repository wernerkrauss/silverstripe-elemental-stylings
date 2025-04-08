<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class StylingVerticalAlign extends \SilverStripe\Core\Extension
{
    private static $db = [
        'VerAlign' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static $singular_name = 'Vertical Align';

    /**
     * @var string
     */
    private static $plural_name = 'Vertical Aligns';

    /**
     * @config
     *
     * @var array
     */
    private static $veralign = [];

    public function getStylingVerticalAlignNice($key)
    {
        return (!empty($this->getOwner()->config()->get('veralign')[$key])) ? $this->getOwner()->config()->get('veralign')[$key] : $key;
    }

    public function getStylingVerticalAlignData()
    {
        return \SilverStripe\Model\ArrayData::create([
           'Label' => self::$singular_name,
           'Value' => $this->getStylingVerticalAlignNice($this->getOwner()->VerAlign),
       ]);
    }

    /**
     * @return string
     */
    public function getVerAlignVariant()
    {
        $veralign = $this->getOwner()->VerAlign;
        $veraligns = $this->getOwner()->config()->get('veralign');

        if (isset($veraligns[$veralign])) {
            $veralign = strtolower($veralign);
        } else {
            $veralign = '';
        }

        return 'veralign-'.$veralign;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $fields->removeByName('VerAlign');
        $veralign = $this->getOwner()->config()->get('veralign');
        if ($veralign && count($veralign) > 1) {
            $fields->addFieldsToTab(
                'Root.Styling',
                StylingOptionsetField::create('VerAlign', _t(__CLASS__.'.VERTICALALIGN', 'Vertical Align'), $veralign)
            );
        }

        return $fields;
    }

    public function populateDefaults()
    {
        if ($this->getOwner()->config()->get('stop_veralign_inheritance')) {
            $veralign = $this->getOwner()->config()->get('veralign', Config::UNINHERITED);
        } else {
            $veralign = $this->getOwner()->config()->get('veralign');
        }

        $veralign = key($veralign);
        $this->getOwner()->VerAlign = $veralign;

        parent::populateDefaults();
    }
}

<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;


class StylingTextAlign extends Extension
{
    private static array $db = [
        'TextAlign' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static string $singular_name = 'Text Align';

    /**
     * @var string
     */
    private static string $plural_name = 'Text Aligns';

    /**
     * @config
     *
     * @var array
     */
    private static array $textalign = [];

    public function getStylingTextAlignNice(string $key):string
    {
        return (empty($this->getOwner()->config()->get('textalign')[$key])) ? $key : $this->getOwner()->config()->get('textalign')[$key];
    }

    public function getStylingTextAlignData(): ArrayData
    {
        return ArrayData::create([
               'Label' => self::$singular_name,
               'Value' => $this->getStylingTextAlignNice($this->getOwner()->TextAlign),
           ]);
    }

    /**
     * @return string
     */
    public function getTextAlignVariant(): string
    {
        $textalign = $this->getOwner()->TextAlign;
        $textaligns = $this->getOwner()->config()->get('textalign');

        $textalign = isset($textaligns[$textalign]) ? strtolower($textalign) : '';

        return 'textalign-'.$textalign;
    }

    public function updateCMSFields(FieldList $fields): FieldList
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

    public function populateDefaults(): void
    {
        $textalign = $this->getOwner()->config()->get('textalign');
        $textalign = key($textalign);

        $this->getOwner()->TextAlign = $textalign;
    }
}

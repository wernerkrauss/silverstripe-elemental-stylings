<?php

namespace Fractas\ElementalStylings;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;


class StylingStyle extends Extension
{
    /**
     * @var string
     */
    private static string $singular_name = 'Style';

    /**
     * @var string
     */
    private static string $plural_name = 'Styles';

    /**
     * @config
     *
     * @var array
     */
    private static array $style = [];

    public function getStylingStyleNice(string $key): string
    {
        return (empty($this->getOwner()->config()->get('styles')[$key])) ? $key : $this->getOwner()->config()->get('styles')[$key];
    }

    public function getStylingStyleData(): ArrayData
    {
        return ArrayData::create([
            'Label' => self::$singular_name,
            'Value' => $this->getStylingStyleNice($this->getOwner()->Style),
        ]);
    }

    public function getStylingTitleData(): ArrayData
    {
        return ArrayData::create([
            'Label' => 'Title',
            'Value' => $this->getOwner()->obj('ShowTitle')->Nice(),
        ]);
    }

    /**
     * @return string
     */
    public function updateStyleVariant(&$style): string
    {
        $style = isset($style) ? strtolower((string)$style) : '';
        $style = 'style-' . $style;

        return $style;
    }

    public function updateCMSFields(FieldList $fields): FieldList
    {
        $style = $this->getOwner()->config()->get('styles');
        if ($style && count($style) > 1) {
            $fields->addFieldsToTab('Root.Styling',
                DropdownField::create('Style', _t(self::class . '.STYLE', 'Style'), $style));
        } else {
            $fields->removeByName('Style');
        }

        return $fields;
    }

    public function populateDefaults(): void
    {
        $style = $this->getOwner()->config()->get('styles');
        $style = array_key_first($style);

        $this->getOwner()->Style = $style;
    }
}

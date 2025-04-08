<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;


class StylingWidth extends Extension
{
    private static array $db = [
        'Width' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static string $singular_name = 'Width';

    /**
     * @var string
     */
    private static string $plural_name = 'Widths';

    /**
     * @config
     *
     * @var array
     */
    private static array $width = [];

    public function getStylingWidthNice(string $key): string
    {
        return (empty($this->getOwner()->config()->get('width')[$key])) ? $key : $this->getOwner()->config()->get('width')[$key];
    }

    public function getStylingWidthData(): ArrayData
    {
        return ArrayData::create([
            'Label' => self::$singular_name,
            'Value' => $this->getStylingWidthNice($this->getOwner()->Width),
        ]);
    }

    /**
     * @return string
     */
    public function getWidthVariant(): string
    {
        $width = $this->getOwner()->Width;
        $widths = $this->getOwner()->config()->get('width');

        $width = isset($widths[$width]) ? strtolower($width) : '';

        return $width;
    }

    public function updateCMSFields(FieldList $fields): FieldList
    {
        $width = $this->getOwner()->config()->get('width');
        if ($width && count($width) > 1) {
            $fields->addFieldsToTab('Root.Styling',
                StylingOptionsetField::create('Width', _t(self::class . '.WIDTH', 'Width Size'), $width));
        } else {
            $fields->removeByName('Width');
        }

        return $fields;
    }

    public function populateDefaults(): void
    {
        $width = $this->getOwner()->config()->get('width');
        $width = reset($width);

        $this->getOwner()->Width = $width;
    }
}

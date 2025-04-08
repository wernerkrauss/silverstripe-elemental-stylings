<?php

namespace Fractas\ElementalStylings;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;


class StylingSize extends Extension
{
    private static array $db = [
        'Size' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static string $singular_name = 'Size';

    /**
     * @var string
     */
    private static string $plural_name = 'Sizes';

    /**
     * @config
     *
     * @var array
     */
    private static array $size = [];

    public function getStylingSizeNice(string $key): string
    {
        return (empty($this->getOwner()->config()->get('size')[$key])) ? $key : $this->getOwner()->config()->get('size')[$key];
    }

    public function getStylingSizeData(): ArrayData
    {
        return ArrayData::create([
            'Label' => self::$singular_name,
            'Value' => $this->getStylingSizeNice($this->getOwner()->Size),
        ]);
    }

    /**
     * @return string
     */
    public function getSizeVariant(): string
    {
        $size = $this->getOwner()->Size;
        $sizes = $this->getOwner()->config()->get('size');

        $size = isset($sizes[$size]) ? strtolower($size) : '';

        return 'size-' . $size;
    }

    public function updateCMSFields(FieldList $fields): FieldList
    {
        $size = $this->getOwner()->config()->get('size');
        if ($size && count($size) > 1) {
            $fields->addFieldsToTab('Root.Styling',
                DropdownField::create('Size', _t(self::class . '.SIZE', 'Size'), $size));
        } else {
            $fields->removeByName('Size');
        }

        return $fields;
    }

    public function populateDefaults(): void
    {
        $size = $this->getOwner()->config()->get('size');
        $size = reset($size);

        $this->getOwner()->Size = $size;
    }
}

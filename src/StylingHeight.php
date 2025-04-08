<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;


class StylingHeight extends Extension
{
    private static array $db = [
        'Height' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static string $singular_name = 'Height';

    /**
     * @var string
     */
    private static string $plural_name = 'Heights';

    /**
     * @config
     *
     * @var array
     */
    private static array $height = [];

    public function getStylingHeightNice(string $key): string
    {
        return (empty($this->getOwner()->config()->get('height')[$key])) ? $key : $this->getOwner()->config()->get('height')[$key];
    }

    public function getStylingHeightData(): ArrayData
    {
        return ArrayData::create([
            'Label' => self::$singular_name,
            'Value' => $this->getStylingHeightNice($this->getOwner()->Height),
        ]);
    }

    /**
     * @return string
     */
    public function getHeightVariant(): string
    {
        $height = $this->getOwner()->Height;
        $heights = $this->getOwner()->config()->get('height');

        $height = isset($heights[$height]) ? strtolower($height) : '';

        return 'height-' . $height;
    }

    public function updateCMSFields(FieldList $fields): FieldList
    {
        $height = $this->getOwner()->config()->get('height');
        if ($height && count($height) > 1) {
            $fields->addFieldsToTab('Root.Styling',
                StylingOptionsetField::create('Height', _t(self::class . '.HEIGHT', 'Height Size'), $height));
        } else {
            $fields->removeByName('Height');
        }

        return $fields;
    }

    public function populateDefaults(): void
    {
        $height = $this->getOwner()->config()->get('height');
        $height = reset($height);

        $this->getOwner()->Height = $height;
    }
}

<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;


class StylingHorizontalAlign extends Extension
{
    /**
     * @config
     */
    private static array $db = [
        'HorAlign' => 'Varchar(255)',
    ];

    /**
     * @var string
     * @config
     */
    private static string $singular_name = 'Horizontal Align';

    /**
     * @var string
     * @config
     */
    private static string $plural_name = 'Horizontal Aligns';

    /**
     * @config
     *
     * @var array
     */
    private static array $horalign = [];

    public function getStylingHorizontalAlignNice(string $key): string
    {
        return (empty($this->getOwner()->config()->get('horalign')[$key])) ? $key : $this->getOwner()->config()->get('horalign')[$key];
    }

    public function getStylingHorizontalAlignData(): ArrayData
    {
        return ArrayData::create([
            'Label' => self::$singular_name,
            'Value' => $this->getStylingHorizontalAlignNice($this->getOwner()->HorAlign),
        ]);
    }

    /**
     * @return string
     */
    public function getHorAlignVariant(): string
    {
        $horalign = $this->getOwner()->HorAlign;
        $horaligns = $this->getOwner()->config()->get('horalign');

        $horalign = isset($horaligns[$horalign]) ? strtolower($horalign) : '';

        return 'horalign-' . $horalign;
    }

    public function updateCMSFields(FieldList $fields): FieldList
    {
        $fields->removeByName('HorAlign');
        $horalign = $this->getOwner()->config()->get('horalign');
        if ($horalign && count($horalign) > 1) {
            $fields->addFieldsToTab(
                'Root.Styling',
                StylingOptionsetField::create('HorAlign', _t(self::class . '.HORIZONTALALIGN', 'Horizontal Align'),
                    $horalign)
            );
        }

        return $fields;
    }

    public function populateDefaults(): void
    {
        $horalign = $this->getOwner()->config()->get('horalign');
        $horalign = key($horalign);

        $this->getOwner()->HorAlign = $horalign;
    }
}

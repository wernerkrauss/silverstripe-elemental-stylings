<?php

namespace Fractas\ElementalStylings;

use Fractas\ElementalStylings\Forms\StylingOptionsetField;
use SilverStripe\Core\Extension;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;


class StylingVerticalAlign extends Extension
{
    /**
     * @config
     */
    private static array $db = [
        'VerAlign' => 'Varchar(255)',
    ];

    /**
     * @var string
     * @config
     */
    private static string $singular_name = 'Vertical Align';

    /**
     * @var string
     * @config
     */
    private static string $plural_name = 'Vertical Aligns';

    /**
     * @config
     *
     * @var array
     */
    private static array $veralign = [];

    public function getStylingVerticalAlignNice(string $key): string
    {
        return (empty($this->getOwner()->config()->get('veralign')[$key])) ? $key : $this->getOwner()->config()->get('veralign')[$key];
    }

    public function getStylingVerticalAlignData(): ArrayData
    {
        return ArrayData::create([
            'Label' => self::$singular_name,
            'Value' => $this->getStylingVerticalAlignNice($this->getOwner()->VerAlign),
        ]);
    }

    /**
     * @return string
     */
    public function getVerAlignVariant(): string
    {
        $veralign = $this->getOwner()->VerAlign;
        $veraligns = $this->getOwner()->config()->get('veralign');

        $veralign = isset($veraligns[$veralign]) ? strtolower($veralign) : '';

        return 'veralign-' . $veralign;
    }

    public function updateCMSFields(FieldList $fields): FieldList
    {
        $fields->removeByName('VerAlign');
        $veralign = $this->getOwner()->config()->get('veralign');
        if ($veralign && count($veralign) > 1) {
            $fields->addFieldsToTab(
                'Root.Styling',
                StylingOptionsetField::create('VerAlign', _t(self::class . '.VERTICALALIGN', 'Vertical Align'),
                    $veralign)
            );
        }

        return $fields;
    }

    public function populateDefaults(): void
    {
        if ($this->getOwner()->config()->get('stop_veralign_inheritance')) {
            $veralign = $this->getOwner()->config()->get('veralign', Config::UNINHERITED);
        } else {
            $veralign = $this->getOwner()->config()->get('veralign');
        }

        $veralign = key($veralign);
        $this->getOwner()->VerAlign = $veralign;
    }
}

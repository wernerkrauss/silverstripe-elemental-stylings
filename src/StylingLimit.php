<?php

namespace Fractas\ElementalStylings;

use SilverStripe\Core\Extension;
use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\Model\ArrayData;

class StylingLimit extends Extension
{
    private static array $db = [
        'Limit' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static string $singular_name = 'Limit';

    /**
     * @var string
     */
    private static string $plural_name = 'Limits';

    /**
     * @config
     *
     * @var array
     */
    private static array $limit = [];

    public function getStylingLimitNice($key)
    {
        return (empty($this->getOwner()->config()->get('limit')[$key])) ? $key : $this->getOwner()->config()->get('limit')[$key];
    }

    public function getStylingLimitData(): ArrayData
    {
        return ArrayData::create([
           'Label' => self::$singular_name,
           'Value' => $this->getStylingLimitNice($this->getOwner()->Limit),
       ]);
    }

    /**
     * @return string
     */
    public function getLimitVariant(): string
    {
        $limit = $this->getOwner()->Limit;
        $limits = $this->getOwner()->config()->get('limit');

        $limit = isset($limits[$limit]) ? strtolower($limit) : '';

        return 'limit-'.$limit;
    }

    public function updateCMSFields(FieldList $fields): FieldList
    {
        $limit = $this->getOwner()->config()->get('limit');
        if ($limit && count($limit) > 1) {
            $fields->addFieldsToTab('Root.Styling', DropdownField::create('Limit', _t(self::class.'.LIMIT', 'Limit'), $limit));
        } else {
            $fields->removeByName('Limit');
        }

        return $fields;
    }

    public function populateDefaults(): void
    {
        $limit = $this->getOwner()->config()->get('limit');
        $limit = reset($limit);

        $this->getOwner()->Limit = $limit;
    }
}

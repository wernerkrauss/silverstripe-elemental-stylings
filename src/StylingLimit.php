<?php

namespace Fractas\ElementalStylings;

use SilverStripe\Forms\DropdownField;
use SilverStripe\Forms\FieldList;
use SilverStripe\ORM\DataExtension;
use SilverStripe\View\ArrayData;

class StylingLimit extends \SilverStripe\Core\Extension
{
    private static $db = [
        'Limit' => 'Varchar(255)',
    ];

    /**
     * @var string
     */
    private static $singular_name = 'Limit';

    /**
     * @var string
     */
    private static $plural_name = 'Limits';

    /**
     * @config
     *
     * @var array
     */
    private static $limit = [];

    public function getStylingLimitNice($key)
    {
        return (empty($this->getOwner()->config()->get('limit')[$key])) ? $key : $this->getOwner()->config()->get('limit')[$key];
    }

    public function getStylingLimitData()
    {
        return \SilverStripe\Model\ArrayData::create([
           'Label' => self::$singular_name,
           'Value' => $this->getStylingLimitNice($this->getOwner()->Limit),
       ]);
    }

    /**
     * @return string
     */
    public function getLimitVariant()
    {
        $limit = $this->getOwner()->Limit;
        $limits = $this->getOwner()->config()->get('limit');

        $limit = isset($limits[$limit]) ? strtolower($limit) : '';

        return 'limit-'.$limit;
    }

    public function updateCMSFields(FieldList $fields)
    {
        $limit = $this->getOwner()->config()->get('limit');
        if ($limit && count($limit) > 1) {
            $fields->addFieldsToTab('Root.Styling', DropdownField::create('Limit', _t(self::class.'.LIMIT', 'Limit'), $limit));
        } else {
            $fields->removeByName('Limit');
        }

        return $fields;
    }

    public function populateDefaults()
    {
        $limit = $this->getOwner()->config()->get('limit');
        $limit = reset($limit);

        $this->getOwner()->Limit = $limit;
    }
}

<?php
declare(strict_types=1);

namespace PhoneFinder;

class Matcher
{
    /**
     * Parse phone metadata
     *
     * @var array $meta
     */
    protected $meta;

    /**
     * Matcher constructor.
     * @param string $countryCode
     */
    public function __construct($countryCode = 'RU')
    {
        $this->loadMetaFormat($countryCode);
    }

    /**
     * Get phone numbers array from string
     *
     * @param $string
     * @return mixed
     */
    public function findNumbers($string) : array
    {
        return $this->prepareNumbers($this->getNumbersFromString($string));
    }

    /**
     * @param $numbers
     * @return mixed
     */
    protected function prepareNumbers(array $numbers) : array
    {
        foreach ($numbers as $key => $number) {
            $numbers[$key] = preg_replace('/-/', '',
                preg_replace('/^\\d{1}/', $this->meta['defaultCountryCode'], $number));
        }
        return array_unique($numbers);
    }

    /**
     * Extract numbers from string
     *
     * @param $string
     * @return mixed
     */
    protected function getNumbersFromString($string) : array
    {
        $countryCodePrefix = implode('|', $this->meta['countryCode']);
        preg_match_all("/($countryCodePrefix)" . $this->meta['pattern'] . "/", $string, $phones);
        return $phones[0];
    }

    /**
     * Load metadata file by country code
     *
     * @param string $countryCode
     * @throws \Exception
     */
    protected function loadMetaFormat($countryCode = 'RU')
    {
        $fileName = dirname(__FILE__) . '/meta/Format_' . $countryCode . '.php';

        if (!is_readable($fileName)) {
            throw new \Exception('missing metadata: ' . $fileName);
        }

        $this->meta = require $fileName;
    }
}
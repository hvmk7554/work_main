<?php

namespace App\Console\Commands\Notification\PreClassNotification;

use Exception;
use Illuminate\Console\Command;
use Illuminate\Support\Str;
use League\Csv\Reader;

class MappingPhoneNumber extends Command
{
    protected $signature = 'notification:pre-class-notification:mapping-phone-number';

    protected $description = 'Command description';

    public function handle(): int
    {
        $phoneBook = $this->getPhoneBook();
        $subscriptions = $this->getSubscriptions();

        echo 'classin_id,classin_course_id,phone_number' . PHP_EOL;

        foreach ($subscriptions as $subscription) {
            $phoneNumber = $phoneBook[$subscription['classin_id']];
            if (!$phoneNumber) {
                throw new Exception(sprintf('Phone number for `%s` not found.', $subscription['classin_id']));
            }

            echo sprintf('%s,%s,%s', $subscription['classin_id'], $subscription['classin_course_id'], $this->reformatPhoneNumber($phoneNumber)) . PHP_EOL;
        }

        return 0;
    }

    private function getPhoneBook(): array
    {
        $phoneBook = [];

        $path = realpath(__DIR__ . '/preclassnotification-phonebook.csv');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv->getRecords() as $record) {
            $classinId = $record['classin_id'];
            $phoneNumber = $record['phone_number'];

            $phoneBook[$classinId] = $phoneNumber;
        }

        return $phoneBook;
    }

    private function getSubscriptions(): array
    {
        $output = [];

        $path = realpath(__DIR__ . '/preclassnotification-subscriptions.csv');
        $csv = Reader::createFromPath($path, 'r');
        $csv->setHeaderOffset(0);

        foreach ($csv->getRecords() as $record) {
            $output[] = [
                'classin_id' => $record['classin_id'],
                'classin_course_id' => $record['classin_course_id'],
            ];
        }

        return $output;
    }

    private function reformatPhoneNumber(string $phoneNumber): string
    {
        if (strlen($phoneNumber) == 9 && Str::startsWith($phoneNumber, '0') == false) {
            return '0' . $phoneNumber;
        }

        if (strlen($phoneNumber) == 11 && Str::startsWith($phoneNumber, '84')) {
            return '+' . $phoneNumber;
        }

        return $phoneNumber;
    }
}

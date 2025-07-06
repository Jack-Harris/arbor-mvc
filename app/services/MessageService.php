<?php


class MessageService {

    public static function countUniqueRecipients(): int {
        return (new Message())->countUniqueRecipients();
    }

    public static function getMessageStatusBreakdown(): array {
        return (new Message())->getMessageStatusBreakdown();
    }

    public static function getProviderBreakdown(): array {
        return (new Message())->getProviderBreakdown();
    }

    public static function countMessagesBySchool(): array {
        return (new Message())->getMessagesBySchool();
    }

    public static function getMessageTimeline(): array {
        return (new Message())->getMessageTimeline();
    }

    public static function getReadRate(): float {
        return (new Message())->getReadRate();
    }
}
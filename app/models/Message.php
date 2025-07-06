<?php 

class Message extends Model {

    public string $message_id;
    public int $school_id;
    public int $sender_id;
    public int $recipient_id;
    public int $provider_id;
    public string $subject;
    public string $message;
    public int $message_status_id;
    // @todo - should really be a DateTime.
    public string $timestamp;

    public function countUniqueRecipients(): int {
        $sql = 'SELECT COUNT(DISTINCT recipient_id) AS total FROM message';
        $result = $this->executeRaw($sql);
        return (int) ($result[0]['total'] ?? 0);
    }

    //@todo this could be cleaned up.
    public function getMessageStatusBreakdown(): array {
        $sql = 'SELECT message_status_id, COUNT(*) AS count FROM message GROUP BY message_status_id ORDER BY message_status_id DESC';
        $result = $this->executeRaw($sql);
        
        $counts = [
            MessageStatus::SENT => 0,
            MessageStatus::DELIVERED => 0,
            MessageStatus::FAILED => 0,
            MessageStatus::REJECTED => 0,
        ];

        foreach ($result as $row) {
            $statusId = (int) $row['message_status_id'];
            $counts[$statusId] = (int) $row['count'];
        }
        
        return $counts;
    }

    public function getProviderBreakdown(): array {
        $sql = 'SELECT provider_name, COUNT(*) AS count FROM message JOIN provider USING (provider_id) GROUP BY provider_id;';
        $result = $this->executeRaw($sql);

        $result = array_column($result, 'count', 'provider_name');

        return $result;
    }

    public function getMessagesBySchool(): array {
        $sql = 'SELECT school_id, COUNT(*) AS count FROM message JOIN teacher on sender_id = teacher_id GROUP BY school_id;';
        $result = $this->executeRaw($sql);

        $result = array_column($result, 'count', 'school_id');

        return $result;
    }

    public function getMessageTimeline(): array {
        $sql = 'SELECT DATE(timestamp) AS day, COUNT(*) AS count FROM message GROUP BY day ORDER BY day ASC;';
        $result = $this->executeRaw($sql);

        $result = array_column($result, 'count', 'day');

        return $result;
    }

    public function getReadRate(): float {
        $sql = 'SELECT 100.0 * SUM(message_status_id = ' . MessageStatus::DELIVERED . ') / COUNT(*) AS percent FROM message WHERE message_status_id != ' . MessageStatus::FAILED;
        $result = $this->executeRaw($sql);
        return $result[0]['percent'] ?? 0;
    }
}
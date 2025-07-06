<?php

class MessageStatus extends Model {

    const SENT = 1;
    const DELIVERED = 2;
    const REJECTED = 3;
    const FAILED = 4;

    public int $message_status_id;
    public string $message_status_name;
}
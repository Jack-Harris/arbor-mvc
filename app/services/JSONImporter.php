<?php

class JSONImporter {

    private array $dataToImport;

    public function __construct(string $filePath) {
        $json = file_get_contents($filePath);

        $this->dataToImport = json_decode($json, true);
    }

    /**
     * Assume that if there is already a message in the database, then the importer
     * has already ran and should not attempt to again.
     */
    public function hasDataBeenImported(): bool {
        return count((new Message())->executeRaw('SELECT message_id FROM message;'));
    }

    /**
     * Import the data in $dataToImport.
     * 
     * With each entity, try to first find an existing entity with the given unique identifier,
     * and only if one does not exist, create it.
     */
    public function import(): void {

        if ($this->hasDataBeenImported()) {
            echo 'Skipping import as the data has already been imported...' . PHP_EOL;
            return;
        }

        // Mock up a MAT to which all schools will belong.
        $multiAcademyTrust = (new MultiAcademyTrust())->findByAttributes(['multi_academy_trust_id' => 1], 1);

        if (empty($multiAcademyTrust)) {
            $multiAcademyTrust = new MultiAcademyTrust();
            $multiAcademyTrust->multi_academy_trust_id = 1;
            $multiAcademyTrust->multi_academy_trust_name = 'Multi-Academy Trust';
            $multiAcademyTrust->save();
        }

        foreach ($this->dataToImport as $row) {

            $school = (new School())->findByAttributes(['webhook' => $row['webhook']], 1);

            if (empty($school)) {
                $school = new School();
                $school->multi_academy_trust_id = 1;
                $school->school_name = '';
                $school->webhook = $row['webhook'];
                $school->save();
            }

            $recipient = (new Guardian())->findByAttributes(['phone_number' => $row['recipient']], 1);

            if (empty($recipient)) {
                $recipient = new Guardian();
                $recipient->forename = '';
                $recipient->surname = '';
                $recipient->phone_number = $row['recipient'];
                $recipient->save();
            }

            $sender = (new Teacher())->findByAttributes(['teacher_id' => $row['sender']], 1);

            if (empty($sender)) {   
                $sender = new Teacher();
                $sender->teacher_id = $row['sender'];
                $sender->school_id = $school->school_id;
                $sender->save();
            }

            $provider = (new Provider())->findByAttributes(['provider_name' => $row['extra']['provider']], 1);

            if (empty($provider)) {
                $provider = new Provider();
                $provider->provider_name = $row['extra']['provider'];
                $provider->save();
            }

            $student = (new Student())->findByAttributes(['student_id' => $row['extra']['student_id']], 1);

            if (empty($student)) {
                $student = new Student();
                $student->student_id = $row['extra']['student_id'];
                $student->guardian_id = $recipient->guardian_id;
                $student->school_id = $school->school_id;
                $student->save();
            }

            $messageStatus = (new MessageStatus())->findByAttributes(['message_status_name'=> $row['status']], 1);

            if (empty($messageStatus)) {
                $messageStatus = new MessageStatus();
                $messageStatus->message_status_name = $row['status'];
                $messageStatus->save();
            }

            $message = new Message();

            $message->message_id = $row['id'];
            $message->sender_id = $row['sender'];
            $message->recipient_id = $recipient->guardian_id;
            $message->provider_id = $provider->provider_id;
            $message->subject = $row['subject'];
            $message->message = $row['message'];
            $message->message_status_id = $messageStatus->message_status_id;
            $message->timestamp = (new DateTime($row['timestamp']))->format('Y-m-d H:i:s');

            $message->save();
        }
    }
}
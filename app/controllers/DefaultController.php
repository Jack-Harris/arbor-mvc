<?php

class DefaultController extends Controller {

    public function index(): void {
        $this->render("index", [
            'totalSentMessages' => count((new Message())->findByAttributes(['message_status_id' => MessageStatus::SENT])),
            'totalUniqueRecipients' => MessageService::countUniqueRecipients(),
            'readRate' => MessageService::getReadRate(),

            'messageStatusBreakdown' => MessageService::getMessageStatusBreakdown(),
            'schoolBreakdown' => MessageService::countMessagesBySchool(),
            'providerBreakdown' => MessageService::getProviderBreakdown(),
        
            'messageTimeline' => MessageService::getMessageTimeline(),
        ]);
    }
    
}